<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\ProductV1;
use App\Models\ImagesProductV1;
use App\Services\ProductPriceV1Service;

class WebsiteProductV1Controller extends Controller
{
    public function show($id)
    {
        $priceService = app(ProductPriceV1Service::class);

        $product = ProductV1::query()
            ->leftJoin('category_v1 as c', 'c.id', '=', 'product_v1.id_category')
            ->leftJoin('main_category_v1 as mc', 'mc.id', '=', 'c.id_main_category_v1')
            ->leftJoin('trademark_v1 as tm', 'tm.id', '=', 'product_v1.id_trade_mark')
            ->where('product_v1.id', $id)
            ->where(function ($q) {
                $q->whereNull('product_v1.status')->orWhere('product_v1.status', 1);
            })
            ->where(function ($q) {
                $q->whereNull('product_v1.is_active')->orWhere('product_v1.is_active', 1);
            })
            ->select([
                'product_v1.*',

                'c.name as category_name',
                'c.id as category_id',

                'mc.id as main_category_id',
                'mc.name as main_category_name',

                'tm.id as trademark_id',
                'tm.name as trademark_name',
                'tm.description as trademark_description',
                'tm.note as trademark_note',
                'tm.img as trademark_img',
                'tm.banner as trademark_banner',
            ])
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Format ảnh sản phẩm / thương hiệu
        |--------------------------------------------------------------------------
        */
        $product->image_url = $this->formatImageUrl($product->img_avatar);
        $product->trademark_image_url = $this->formatImageUrl($product->trademark_img);
        $product->trademark_banner_url = $this->formatImageUrl($product->trademark_banner);

        /*
        |--------------------------------------------------------------------------
        | Giá sản phẩm - lấy theo service trung tâm
        |--------------------------------------------------------------------------
        | Ưu tiên:
        | 1. Giá flash sale đang hiệu lực
        | 2. Giá sale thường của product_v1
        | 3. Giá gốc product_v1
        */
        $product = $priceService->applyToProduct($product);

        /*
        |--------------------------------------------------------------------------
        | Mã sản phẩm hiển thị
        |--------------------------------------------------------------------------
        */
        $product->product_code = $product->code_product_kiovet ?: ('SP' . $product->id);

        /*
        |--------------------------------------------------------------------------
        | Gallery ảnh sản phẩm
        |--------------------------------------------------------------------------
        */
        $extraImages = ImagesProductV1::query()
            ->where('id_product_v1', $product->id)
            ->where(function ($q) {
                $q->whereNull('status')->orWhere('status', 1);
            })
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'src' => $this->formatImageUrl($item->link_img),
                ];
            });

        $galleryImages = collect();

        if (!empty($product->img_avatar)) {
            $galleryImages->push([
                'id' => 'avatar-' . $product->id,
                'src' => $this->formatImageUrl($product->img_avatar),
            ]);
        }

        $galleryImages = $galleryImages
            ->merge($extraImages)
            ->unique('src')
            ->values();

        if ($galleryImages->isEmpty()) {
            $galleryImages->push([
                'id' => 'no-image',
                'src' => asset('assets/images/no-image.png'),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Sản phẩm liên quan cùng danh mục
        |--------------------------------------------------------------------------
        */
        $relatedProducts = ProductV1::query()
            ->leftJoin('trademark_v1 as tm', 'tm.id', '=', 'product_v1.id_trade_mark')
            ->where('product_v1.id_category', $product->id_category)
            ->where('product_v1.id', '!=', $product->id)
            ->where(function ($q) {
                $q->whereNull('product_v1.status')->orWhere('product_v1.status', 1);
            })
            ->where(function ($q) {
                $q->whereNull('product_v1.is_active')->orWhere('product_v1.is_active', 1);
            })
            ->inRandomOrder()
            ->limit(15)
            ->get([
                'product_v1.*',
                'tm.name as trademark_name',
            ])
            ->map(function ($item) use ($priceService) {
                $item->image_url = $this->formatImageUrl($item->img_avatar);

                /*
                |--------------------------------------------------------------------------
                | Giá sản phẩm liên quan cũng dùng chung service
                |--------------------------------------------------------------------------
                */
                $item = $priceService->applyToProduct($item);

                $item->detail_url = route('website.product-v1.show', ['id' => $item->id]);

                return $item;
            });

        return view('website.product-v1.show', compact(
            'product',
            'galleryImages',
            'relatedProducts'
        ));
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
}