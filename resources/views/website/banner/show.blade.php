@extends('website.layout.index')

@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@section('meta_image', $seoImage)

@section('style')
<style>
    .wb-page{
        background: linear-gradient(180deg, #f7fbff 0%, #f4f9fd 100%);
        padding: 22px 0 42px;
    }

    .wb-container{
        width: min(1320px, calc(100% - 32px));
        margin: 0 auto;
    }

    .wb-breadcrumb{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
    }

    .wb-breadcrumb a{
        color: #475569;
        text-decoration: none;
    }

    .wb-breadcrumb a:hover{
        color: #0284c7;
    }

    .wb-hero{
        position: relative;
        overflow: hidden;
        border-radius: 34px;
        background: linear-gradient(135deg, #dbf2ff 0%, #cfeeff 45%, #dff6ff 100%);
        box-shadow: 0 26px 60px rgba(15, 23, 42, .08);
        padding: 24px;
    }

    .wb-hero__grid{
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(0, .85fr);
        gap: 26px;
        align-items: center;
    }

    .wb-hero__image-wrap{
        overflow: hidden;
        border-radius: 28px;
        background: #fff;
        box-shadow: 0 20px 46px rgba(15, 23, 42, .10);
    }

    .wb-hero__image{
        width: 100%;
        display: block;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        object-position: center;
    }

    .wb-hero__eyebrow{
        display: inline-flex;
        align-items: center;
        height: 38px;
        padding: 0 16px;
        border-radius: 999px;
        background: rgba(255,255,255,.72);
        color: #0284c7;
        font-size: 13px;
        font-weight: 900;
        margin-bottom: 14px;
    }

    .wb-hero__title{
        margin: 0;
        font-size: 46px;
        line-height: 1.08;
        font-weight: 900;
        letter-spacing: -0.03em;
        color: #0f172a;
    }

    .wb-hero__desc{
        margin: 16px 0 0;
        color: #475569;
        font-size: 17px;
        line-height: 1.85;
    }

    .wb-hero__meta{
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        margin-top: 22px;
    }

    .wb-hero__meta-item{
        min-width: 145px;
        padding: 14px 16px;
        border-radius: 18px;
        background: rgba(255,255,255,.72);
        border: 1px solid rgba(255,255,255,.85);
        box-shadow: 0 12px 24px rgba(15, 23, 42, .05);
    }

    .wb-hero__meta-value{
        font-size: 22px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 8px;
    }

    .wb-hero__meta-label{
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
    }

    .wb-hero__actions{
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .wb-btn{
        min-height: 48px;
        padding: 0 20px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: 0;
        font-size: 15px;
        font-weight: 900;
        transition: all .25s ease;
        cursor: pointer;
    }

    .wb-btn--primary{
        color: #fff;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        box-shadow: 0 18px 30px rgba(37, 99, 235, .18);
    }

    .wb-btn--primary:hover{
        transform: translateY(-2px);
    }

    .wb-btn--light{
        color: #0f172a;
        background: #fff;
        border: 1px solid #d8e4ef;
    }

    .wb-btn--light:hover{
        border-color: #38bdf8;
        color: #0284c7;
    }

    .wb-layout{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 330px;
        gap: 22px;
        margin-top: 24px;
    }

    .wb-card{
        background: #fff;
        border-radius: 28px;
        border: 1px solid #e8eff6;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .06);
        overflow: hidden;
    }

    .wb-section{
        padding: 28px;
    }

    .wb-section__eyebrow{
        font-size: 12px;
        font-weight: 900;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }

    .wb-section__title{
        margin: 0 0 18px;
        font-size: 30px;
        line-height: 1.18;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .wb-content{
        color: #334155;
        font-size: 16px;
        line-height: 1.9;
    }

    .wb-content p{
        margin: 0 0 14px;
    }

    .wb-content h1,
    .wb-content h2,
    .wb-content h3,
    .wb-content h4,
    .wb-content h5,
    .wb-content h6{
        color: #0f172a;
        margin: 0 0 12px;
        line-height: 1.35;
        font-weight: 800;
    }

    .wb-content ul,
    .wb-content ol{
        margin: 0 0 16px;
        padding-left: 20px;
    }

    .wb-content img{
        max-width: 100%;
        height: auto;
        border-radius: 18px;
        display: block;
        margin: 18px 0;
    }

    .wb-content table{
        width: 100%;
        border-collapse: collapse;
        margin: 18px 0;
        overflow: hidden;
        border-radius: 16px;
    }

    .wb-content table td,
    .wb-content table th{
        border: 1px solid #e5edf5;
        padding: 12px 14px;
        text-align: left;
    }

    .wb-sidebar{
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .wb-sidebar-card{
        padding: 22px;
    }

    .wb-sidebar-label{
        font-size: 12px;
        font-weight: 900;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }

    .wb-sidebar-title{
        margin: 0 0 14px;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 900;
        color: #0f172a;
    }

    .wb-sidebar-text{
        color: #475569;
        font-size: 15px;
        line-height: 1.85;
    }

    .wb-sidebar-banner{
        width: 100%;
        border-radius: 22px;
        overflow: hidden;
        background: #f8fbff;
        margin-top: 14px;
    }

    .wb-sidebar-banner img{
        width: 100%;
        display: block;
        object-fit: cover;
    }

    .wb-related-list{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .wb-related-item{
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        border-radius: 18px;
        text-decoration: none;
        color: inherit;
        transition: all .22s ease;
        border: 1px solid transparent;
    }

    .wb-related-item:hover{
        background: #f8fbff;
        border-color: #e4eef7;
        transform: translateX(3px);
    }

    .wb-related-item img{
        width: 76px;
        height: 58px;
        object-fit: cover;
        border-radius: 12px;
        background: #f4f8fb;
        flex: 0 0 auto;
    }

    .wb-related-item-title{
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @media (max-width: 991px){
        .wb-container{
            width: min(100%, calc(100% - 24px));
        }

        .wb-hero__grid{
            grid-template-columns: 1fr;
        }

        .wb-layout{
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px){
        .wb-page{
            padding: 18px 0 28px;
        }

        .wb-hero{
            padding: 18px;
            border-radius: 24px;
        }

        .wb-hero__title{
            font-size: 30px;
        }

        .wb-hero__desc{
            font-size: 15px;
            line-height: 1.75;
        }

        .wb-section,
        .wb-sidebar-card{
            padding: 20px;
        }

        .wb-section__title{
            font-size: 24px;
        }
    }
</style>
@endsection

@section('content')
<section class="wb-page">
    <div class="wb-container">
        <div class="wb-breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <span>/</span>
            <a href="{{ url('/') }}">Banner nổi bật</a>
            <span>/</span>
            <span>{{ $banner->title ?: 'Chi tiết banner' }}</span>
        </div>

        <div class="wb-hero">
            <div class="wb-hero__grid">
                <div class="wb-hero__image-wrap">
                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="wb-hero__image">
                </div>

                <div class="wb-hero__content">
                    <div class="wb-hero__eyebrow">Banner nổi bật</div>

                    <h1 class="wb-hero__title">
                        {{ $banner->title ?: 'Banner Nhà thuốc Phương Anh' }}
                    </h1>

                    <p class="wb-hero__desc">
                        {{ \Illuminate\Support\Str::limit(strip_tags($banner->content ?: 'Khám phá nội dung nổi bật đang được Nhà thuốc Phương Anh giới thiệu đến khách hàng.'), 260) }}
                    </p>

                    <div class="wb-hero__meta">
                        <div class="wb-hero__meta-item">
                            <div class="wb-hero__meta-value">{{ $banner->id }}</div>
                            <div class="wb-hero__meta-label">Mã banner</div>
                        </div>

                        <div class="wb-hero__meta-item">
                            <div class="wb-hero__meta-value">{{ $banner->sort_order ?? 0 }}</div>
                            <div class="wb-hero__meta-label">Thứ tự hiển thị</div>
                        </div>
                    </div>

                    <div class="wb-hero__actions">
                        @if(!empty($banner->external_url))
                            <a href="{{ $banner->external_url }}"
                               target="_blank"
                               class="wb-btn wb-btn--primary">
                                Truy cập liên kết
                            </a>
                        @endif

                        <a href="{{ url('/') }}" class="wb-btn wb-btn--light">
                            Quay về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="wb-layout">
            <div class="wb-main">
                <div class="wb-card">
                    <div class="wb-section">
                        <div class="wb-section__eyebrow">Nội dung chi tiết</div>
                        <h2 class="wb-section__title">
                            {{ $banner->title ?: 'Thông tin banner' }}
                        </h2>

                        <div class="wb-content">
                            @php
                                $bannerContent = trim((string) ($banner->content ?? ''));
                            @endphp

                            @if(!empty($bannerContent))
                                @if($bannerContent !== strip_tags($bannerContent))
                                    {!! $bannerContent !!}
                                @else
                                    @foreach(array_filter(preg_split('/\r\n|\r|\n/', $bannerContent)) as $line)
                                        <p>{{ $line }}</p>
                                    @endforeach
                                @endif
                            @else
                                <p>Đang cập nhật nội dung cho banner này.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <aside class="wb-sidebar">
                <div class="wb-card wb-sidebar-card">
                    <div class="wb-sidebar-label">Hình ảnh banner</div>
                    <h3 class="wb-sidebar-title">{{ $banner->title ?: 'Banner nổi bật' }}</h3>

                    <div class="wb-sidebar-banner">
                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}">
                    </div>
                </div>

                <div class="wb-card wb-sidebar-card">
                    <div class="wb-sidebar-label">Liên kết ngoài</div>
                    <h3 class="wb-sidebar-title">Điều hướng nhanh</h3>

                    <div class="wb-sidebar-text">
                        @if(!empty($banner->external_url))
                            Banner này có liên kết ngoài để người dùng tiếp tục xem thêm nội dung liên quan.
                        @else
                            Banner này hiện chưa gắn liên kết ngoài.
                        @endif
                    </div>

                    @if(!empty($banner->external_url))
                        <div style="margin-top:16px;">
                            <a href="{{ $banner->external_url }}" target="_blank" class="wb-btn wb-btn--primary">
                                Mở liên kết
                            </a>
                        </div>
                    @endif
                </div>

                <div class="wb-card wb-sidebar-card">
                    <div class="wb-sidebar-label">Banner khác</div>
                    <h3 class="wb-sidebar-title">Có thể bạn quan tâm</h3>

                    @if($relatedBanners->count() > 0)
                        <div class="wb-related-list">
                            @foreach($relatedBanners as $item)
                                <a href="{{ $item['url'] }}" class="wb-related-item">
                                    <img src="{{ $item['image_url'] }}" alt="{{ $item['title'] }}">
                                    <div class="wb-related-item-title">
                                        {{ $item['title'] ?: 'Banner nổi bật' }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="wb-sidebar-text">
                            Chưa có banner liên quan để hiển thị.
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</section>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CreativeWork",
    "name": @json($banner->title ?: 'Banner Nhà thuốc Phương Anh'),
    "description": @json($seoDescription),
    "image": @json($seoImage),
    "url": @json($canonicalUrl)
}
</script>
@endsection