<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebsiteBannerController extends Controller
{
    public function show($id)
    {
        $banner = DB::table('banners_v1')
            ->where('id', $id)
            ->first();

        abort_if(!$banner, 404);

        $banner->image_url = $this->resolveImageUrl($banner->image, 'images/no-image.png');
        $banner->external_url = !empty($banner->link_web) ? $banner->link_web : null;

        $relatedBanners = DB::table('banners_v1')
            ->where('id', '<>', $banner->id)
            ->orderByRaw('CASE WHEN sort_order IS NULL THEN 1 ELSE 0 END')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'image_url' => $this->resolveImageUrl($item->image, 'images/no-image.png'),
                    'url' => route('website.banner.show', $item->id),
                ];
            });

        $seoTitle = ($banner->title ?: 'Banner nổi bật') . ' | Nhà thuốc Phương Anh';
        $seoDescription = !empty($banner->content)
            ? Str::limit(strip_tags($banner->content), 160)
            : 'Khám phá thông tin banner nổi bật tại Nhà thuốc Phương Anh.';
        $seoImage = $banner->image_url;
        $canonicalUrl = route('website.banner.show', $banner->id);

        return view('website.banner.show', compact(
            'banner',
            'relatedBanners',
            'seoTitle',
            'seoDescription',
            'seoImage',
            'canonicalUrl'
        ));
    }

    private function resolveImageUrl($path, $default = null)
    {
        if (!empty($path)) {
            if (Str::startsWith($path, ['http://', 'https://', '//'])) {
                return $path;
            }

            return asset(ltrim($path, '/'));
        }

        return $default ? asset(ltrim($default, '/')) : '';
    }
}