@extends('website.layout.index')

@section('style')
<style>
    .dsc-page{
        padding: 28px 0 56px;
        background: #f6f8fc;
    }

    .dsc-container{
        width: min(1280px, calc(100% - 32px));
        margin: 0 auto;
    }

    .dsc-breadcrumb{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        font-size: 14px;
        color: #667085;
    }

    .dsc-breadcrumb a{
        color: #0ea5c6;
        text-decoration: none;
    }

    .dsc-breadcrumb a:hover{
        text-decoration: underline;
    }

    .dsc-hero{
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        min-height: 320px;
        background: linear-gradient(135deg, #0ea5c6 0%, #0f7db8 100%);
        margin-bottom: 24px;
        box-shadow: 0 24px 48px rgba(14, 165, 198, .16);
    }

    .dsc-hero__bg{
        position: absolute;
        inset: 0;
    }

    .dsc-hero__bg img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .dsc-hero__overlay{
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(9, 25, 43, .88) 0%, rgba(9, 25, 43, .52) 42%, rgba(9, 25, 43, .18) 100%);
    }

    .dsc-hero__content{
        position: relative;
        z-index: 2;
        padding: 34px 36px;
        max-width: 760px;
        color: #fff;
    }

    .dsc-badge{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 34px;
        padding: 0 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.16);
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 14px;
    }

    .dsc-title{
        margin: 0 0 12px;
        font-size: 42px;
        line-height: 1.15;
        font-weight: 900;
    }

    .dsc-desc{
        margin: 0 0 16px;
        font-size: 17px;
        line-height: 1.8;
        color: rgba(255,255,255,.94);
    }

    .dsc-meta{
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .dsc-meta span{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 36px;
        padding: 0 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.14);
        font-size: 13px;
        font-weight: 800;
    }

    .dsc-featured{
        background: #fff;
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .08);
        margin-bottom: 24px;
    }

    .dsc-featured__link{
        display: grid;
        grid-template-columns: minmax(0, 1.1fr) minmax(360px, .9fr);
        text-decoration: none;
        color: inherit;
    }

    .dsc-featured__media{
        min-height: 380px;
        background: #eef3f8;
    }

    .dsc-featured__media img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .dsc-featured__body{
        padding: 28px 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .dsc-featured__meta{
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 10px;
        font-size: 13px;
        color: #667085;
        font-weight: 700;
    }

    .dsc-featured__title{
        margin: 0 0 12px;
        font-size: 32px;
        line-height: 1.28;
        font-weight: 900;
        color: #0f172a;
    }

    .dsc-featured__desc{
        margin: 0 0 16px;
        font-size: 15px;
        line-height: 1.8;
        color: #667085;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dsc-featured__cta{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #0ea5c6;
        font-size: 15px;
        font-weight: 900;
    }

    .dsc-layout{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 24px;
        align-items: start;
    }

    .dsc-main-card,
    .dsc-side-card{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, .08);
    }

    .dsc-main-card{
        padding: 24px;
    }

    .dsc-main-head{
        margin-bottom: 18px;
    }

    .dsc-main-head h2{
        margin: 0 0 6px;
        font-size: 28px;
        line-height: 1.3;
        font-weight: 900;
        color: #0f172a;
    }

    .dsc-main-head p{
        margin: 0;
        font-size: 15px;
        color: #667085;
    }

    .dsc-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .dsc-card{
        border: 1px solid #e8eef5;
        border-radius: 22px;
        overflow: hidden;
        background: #fff;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .dsc-card:hover{
        transform: translateY(-3px);
        box-shadow: 0 16px 32px rgba(15, 23, 42, .08);
    }

    .dsc-card__link{
        display: block;
        text-decoration: none;
        color: inherit;
        height: 100%;
    }

    .dsc-card__thumb{
        aspect-ratio: 16/10;
        background: #eef3f8;
        overflow: hidden;
    }

    .dsc-card__thumb img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .dsc-card__body{
        padding: 18px;
    }

    .dsc-card__meta{
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 10px;
        font-size: 13px;
        color: #667085;
        font-weight: 700;
    }

    .dsc-card__title{
        margin: 0 0 10px;
        font-size: 21px;
        line-height: 1.42;
        font-weight: 900;
        color: #0f172a;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 60px;
    }

    .dsc-card__desc{
        margin: 0 0 14px;
        font-size: 14px;
        line-height: 1.75;
        color: #667085;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 74px;
    }

    .dsc-card__cta{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #0ea5c6;
        font-size: 14px;
        font-weight: 900;
    }

    .dsc-empty{
        padding: 24px 4px 8px;
        text-align: center;
        color: #667085;
        font-size: 15px;
    }

    .dsc-side-card{
        padding: 20px;
    }

    .dsc-side-card + .dsc-side-card{
        margin-top: 18px;
    }

    .dsc-side-card h3{
        margin: 0 0 14px;
        font-size: 20px;
        font-weight: 900;
        color: #0f172a;
    }

    .dsc-side-list{
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .dsc-side-link{
        display: grid;
        grid-template-columns: 88px minmax(0, 1fr);
        gap: 12px;
        text-decoration: none;
        color: inherit;
    }

    .dsc-side-link__thumb{
        width: 88px;
        height: 72px;
        border-radius: 14px;
        overflow: hidden;
        background: #eef3f8;
    }

    .dsc-side-link__thumb img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .dsc-side-link__title{
        margin: 0 0 6px;
        font-size: 15px;
        line-height: 1.5;
        font-weight: 800;
        color: #0f172a;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dsc-side-link__meta{
        font-size: 13px;
        color: #667085;
    }

    .dsc-category-list{
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .dsc-category-item{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 14px;
        background: #f7fafc;
        text-decoration: none;
        color: #0f172a;
        font-weight: 800;
    }

    .dsc-category-item:hover{
        background: #eef8fb;
        color: #0ea5c6;
    }

    .dsc-pagination{
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 22px;
    }

    .dsc-pagination a,
    .dsc-pagination span{
        min-width: 42px;
        height: 42px;
        padding: 0 12px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: 1px solid #dbe5ef;
        background: #fff;
        color: #0f172a;
        font-weight: 800;
    }

    .dsc-pagination a:hover{
        border-color: #0ea5c6;
        color: #0ea5c6;
    }

    .dsc-pagination .is-active{
        background: linear-gradient(135deg, #12b8d4 0%, #1490cf 100%);
        border-color: transparent;
        color: #fff;
    }

    @media (max-width: 1199px){
        .dsc-featured__link,
        .dsc-layout{
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px){
        .dsc-page{
            padding: 20px 0 40px;
        }

        .dsc-container{
            width: min(100%, calc(100% - 20px));
        }

        .dsc-hero{
            min-height: 260px;
        }

        .dsc-hero__content{
            padding: 24px 18px;
        }

        .dsc-title{
            font-size: 28px;
        }

        .dsc-desc{
            font-size: 15px;
        }

        .dsc-featured__media{
            min-height: 240px;
        }

        .dsc-featured__body{
            padding: 20px 18px;
        }

        .dsc-featured__title{
            font-size: 24px;
        }

        .dsc-main-card{
            padding: 18px;
        }

        .dsc-main-head h2{
            font-size: 22px;
        }

        .dsc-grid{
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $heroImage = $category->banner ?: $category->avatar;
    if ($heroImage && !\Illuminate\Support\Str::startsWith($heroImage, ['http://', 'https://'])) {
        $heroImage = asset($heroImage);
    }
    if (!$heroImage) {
        $heroImage = asset('phuonganh/img/disease-men-placeholder.webp');
    }
@endphp

<section class="dsc-page">
    <div class="dsc-container">
        <nav class="dsc-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <span>/</span>
            <span>{{ $typeLabel }}</span>
            <span>/</span>
            <span>{{ $category->name }}</span>
        </nav>

        <section class="dsc-hero">
            <div class="dsc-hero__bg">
                <img src="{{ $heroImage }}" alt="{{ $category->name }}">
            </div>
            <div class="dsc-hero__overlay"></div>

            <div class="dsc-hero__content">
                <div class="dsc-badge">
                    <span>📚</span>
                    <span>{{ $typeLabel }}</span>
                </div>

                <h1 class="dsc-title">{{ $category->name }}</h1>

                <p class="dsc-desc">
                    {{ $category->short_description ?: 'Tổng hợp các bài viết và kiến thức nổi bật trong danh mục bệnh này để người dùng dễ dàng tra cứu và tiếp cận thông tin.' }}
                </p>

                <div class="dsc-meta">
                    <span>📄 {{ $articleCount }} bài viết</span>
                    <span>🏷️ {{ $typeLabel }}</span>
                </div>
            </div>
        </section>

        @if($featuredArticle)
            @php
                $featuredImage = $featuredArticle->banner ?: $featuredArticle->avatar;
                if ($featuredImage && !\Illuminate\Support\Str::startsWith($featuredImage, ['http://', 'https://'])) {
                    $featuredImage = asset($featuredImage);
                }
                if (!$featuredImage) {
                    $featuredImage = asset('phuonganh/img/disease-men-placeholder.webp');
                }

                $featuredDesc = $featuredArticle->short_description
                    ?: \Illuminate\Support\Str::limit(strip_tags($featuredArticle->content), 220);
            @endphp

            <article class="dsc-featured">
                <a
                    href="{{ route('website.disease.article', ['category' => $category->id, 'article' => $featuredArticle->id]) }}"
                    class="dsc-featured__link"
                >
                    <div class="dsc-featured__media">
                        <img src="{{ $featuredImage }}" alt="{{ $featuredArticle->title }}">
                    </div>

                    <div class="dsc-featured__body">
                        <div class="dsc-featured__meta">
                            <span>{{ $category->name }}</span>
                            <time datetime="{{ \Carbon\Carbon::parse($featuredArticle->posted_at ?: $featuredArticle->created_at)->format('c') }}">
                                {{ \Carbon\Carbon::parse($featuredArticle->posted_at ?: $featuredArticle->created_at)->format('d/m/Y') }}
                            </time>
                        </div>

                        <h2 class="dsc-featured__title">{{ $featuredArticle->title }}</h2>
                        <p class="dsc-featured__desc">{{ $featuredDesc }}</p>
                        <span class="dsc-featured__cta">Xem chi tiết →</span>
                    </div>
                </a>
            </article>
        @endif

        <div class="dsc-layout">
            <div class="dsc-main-card">
                <div class="dsc-main-head">
                    <h2>Bài viết trong danh mục</h2>
                    <p>Danh sách bài viết chi tiết thuộc danh mục {{ $category->name }}.</p>
                </div>

                @if($articles->count() > 0)
                    <div class="dsc-grid">
                        @foreach($articles as $item)
                            @php
                                $thumb = $item->avatar ?: $item->banner;
                                if ($thumb && !\Illuminate\Support\Str::startsWith($thumb, ['http://', 'https://'])) {
                                    $thumb = asset($thumb);
                                }
                                if (!$thumb) {
                                    $thumb = asset('phuonganh/img/disease-men-placeholder.webp');
                                }

                                $desc = $item->short_description
                                    ?: \Illuminate\Support\Str::limit(strip_tags($item->content), 140);
                            @endphp

                            <article class="dsc-card">
                                <a
                                    href="{{ route('website.disease.article', ['category' => $category->id, 'article' => $item->id]) }}"
                                    class="dsc-card__link"
                                >
                                    <div class="dsc-card__thumb">
                                        <img src="{{ $thumb }}" alt="{{ $item->title }}">
                                    </div>

                                    <div class="dsc-card__body">
                                        <div class="dsc-card__meta">
                                            <span>{{ $typeLabel }}</span>
                                            <time datetime="{{ \Carbon\Carbon::parse($item->posted_at ?: $item->created_at)->format('c') }}">
                                                {{ \Carbon\Carbon::parse($item->posted_at ?: $item->created_at)->format('d/m/Y') }}
                                            </time>
                                        </div>

                                        <h3 class="dsc-card__title">{{ $item->title }}</h3>
                                        <p class="dsc-card__desc">{{ $desc }}</p>
                                        <span class="dsc-card__cta">Xem chi tiết →</span>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>

                    @if($articles->hasPages())
                        <nav class="dsc-pagination" aria-label="Phân trang bài viết bệnh">
                            @if($articles->onFirstPage())
                                <span>←</span>
                            @else
                                <a href="{{ $articles->previousPageUrl() }}">←</a>
                            @endif

                            @for($page = 1; $page <= $articles->lastPage(); $page++)
                                @if($page == $articles->currentPage())
                                    <span class="is-active">{{ $page }}</span>
                                @else
                                    <a href="{{ $articles->url($page) }}">{{ $page }}</a>
                                @endif
                            @endfor

                            @if($articles->hasMorePages())
                                <a href="{{ $articles->nextPageUrl() }}">→</a>
                            @else
                                <span>→</span>
                            @endif
                        </nav>
                    @endif
                @else
                    <div class="dsc-empty">Danh mục này hiện chưa có thêm bài viết.</div>
                @endif
            </div>

            <aside>
                @if($latestArticles->count() > 0)
                    <div class="dsc-side-card">
                        <h3>Bài viết mới</h3>
                        <div class="dsc-side-list">
                            @foreach($latestArticles as $latest)
                                @php
                                    $latestThumb = $latest->avatar ?: $latest->banner;
                                    if ($latestThumb && !\Illuminate\Support\Str::startsWith($latestThumb, ['http://', 'https://'])) {
                                        $latestThumb = asset($latestThumb);
                                    }
                                    if (!$latestThumb) {
                                        $latestThumb = asset('phuonganh/img/disease-men-placeholder.webp');
                                    }
                                @endphp

                                <a
                                    href="{{ route('website.disease.article', ['category' => $latest->id_category, 'article' => $latest->id]) }}"
                                    class="dsc-side-link"
                                >
                                    <div class="dsc-side-link__thumb">
                                        <img src="{{ $latestThumb }}" alt="{{ $latest->title }}">
                                    </div>
                                    <div>
                                        <h4 class="dsc-side-link__title">{{ $latest->title }}</h4>
                                        <div class="dsc-side-link__meta">
                                            {{ \Carbon\Carbon::parse($latest->posted_at)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($relatedCategories->count() > 0)
                    <div class="dsc-side-card">
                        <h3>Danh mục liên quan</h3>
                        <div class="dsc-category-list">
                            @foreach($relatedCategories as $related)
                                <a
                                    href="{{ route('website.disease.category', ['category' => $related->id]) }}"
                                    class="dsc-category-item"
                                >
                                    <span>{{ $related->name }}</span>
                                    <span>{{ $relatedCategoryCountMap[$related->id] ?? 0 }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </div>
</section>

<script type="application/ld+json">
{
    "@context":"https://schema.org",
    "@type":"CollectionPage",
    "name":"{{ addslashes($category->name) }}",
    "description":"{{ addslashes($category->short_description ?: 'Danh mục bài viết bệnh tại Nhà thuốc Phương Anh.') }}",
    "url":"{{ route('website.disease.category', ['category' => $category->id]) }}"
}
</script>
@endsection