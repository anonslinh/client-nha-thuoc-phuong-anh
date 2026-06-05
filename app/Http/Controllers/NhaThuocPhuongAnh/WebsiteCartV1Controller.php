<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\CartItemV1;
use App\Models\CartV1;
use App\Models\ProductV1;
use App\Services\ProductPriceV1Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebsiteCartV1Controller extends Controller
{
    protected int $cartCookieMinutes = 43200; // 30 ngày

    public function index(Request $request)
    {
        [$cart, $cookie] = $this->resolveCart($request, true);

        $this->refreshCartItems($cart);

        $cart = $this->loadCartForDisplay($cart->id);

        $response = response()->view('website.cart-v1.index', [
            'cart' => $cart,
        ]);

        return $this->attachCookieIfNeeded($response, $cookie);
    }

    public function summary(Request $request)
    {
        [$cart, $cookie] = $this->resolveCart($request, true);

        $this->refreshCartItems($cart);

        $cart = $this->loadCartForDisplay($cart->id);

        $response = response()->json([
            'status' => true,
            'data' => $this->buildCartSummary($cart),
        ]);

        return $this->attachCookieIfNeeded($response, $cookie);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:999'],
        ], [
            'product_id.required' => 'Thiếu sản phẩm cần thêm vào giỏ.',
            'quantity.min' => 'Số lượng tối thiểu là 1.',
            'quantity.max' => 'Số lượng tối đa là 999.',
        ]);

        $quantity = (int) ($validated['quantity'] ?? 1);

        [$cart, $cookie] = $this->resolveCart($request, true);

        $product = $this->findActiveProduct((int) $validated['product_id']);

        if (!$product) {
            $response = response()->json([
                'status' => false,
                'msg' => 'Sản phẩm không tồn tại hoặc đang tạm ngừng kinh doanh.',
            ], 422);

            return $this->attachCookieIfNeeded($response, $cookie);
        }

        DB::beginTransaction();

        try {
            $cartItem = CartItemV1::query()
                ->where('id_cart_v1', $cart->id)
                ->where('id_product_v1', $product->id)
                ->first();

            $displayPrice = $this->resolveDisplayPrice($product);

            if ($cartItem) {
                $newQty = (int) $cartItem->quantity + $quantity;

                if ($newQty > 999) {
                    $newQty = 999;
                }

                $cartItem->update([
                    'kiotviet_product_id' => $product->id_product_kiotviet ?: null,
                    'product_code_snapshot' => $product->code_product_kiovet,
                    'product_name_snapshot' => $product->name,
                    'product_image_snapshot' => $product->img_avatar,
                    'price_snapshot' => $displayPrice,
                    'quantity' => $newQty,
                    'line_total' => $displayPrice * $newQty,
                ]);
            } else {
                CartItemV1::query()->create([
                    'id_cart_v1' => $cart->id,
                    'id_product_v1' => $product->id,
                    'kiotviet_product_id' => $product->id_product_kiotviet ?: null,
                    'product_code_snapshot' => $product->code_product_kiovet,
                    'product_name_snapshot' => $product->name,
                    'product_image_snapshot' => $product->img_avatar,
                    'price_snapshot' => $displayPrice,
                    'quantity' => $quantity,
                    'line_total' => $displayPrice * $quantity,
                ]);
            }

            $this->recalculateCart($cart);

            DB::commit();

            $cart = $this->loadCartForDisplay($cart->id);

            $response = response()->json([
                'status' => true,
                'msg' => 'Đã thêm sản phẩm vào giỏ hàng.',
                'data' => $this->buildCartSummary($cart),
            ]);

            return $this->attachCookieIfNeeded($response, $cookie);
        } catch (\Throwable $e) {
            DB::rollBack();

            $response = response()->json([
                'status' => false,
                'msg' => 'Không thể thêm sản phẩm vào giỏ hàng.',
                'error' => $e->getMessage(),
            ], 500);

            return $this->attachCookieIfNeeded($response, $cookie);
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'item_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ], [
            'item_id.required' => 'Thiếu dòng sản phẩm cần cập nhật.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.min' => 'Số lượng tối thiểu là 1.',
            'quantity.max' => 'Số lượng tối đa là 999.',
        ]);

        [$cart, $cookie] = $this->resolveCart($request, true);

        $cartItem = CartItemV1::query()
            ->where('id_cart_v1', $cart->id)
            ->where('id', (int) $validated['item_id'])
            ->first();

        if (!$cartItem) {
            $response = response()->json([
                'status' => false,
                'msg' => 'Không tìm thấy sản phẩm trong giỏ hàng.',
            ], 404);

            return $this->attachCookieIfNeeded($response, $cookie);
        }

        $product = $this->findActiveProduct((int) $cartItem->id_product_v1);

        if (!$product) {
            $response = response()->json([
                'status' => false,
                'msg' => 'Sản phẩm không còn khả dụng để cập nhật.',
            ], 422);

            return $this->attachCookieIfNeeded($response, $cookie);
        }

        DB::beginTransaction();

        try {
            $quantity = (int) $validated['quantity'];
            $displayPrice = $this->resolveDisplayPrice($product);

            $cartItem->update([
                'kiotviet_product_id' => $product->id_product_kiotviet ?: null,
                'product_code_snapshot' => $product->code_product_kiovet,
                'product_name_snapshot' => $product->name,
                'product_image_snapshot' => $product->img_avatar,
                'price_snapshot' => $displayPrice,
                'quantity' => $quantity,
                'line_total' => $displayPrice * $quantity,
            ]);

            $this->recalculateCart($cart);

            DB::commit();

            $cart = $this->loadCartForDisplay($cart->id);

            $response = response()->json([
                'status' => true,
                'msg' => 'Đã cập nhật giỏ hàng.',
                'data' => $this->buildCartSummary($cart),
            ]);

            return $this->attachCookieIfNeeded($response, $cookie);
        } catch (\Throwable $e) {
            DB::rollBack();

            $response = response()->json([
                'status' => false,
                'msg' => 'Không thể cập nhật giỏ hàng.',
                'error' => $e->getMessage(),
            ], 500);

            return $this->attachCookieIfNeeded($response, $cookie);
        }
    }

    public function remove(Request $request)
    {
        $validated = $request->validate([
            'item_id' => ['required', 'integer'],
        ], [
            'item_id.required' => 'Thiếu dòng sản phẩm cần xóa.',
        ]);

        [$cart, $cookie] = $this->resolveCart($request, true);

        $cartItem = CartItemV1::query()
            ->where('id_cart_v1', $cart->id)
            ->where('id', (int) $validated['item_id'])
            ->first();

        if (!$cartItem) {
            $response = response()->json([
                'status' => false,
                'msg' => 'Không tìm thấy sản phẩm trong giỏ hàng.',
            ], 404);

            return $this->attachCookieIfNeeded($response, $cookie);
        }

        DB::beginTransaction();

        try {
            $cartItem->delete();

            $this->recalculateCart($cart);

            DB::commit();

            $cart = $this->loadCartForDisplay($cart->id);

            $response = response()->json([
                'status' => true,
                'msg' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
                'data' => $this->buildCartSummary($cart),
            ]);

            return $this->attachCookieIfNeeded($response, $cookie);
        } catch (\Throwable $e) {
            DB::rollBack();

            $response = response()->json([
                'status' => false,
                'msg' => 'Không thể xóa sản phẩm khỏi giỏ hàng.',
                'error' => $e->getMessage(),
            ], 500);

            return $this->attachCookieIfNeeded($response, $cookie);
        }
    }

    public function clear(Request $request)
    {
        [$cart, $cookie] = $this->resolveCart($request, true);

        DB::beginTransaction();

        try {
            CartItemV1::query()
                ->where('id_cart_v1', $cart->id)
                ->delete();

            $cart->update([
                'total_quantity' => 0,
                'subtotal_amount' => 0,
            ]);

            DB::commit();

            $cart = $this->loadCartForDisplay($cart->id);

            $response = response()->json([
                'status' => true,
                'msg' => 'Đã xóa toàn bộ giỏ hàng.',
                'data' => $this->buildCartSummary($cart),
            ]);

            return $this->attachCookieIfNeeded($response, $cookie);
        } catch (\Throwable $e) {
            DB::rollBack();

            $response = response()->json([
                'status' => false,
                'msg' => 'Không thể xóa toàn bộ giỏ hàng.',
                'error' => $e->getMessage(),
            ], 500);

            return $this->attachCookieIfNeeded($response, $cookie);
        }
    }

    protected function resolveCart(Request $request, bool $createIfMissing = true): array
    {
        $cookie = null;
        $token = trim((string) $request->cookie('cart_token', ''));

        $cart = null;

        if ($token !== '') {
            $cart = CartV1::query()
                ->where('cart_token', $token)
                ->where('status', 0)
                ->first();
        }

        if (!$cart && !$createIfMissing) {
            return [null, null];
        }

        if (!$cart && $createIfMissing) {
            $token = Str::random(40);

            $cart = CartV1::query()->create([
                'cart_token' => $token,
                'status' => 0,
                'total_quantity' => 0,
                'subtotal_amount' => 0,
            ]);

            $cookie = cookie(
                'cart_token',
                $token,
                $this->cartCookieMinutes,
                '/',
                null,
                false,
                false
            );
        }

        return [$cart, $cookie];
    }

    protected function findActiveProduct(int $productId): ?ProductV1
    {
        return ProductV1::query()
            ->where('id', $productId)
            ->where(function ($q) {
                $q->whereNull('status')->orWhere('status', 1);
            })
            ->where(function ($q) {
                $q->whereNull('is_active')->orWhere('is_active', 1);
            })
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

        $productIds = $items->pluck('id_product_v1')->unique()->values()->all();

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

    protected function buildCartSummary(CartV1 $cart): array
    {
        return [
            'cart_id' => $cart->id,
            'cart_token' => $cart->cart_token,
            'total_quantity' => (int) $cart->total_quantity,
            'subtotal_amount' => (float) $cart->subtotal_amount,
            'subtotal_amount_format' => number_format((float) $cart->subtotal_amount, 0, ',', '.') . 'đ',
            'total_items' => (int) $cart->items->count(),
            'items' => $cart->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'id_product_v1' => $item->id_product_v1,
                    'product_name_snapshot' => $item->product_name_snapshot,
                    'product_code_snapshot' => $item->product_code_snapshot,
                    'product_image_url' => $item->image_url,
                    'quantity' => (int) $item->quantity,
                    'price_snapshot' => (float) $item->price_snapshot,
                    'price_snapshot_format' => number_format((float) $item->price_snapshot, 0, ',', '.') . 'đ',
                    'line_total' => (float) $item->line_total,
                    'line_total_format' => number_format((float) $item->line_total, 0, ',', '.') . 'đ',
                    'detail_url' => $item->detail_url,
                ];
            })->values()->all(),
        ];
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

    protected function attachCookieIfNeeded($response, $cookie)
    {
        if ($cookie) {
            $response->withCookie($cookie);
        }

        return $response;
    }
}