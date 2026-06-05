@extends('website.layout.index')

@section('style')
<style>
    .hc-page{
        padding: 28px 0 56px;
        background: #f6f8fc;
    }

    .hc-container{
        width: min(1280px, calc(100% - 32px));
        margin: 0 auto;
    }

    .hc-breadcrumb{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        font-size: 14px;
        color: #667085;
    }

    .hc-breadcrumb a{
        color: #0ea5c6;
        text-decoration: none;
    }

    .hc-breadcrumb a:hover{
        text-decoration: underline;
    }

    .hc-hero{
        background: linear-gradient(135deg, #0ea5c6 0%, #0f7db8 100%);
        border-radius: 28px;
        padding: 36px;
        color: #fff;
        box-shadow: 0 24px 50px rgba(14, 165, 198, 0.18);
        margin-bottom: 22px;
    }

    .hc-hero__eyebrow{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.18);
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .hc-hero h1{
        margin: 0 0 12px;
        font-size: 42px;
        line-height: 1.18;
        font-weight: 800;
    }

    .hc-hero p{
        margin: 0;
        font-size: 17px;
        line-height: 1.8;
        max-width: 860px;
        color: rgba(255,255,255,.92);
    }

    .hc-tabs{
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 6px;
        margin-bottom: 24px;
        scrollbar-width: none;
    }

    .hc-tabs::-webkit-scrollbar{
        display: none;
    }

    .hc-tab{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        padding: 12px 18px;
        border-radius: 999px;
        border: 1px solid #d9e1ec;
        background: #fff;
        color: #1f2937;
        text-decoration: none;
        font-weight: 700;
        transition: all .2s ease;
    }

    .hc-tab:hover{
        border-color: #0ea5c6;
        color: #0ea5c6;
    }

    .hc-tab--active{
        background: linear-gradient(135deg, #12b8d4 0%, #1490cf 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 12px 24px rgba(20, 144, 207, .18);
    }

    .hc-tab-count{
        font-size: 12px;
        line-height: 1;
        padding: 4px 7px;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.08);
    }

    .hc-tab--active .hc-tab-count{
        background: rgba(255,255,255,.2);
        color: #fff;
    }

    .hc-featured{
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.10);
        margin-bottom: 26px;
    }

    .hc-featured__link{
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(360px, .95fr);
        text-decoration: none;
        color: inherit;
    }

    .hc-featured__media{
        min-height: 420px;
        position: relative;
        background: #edf2f7;
    }

    .hc-featured__media img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .hc-featured__overlay{
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15,23,42,.58), rgba(15,23,42,.08) 55%, rgba(15,23,42,0));
    }

    .hc-featured__badge{
        position: absolute;
        left: 22px;
        bottom: 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(15, 23, 42, .76);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
    }

    .hc-featured__badge i{
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #35e06b;
        display: inline-block;
    }

    .hc-featured__body{
        padding: 28px 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .hc-featured__meta{
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 12px;
        font-size: 14px;
        color: #667085;
    }

    .hc-featured__title{
        margin: 0 0 14px;
        font-size: 34px;
        line-height: 1.25;
        font-weight: 800;
        color: #0f172a;
    }

    .hc-featured__desc{
        margin: 0 0 18px;
        font-size: 16px;
        line-height: 1.8;
        color: #5f6b7a;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .hc-featured__cta{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #0ea5c6;
        font-weight: 800;
    }

    .hc-main{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 24px;
        align-items: start;
    }

    .hc-section-card,
    .hc-side-card{
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
    }

    .hc-section-card{
        padding: 24px;
    }

    .hc-section-head{
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .hc-section-head h2{
        margin: 0;
        font-size: 28px;
        line-height: 1.3;
        color: #0f172a;
        font-weight: 800;
    }

    .hc-section-head p{
        margin: 6px 0 0;
        color: #667085;
        font-size: 15px;
    }

    .hc-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .hc-card{
        border: 1px solid #e6edf5;
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .hc-card:hover{
        transform: translateY(-3px);
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.08);
    }

    .hc-card__link{
        display: block;
        text-decoration: none;
        color: inherit;
        height: 100%;
    }

    .hc-card__thumb{
        aspect-ratio: 16/10;
        background: #eef3f8;
        overflow: hidden;
    }

    .hc-card__thumb img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .hc-card__body{
        padding: 18px;
    }

    .hc-card__meta{
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 10px;
        font-size: 13px;
        color: #667085;
    }

    .hc-card__tag{
        color: #0ea5c6;
        font-weight: 700;
    }

    .hc-card__title{
        margin: 0 0 10px;
        font-size: 20px;
        line-height: 1.42;
        font-weight: 800;
        color: #0f172a;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 57px;
    }

    .hc-card__desc{
        margin: 0;
        font-size: 15px;
        line-height: 1.7;
        color: #667085;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 76px;
    }

    .hc-empty{
        padding: 30px 6px 12px;
        text-align: center;
        color: #667085;
        font-size: 16px;
    }

    .hc-side-card{
        padding: 20px;
    }

    .hc-side-card + .hc-side-card{
        margin-top: 18px;
    }

    .hc-side-card h3{
        margin: 0 0 14px;
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
    }

    .hc-side-list{
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .hc-side-link{
        display: grid;
        grid-template-columns: 88px minmax(0, 1fr);
        gap: 12px;
        text-decoration: none;
        color: inherit;
    }

    .hc-side-link:hover .hc-side-link__title{
        color: #0ea5c6;
    }

    .hc-side-link__thumb{
        width: 88px;
        height: 72px;
        border-radius: 14px;
        overflow: hidden;
        background: #eef3f8;
    }

    .hc-side-link__thumb img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .hc-side-link__title{
        margin: 0 0 6px;
        font-size: 15px;
        line-height: 1.5;
        font-weight: 700;
        color: #0f172a;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color .2s ease;
    }

    .hc-side-link__meta{
        font-size: 13px;
        color: #667085;
    }

    .hc-category-list{
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .hc-category-item{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 14px;
        background: #f7fafc;
        text-decoration: none;
        color: #0f172a;
        font-weight: 700;
    }

    .hc-category-item:hover{
        background: #eef8fb;
        color: #0ea5c6;
    }

    .hc-category-item--active{
        background: #e8f9fd;
        color: #0ea5c6;
    }

    .hc-pagination{
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 22px;
    }

    .hc-pagination a,
    .hc-pagination span{
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
        font-weight: 700;
    }

    .hc-pagination a:hover{
        border-color: #0ea5c6;
        color: #0ea5c6;
    }

    .hc-pagination .is-active{
        background: linear-gradient(135deg, #12b8d4 0%, #1490cf 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 10px 22px rgba(20, 144, 207, .18);
    }

    @media (max-width: 1199px){
        .hc-featured__link,
        .hc-main{
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px){
        .hc-page{
            padding: 20px 0 40px;
        }

        .hc-container{
            width: min(100%, calc(100% - 20px));
        }

        .hc-hero{
            padding: 24px 18px;
            border-radius: 22px;
        }

        .hc-hero h1{
            font-size: 28px;
        }

        .hc-hero p{
            font-size: 15px;
        }

        .hc-featured__media{
            min-height: 240px;
        }

        .hc-featured__body{
            padding: 20px 18px;
        }

        .hc-featured__title{
            font-size: 24px;
        }

        .hc-section-card{
            padding: 18px;
        }

        .hc-section-head h2{
            font-size: 22px;
        }

        .hc-grid{
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $featuredImage = $featuredArticle ? ($featuredArticle->banner ?: $featuredArticle->avatar) : null;
    if ($featuredImage && !\Illuminate\Support\Str::startsWith($featuredImage, ['http://', 'https://'])) {
        $featuredImage = asset($featuredImage);
    }
    if (!$featuredImage) {
        $featuredImage = asset('phuonganh/img/health-main-placeholder.jpg');
    }

    $pageTitle = 'Góc sức khoẻ';
    $pageDesc = 'Tổng hợp bài viết về dinh dưỡng, mẹ và bé, người cao tuổi, giới tính, khỏe đẹp và phòng bệnh từ Nhà thuốc Phương Anh.';
@endphp

<section class="hc-page">
    <div class="hc-container">
        <nav class="hc-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <span>/</span>
            <span>Góc sức khoẻ</span>
            @if($selectedCategory)
                <span>/</span>
                <span>{{ $selectedCategory->name }}</span>
            @endif
        </nav>

        <section class="hc-hero">
            <div class="hc-hero__eyebrow">
                <!-- <span>📚</span> -->
                <span>Kiến thức sức khoẻ</span>
            </div>
            <h1>{{ $pageTitle }}</h1>
            <p>{{ $pageDesc }}</p>
        </section>

        <div class="hc-tabs" id="hcTabs">
            @foreach($categories as $cat)
                <a
                    href="{{ route('website.health-corner.index', ['category' => $cat->id]) }}"
                    class="hc-tab {{ $selectedCategory && $selectedCategory->id == $cat->id ? 'hc-tab--active' : '' }}"
                >
                    <span>{{ $cat->name }}</span>
                    <span class="hc-tab-count">{{ $categoryCounts[$cat->id] ?? 0 }}</span>
                </a>
            @endforeach
        </div>

        @if($featuredArticle)
            @php
                $featuredDesc = $featuredArticle->short_description
                    ?: \Illuminate\Support\Str::limit(strip_tags($featuredArticle->content), 220);
            @endphp

            <article class="hc-featured">
                <a
                    href="{{ route('website.health-corner.show', ['category' => $selectedCategory->id, 'article' => $featuredArticle->id]) }}"
                    class="hc-featured__link"
                >
                    <div class="hc-featured__media">
                        <img src="{{ $featuredImage }}" alt="{{ $featuredArticle->title }}" loading="eager">
                        <div class="hc-featured__overlay"></div>
                        <div class="hc-featured__badge">
                            <i></i>
                            <span>{{ $selectedCategory->name }}</span>
                        </div>
                    </div>

                    <div class="hc-featured__body">
                        <div class="hc-featured__meta">
                            <span>{{ $selectedCategory->name }}</span>
                            <time datetime="{{ \Carbon\Carbon::parse($featuredArticle->posted_at ?: $featuredArticle->created_at)->format('c') }}">
                                {{ \Carbon\Carbon::parse($featuredArticle->posted_at ?: $featuredArticle->created_at)->format('d/m/Y') }}
                            </time>
                        </div>

                        <h2 class="hc-featured__title">{{ $featuredArticle->title }}</h2>
                        <p class="hc-featured__desc">{{ $featuredDesc }}</p>
                        <span class="hc-featured__cta">Đọc chi tiết →</span>
                    </div>
                </a>
            </article>
        @endif

        <div class="hc-main">
            <div class="hc-section-card">
                <div class="hc-section-head">
                    <div>
                        <h2>Bài viết {{ $selectedCategory->name }}</h2>
                        <p>Danh sách bài viết đầy đủ trong chuyên mục này.</p>
                    </div>
                </div>

                @if($articles->count() > 0)
                    <div class="hc-grid">
                        @foreach($articles as $item)
                            @php
                                $thumb = $item->avatar ?: $item->banner;
                                if ($thumb && !\Illuminate\Support\Str::startsWith($thumb, ['http://', 'https://'])) {
                                    $thumb = asset($thumb);
                                }
                                if (!$thumb) {
                                    $thumb = asset('phuonganh/img/health-side-1-placeholder.jpg');
                                }

                                $desc = $item->short_description
                                    ?: \Illuminate\Support\Str::limit(strip_tags($item->content), 140);
                            @endphp

                            <article class="hc-card">
                                <a
                                    href="{{ route('website.health-corner.show', ['category' => $selectedCategory->id, 'article' => $item->id]) }}"
                                    class="hc-card__link"
                                >
                                    <div class="hc-card__thumb">
                                        <img src="{{ $thumb }}" alt="{{ $item->title }}" loading="lazy">
                                    </div>

                                    <div class="hc-card__body">
                                        <div class="hc-card__meta">
                                            <span class="hc-card__tag">{{ $selectedCategory->name }}</span>
                                            <time datetime="{{ \Carbon\Carbon::parse($item->posted_at ?: $item->created_at)->format('c') }}">
                                                {{ \Carbon\Carbon::parse($item->posted_at ?: $item->created_at)->format('d/m/Y') }}
                                            </time>
                                        </div>

                                        <h3 class="hc-card__title">{{ $item->title }}</h3>
                                        <p class="hc-card__desc">{{ $desc }}</p>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>

                    @if($articles->hasPages())
                        <nav class="hc-pagination" aria-label="Phân trang bài viết">
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
                    <div class="hc-empty">Danh mục này hiện chưa có thêm bài viết.</div>
                @endif
            </div>

            <aside>
                <div class="hc-side-card">
                    <h3>Danh mục bài viết</h3>
                    <div class="hc-category-list">
                        @foreach($categories as $cat)
                            <a
                                href="{{ route('website.health-corner.index', ['category' => $cat->id]) }}"
                                class="hc-category-item {{ $selectedCategory && $selectedCategory->id == $cat->id ? 'hc-category-item--active' : '' }}"
                            >
                                <span>{{ $cat->name }}</span>
                                <span>{{ $categoryCounts[$cat->id] ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="hc-side-card">
                    <h3>Bài viết mới</h3>
                    <div class="hc-side-list">
                        @foreach($latestArticles as $latest)
                            @php
                                $latestThumb = $latest->avatar ?: $latest->banner;
                                if ($latestThumb && !\Illuminate\Support\Str::startsWith($latestThumb, ['http://', 'https://'])) {
                                    $latestThumb = asset($latestThumb);
                                }
                                if (!$latestThumb) {
                                    $latestThumb = asset('phuonganh/img/health-side-1-placeholder.jpg');
                                }
                            @endphp

                            <a
                                href="{{ route('website.health-corner.show', ['category' => $latest->id_category, 'article' => $latest->id]) }}"
                                class="hc-side-link"
                            >
                                <div class="hc-side-link__thumb">
                                    <img src="{{ $latestThumb }}" alt="{{ $latest->title }}" loading="lazy">
                                </div>
                                <div>
                                    <h4 class="hc-side-link__title">{{ $latest->title }}</h4>
                                    <div class="hc-side-link__meta">
                                        {{ \Carbon\Carbon::parse($latest->posted_at)->format('d/m/Y') }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<script type="application/ld+json">
{
    "@context":"https://schema.org",
    "@type":"CollectionPage",
    "name":"Góc sức khoẻ - {{ $selectedCategory->name }}",
    "description":"{{ $pageDesc }}",
    "url":"{{ route('website.health-corner.index', ['category' => $selectedCategory->id]) }}",
    "breadcrumb":{
        "@type":"BreadcrumbList",
        "itemListElement":[
            {
                "@type":"ListItem",
                "position":1,
                "name":"Trang chủ",
                "item":"{{ url('/') }}"
            },
            {
                "@type":"ListItem",
                "position":2,
                "name":"Góc sức khoẻ",
                "item":"{{ route('website.health-corner.index') }}"
            },
            {
                "@type":"ListItem",
                "position":3,
                "name":"{{ $selectedCategory->name }}",
                "item":"{{ route('website.health-corner.index', ['category' => $selectedCategory->id]) }}"
            }
        ]
    }
}
</script>

<script>
    (function () {
        const activeTab = document.querySelector('.hc-tab--active');
        if (activeTab && typeof activeTab.scrollIntoView === 'function') {
            activeTab.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }
    })();
</script>
@endsection