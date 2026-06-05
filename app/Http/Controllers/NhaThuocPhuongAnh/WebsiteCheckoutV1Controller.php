<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\CartItemV1;
use App\Models\CartV1;
use App\Models\OrderItemV1;
use App\Models\OrderStatusLogV1;
use App\Models\OrderV1;
use App\Models\ProductV1;
use App\Services\ProductPriceV1Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebsiteCheckoutV1Controller extends Controller
{
    protected int $cartCookieMinutes = 43200; // 30 ngày

    public function index(Request $request)
    {
        $cart = $this->getActiveCartByRequest($request);

        if (!$cart) {
            return redirect()
                ->route('website.cart.index')
                ->with('error', 'Giỏ hàng hiện đang trống.');
        }

        /*
        |--------------------------------------------------------------------------
        | Refresh giỏ hàng trước khi hiển thị checkout
        |--------------------------------------------------------------------------
        | Mục tiêu: nếu sản phẩm đang có Flash Sale thì giá checkout phải
        | được cập nhật lại đúng theo ProductPriceV1Service.
        */
        $this->refreshCartItems($cart);
        $cart = $this->loadCartForDisplay($cart->id);

        if ($cart->items->count() <= 0) {
            return redirect()
                ->route('website.cart.index')
                ->with('error', 'Giỏ hàng hiện đang trống.');
        }

        $branches = DB::table('branches')
            ->select('id', 'branch_name as name')
            ->orderBy('name', 'asc')
            ->get();

        $guestCheckoutInfo = session('guest_checkout_info', [
            'customer_name'  => '',
            'customer_phone' => '',
            'customer_email' => '',
            'province_name'  => 'Cao Bằng',
            'district_name'  => '',
            'ward_name'      => '',
            'address_detail' => '',
        ]);

        return view('website.checkout-v1.index', compact(
            'cart',
            'branches',
            'guestCheckoutInfo'
        ));
    }

    public function store(Request $request)
    {
        $cart = $this->getActiveCartByRequest($request);

        if (!$cart) {
            return redirect()
                ->route('website.cart.index')
                ->with('error', 'Không tìm thấy giỏ hàng để đặt đơn.');
        }

        /*
        |--------------------------------------------------------------------------
        | Refresh giỏ hàng trước khi tạo đơn
        |--------------------------------------------------------------------------
        | Đây là bước quan trọng nhất để order item snapshot lấy đúng giá
        | Flash Sale tại thời điểm khách đặt hàng.
        */
        $this->refreshCartItems($cart);
        $cart = $this->loadCartForDisplay($cart->id);

        if ($cart->items->count() <= 0) {
            return redirect()
                ->route('website.cart.index')
                ->with('error', 'Giỏ hàng hiện đang trống.');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_email' => ['nullable', 'email', 'max:255'],

            'receive_type' => ['required', 'in:1,2'],
            'id_branch_pickup' => ['nullable', 'integer', 'required_if:receive_type,2'],

            'province_name' => ['nullable', 'string', 'max:255'],
            'district_name' => ['nullable', 'string', 'max:255'],
            'ward_name' => ['nullable', 'string', 'max:255'],
            'address_detail' => ['nullable', 'string'],

            'payment_method' => ['required', 'in:1,2,3'],
            'note' => ['nullable', 'string'],
        ], [
            'customer_name.required' => 'Vui lòng nhập họ và tên.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'customer_email.email' => 'Email không đúng định dạng.',
            'receive_type.required' => 'Vui lòng chọn hình thức nhận hàng.',
            'id_branch_pickup.required_if' => 'Vui lòng chọn chi nhánh nhận hàng.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
        ]);

        $receiveType = (int) $validated['receive_type'];

        if ($receiveType === 1) {
            $request->validate([
                'province_name' => ['required', 'string', 'max:255'],
                'district_name' => ['required', 'string', 'max:255'],
                'ward_name' => ['required', 'string', 'max:255'],
                'address_detail' => ['required', 'string'],
            ], [
                'province_name.required' => 'Vui lòng nhập tỉnh/thành.',
                'district_name.required' => 'Vui lòng nhập quận/huyện.',
                'ward_name.required' => 'Vui lòng nhập phường/xã.',
                'address_detail.required' => 'Vui lòng nhập địa chỉ chi tiết.',
            ]);
        }

        session([
            'guest_checkout_info' => [
                'customer_name'  => $validated['customer_name'] ?? '',
                'customer_phone' => $validated['customer_phone'] ?? '',
                'customer_email' => $validated['customer_email'] ?? '',
                'province_name'  => $validated['province_name'] ?? 'Cao Bằng',
                'district_name'  => $validated['district_name'] ?? '',
                'ward_name'      => $validated['ward_name'] ?? '',
                'address_detail' => $validated['address_detail'] ?? '',
            ]
        ]);

        DB::beginTransaction();

        try {
            /*
            |--------------------------------------------------------------------------
            | Số tiền lấy từ cart đã được refresh bằng ProductPriceV1Service
            |--------------------------------------------------------------------------
            */
            $subtotalAmount = (float) $cart->subtotal_amount;
            $discountAmount = 0;
            $shippingFee = 0;
            $totalAmount = max(0, $subtotalAmount - $discountAmount + $shippingFee);

            $order = OrderV1::query()->create([
                'order_code' => $this->generateOrderCode(),
                'id_cart_v1' => $cart->id,
                'cart_token' => $cart->cart_token,

                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'] ?? null,

                'receive_type' => $receiveType,
                'id_branch_pickup' => $receiveType === 2 ? ($validated['id_branch_pickup'] ?? null) : null,
                'id_branch_process' => null,

                'province_name' => $receiveType === 1 ? ($validated['province_name'] ?? 'Cao Bằng') : null,
                'district_name' => $receiveType === 1 ? ($validated['district_name'] ?? null) : null,
                'ward_name' => $receiveType === 1 ? ($validated['ward_name'] ?? null) : null,
                'address_detail' => $receiveType === 1 ? ($validated['address_detail'] ?? null) : null,

                'note' => $validated['note'] ?? null,
                'payment_method' => (int) $validated['payment_method'],
                'payment_status' => 0,

                'subtotal_amount' => $subtotalAmount,
                'discount_amount' => $discountAmount,
                'shipping_fee' => $shippingFee,
                'total_amount' => $totalAmount,

                'order_status' => 0,
                'requires_consult' => 0,

                'sync_kiotviet_status' => 0,
            ]);

            foreach ($cart->items as $item) {
                OrderItemV1::query()->create([
                    'id_order_v1' => $order->id,
                    'id_product_v1' => $item->id_product_v1,
                    'kiotviet_product_id' => $item->kiotviet_product_id,
                    'product_code_snapshot' => $item->product_code_snapshot,
                    'product_name_snapshot' => $item->product_name_snapshot,
                    'product_image_snapshot' => $item->product_image_snapshot,

                    /*
                    |--------------------------------------------------------------------------
                    | Snapshot giá tại thời điểm đặt hàng
                    |--------------------------------------------------------------------------
                    | Giá này đã được refresh theo Flash Sale / giá sale thường / giá gốc.
                    */
                    'price_snapshot' => $item->price_snapshot,
                    'quantity' => $item->quantity,
                    'line_total' => $item->line_total,
                    'note' => null,
                ]);
            }

            OrderStatusLogV1::query()->create([
                'id_order_v1' => $order->id,
                'from_status' => null,
                'to_status' => 0,
                'note' => 'Đơn hàng được tạo từ website.',
                'changed_by' => null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Khóa giỏ hàng cũ sau khi đặt đơn
            |--------------------------------------------------------------------------
            */
            $cart->update([
                'status' => 1,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Tạo giỏ hàng mới
            |--------------------------------------------------------------------------
            */
            $newCartToken = Str::random(40);

            CartV1::query()->create([
                'cart_token' => $newCartToken,
                'status' => 0,
                'total_quantity' => 0,
                'subtotal_amount' => 0,
            ]);

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Gửi thông báo đặt hàng
            |--------------------------------------------------------------------------
            | Giữ nguyên logic cũ của bạn.
            */
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://outtech.io.vn/api/send-noti-order',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'name' => $validated['customer_name'] ?? 'Khách hàng',
                ],
            ]);

            curl_exec($curl);
            curl_close($curl);

            return redirect()
                ->route('website.checkout.success', ['orderCode' => $order->order_code])
                ->withCookie(cookie(
                    'cart_token',
                    $newCartToken,
                    $this->cartCookieMinutes,
                    '/',
                    null,
                    false,
                    false
                ));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Không thể tạo đơn hàng. ' . $e->getMessage());
        }
    }

    public function success($orderCode)
    {
        $order = OrderV1::query()
            ->with(['items'])
            ->where('order_code', $orderCode)
            ->firstOrFail();

        $order->items->transform(function ($item) {
            $item->image_url = $this->formatImageUrl($item->product_image_snapshot);
            return $item;
        });

        return view('website.checkout-v1.success', compact('order'));
    }

    protected function getActiveCartByRequest(Request $request): ?CartV1
    {
        $token = trim((string) $request->cookie('cart_token', ''));

        if ($token === '') {
            return null;
        }

        return CartV1::query()
            ->where('cart_token', $token)
            ->where('status', 0)
            ->first();
    }

    protected function refreshCartItems(CartV1 $cart): void
    {
        $items = CartItemV1::query()
            ->where('id_cart_v1', $cart->id)
            ->get();

        if ($items->isEmpty()) {
            $this->recalculateCart($cart);
            return;
        }

        $productIds = $items
            ->pluck('id_product_v1')
            ->unique()
            ->values()
            ->all();

        $products = ProductV1::query()
            ->whereIn('id', $productIds)
            ->where(function ($q) {
                $q->whereNull('status')->orWhere('status', 1);
            })
            ->where(function ($q) {
                $q->whereNull('is_active')->orWhere('is_active', 1);
            })
            ->get()
            ->keyBy('id');

        foreach ($items as $item) {
            $product = $products->get($item->id_product_v1);

            if (!$product) {
                $item->delete();
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Giá hiện tại của sản phẩm
            |--------------------------------------------------------------------------
            | Lấy qua ProductPriceV1Service để ưu tiên:
            | 1. Giá Flash Sale đang hiệu lực
            | 2. Giá sale thường
            | 3. Giá gốc
            */
            $displayPrice = $this->resolveDisplayPrice($product);

            $item->update([
                'kiotviet_product_id' => $product->id_product_kiotviet ?: null,
                'product_code_snapshot' => $product->code_product_kiovet,
                'product_name_snapshot' => $product->name,
                'product_image_snapshot' => $product->img_avatar,
                'price_snapshot' => $displayPrice,
                'line_total' => $displayPrice * (int) $item->quantity,
            ]);
        }

        $this->recalculateCart($cart);
    }

    protected function recalculateCart(CartV1 $cart): void
    {
        $totals = CartItemV1::query()
            ->where('id_cart_v1', $cart->id)
            ->selectRaw('COALESCE(SUM(quantity), 0) as total_quantity')
            ->selectRaw('COALESCE(SUM(line_total), 0) as subtotal_amount')
            ->first();

        $cart->update([
            'total_quantity' => (int) ($totals->total_quantity ?? 0),
            'subtotal_amount' => (float) ($totals->subtotal_amount ?? 0),
        ]);
    }

    protected function loadCartForDisplay(int $cartId): CartV1
    {
        $cart = CartV1::query()
            ->with(['items'])
            ->findOrFail($cartId);

        $cart->items->transform(function ($item) {
            $item->image_url = $this->formatImageUrl($item->product_image_snapshot);
            $item->detail_url = route('website.product-v1.show', ['id' => $item->id_product_v1]);

            return $item;
        });

        return $cart;
    }

    protected function resolveDisplayPrice(ProductV1 $product): float
    {
        $priceInfo = app(ProductPriceV1Service::class)->resolveForProduct($product);

        return (float) ($priceInfo['display_price'] ?? 0);
    }

    protected function formatImageUrl(?string $path): string
    {
        if (!$path) {
            return asset('assets/images/no-image.png');
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }

    protected function generateOrderCode(): string
    {
        do {
            $code = 'NTPA' . now()->format('ymdHis') . rand(10, 99);
        } while (OrderV1::query()->where('order_code', $code)->exists());

        return $code;
    }
}