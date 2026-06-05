@extends('website.layout.index')

@section('style')
<style>
    .hcd-page{
        padding: 28px 0 56px;
        background: #f6f8fc;
    }

    .hcd-container{
        width: min(1280px, calc(100% - 32px));
        margin: 0 auto;
    }

    .hcd-breadcrumb{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        font-size: 14px;
        color: #667085;
    }

    .hcd-breadcrumb a{
        color: #0ea5c6;
        text-decoration: none;
    }

    .hcd-breadcrumb a:hover{
        text-decoration: underline;
    }

    .hcd-layout{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 24px;
        align-items: start;
    }

    .hcd-article,
    .hcd-side-card{
        background: #fff;
        border-radius: 28px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
    }

    .hcd-article{
        overflow: hidden;
    }

    .hcd-header{
        padding: 30px 32px 22px;
        border-bottom: 1px solid #edf2f7;
    }

    .hcd-category{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 14px;
        border-radius: 999px;
        background: #e9fafc;
        color: #0ea5c6;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        margin-bottom: 16px;
    }

    .hcd-title{
        margin: 0 0 14px;
        font-size: 42px;
        line-height: 1.2;
        font-weight: 800;
        color: #0f172a;
    }

    .hcd-desc{
        margin: 0 0 16px;
        font-size: 17px;
        line-height: 1.8;
        color: #5f6b7a;
    }

    .hcd-meta{
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        font-size: 14px;
        color: #667085;
    }

    .hcd-hero{
        background: #eef3f8;
    }

    .hcd-hero img{
        width: 100%;
        max-height: 560px;
        object-fit: cover;
        display: block;
    }

    .hcd-content-wrap{
        padding: 28px 32px 34px;
    }

    .hcd-toc{
        background: #f8fbfd;
        border: 1px solid #e5eef5;
        border-radius: 20px;
        padding: 18px 18px 14px;
        margin-bottom: 24px;
    }

    .hcd-toc h2{
        margin: 0 0 10px;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .hcd-toc ul{
        margin: 0;
        padding-left: 18px;
    }

    .hcd-toc li{
        margin: 8px 0;
    }

    .hcd-toc a{
        color: #0ea5c6;
        text-decoration: none;
        line-height: 1.6;
    }

    .hcd-toc a:hover{
        text-decoration: underline;
    }

    .hcd-content{
        color: #1f2937;
        font-size: 17px;
        line-height: 1.9;
        word-break: break-word;
    }

    .hcd-content > *:first-child{
        margin-top: 0 !important;
    }

    .hcd-content h2,
    .hcd-content h3,
    .hcd-content h4{
        color: #0f172a;
        line-height: 1.35;
        font-weight: 800;
        margin: 28px 0 14px;
    }

    .hcd-content h2{ font-size: 30px; }
    .hcd-content h3{ font-size: 24px; }
    .hcd-content h4{ font-size: 20px; }

    .hcd-content p{
        margin: 0 0 16px;
    }

    .hcd-content ul,
    .hcd-content ol{
        margin: 0 0 18px 22px;
        padding: 0;
    }

    .hcd-content li{
        margin-bottom: 8px;
    }

    .hcd-content img{
        max-width: 100%;
        height: auto;
        border-radius: 18px;
        display: block;
        margin: 20px auto;
    }

    .hcd-content table{
        width: 100%;
        border-collapse: collapse;
        overflow: hidden;
        display: block;
        margin: 18px 0;
        border-radius: 14px;
    }

    .hcd-content table td,
    .hcd-content table th{
        border: 1px solid #e5edf5;
        padding: 10px 12px;
    }

    .hcd-content blockquote{
        margin: 18px 0;
        padding: 16px 18px;
        border-left: 4px solid #0ea5c6;
        background: #f8fbfd;
        border-radius: 0 14px 14px 0;
        color: #334155;
    }

    .hcd-footer{
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid #edf2f7;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .hcd-footer__cat{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        background: #f4f8fb;
        font-size: 14px;
        color: #0f172a;
        font-weight: 700;
    }

    .hcd-side-card{
        padding: 20px;
    }

    .hcd-side-card + .hcd-side-card{
        margin-top: 18px;
    }

    .hcd-side-card h3{
        margin: 0 0 14px;
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
    }

    .hcd-side-list{
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .hcd-side-link{
        display: grid;
        grid-template-columns: 88px minmax(0, 1fr);
        gap: 12px;
        text-decoration: none;
        color: inherit;
    }

    .hcd-side-link:hover .hcd-side-link__title{
        color: #0ea5c6;
    }

    .hcd-side-link__thumb{
        width: 88px;
        height: 72px;
        border-radius: 14px;
        overflow: hidden;
        background: #eef3f8;
    }

    .hcd-side-link__thumb img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .hcd-side-link__title{
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

    .hcd-side-link__meta{
        font-size: 13px;
        color: #667085;
    }

    .hcd-category-list{
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .hcd-category-item{
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

    .hcd-category-item:hover{
        background: #eef8fb;
        color: #0ea5c6;
    }

    .hcd-category-item--active{
        background: #e8f9fd;
        color: #0ea5c6;
    }

    @media (max-width: 1199px){
        .hcd-layout{
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px){
        .hcd-page{
            padding: 20px 0 40px;
        }

        .hcd-container{
            width: min(100%, calc(100% - 20px));
        }

        .hcd-header{
            padding: 22px 18px 18px;
        }

        .hcd-title{
            font-size: 28px;
        }

        .hcd-desc{
            font-size: 15px;
        }

        .hcd-content-wrap{
            padding: 20px 18px 24px;
        }

        .hcd-content{
            font-size: 15px;
            line-height: 1.8;
        }

        .hcd-content h2{ font-size: 24px; }
        .hcd-content h3{ font-size: 20px; }
        .hcd-content h4{ font-size: 18px; }
    }
</style>
@endsection

@section('content')
@php
    $heroImage = $article->banner ?: $article->avatar;
    if ($heroImage && !\Illuminate\Support\Str::startsWith($heroImage, ['http://', 'https://'])) {
        $heroImage = asset($heroImage);
    }
    if (!$heroImage) {
        $heroImage = asset('phuonganh/img/health-main-placeholder.jpg');
    }
@endphp

<section class="hcd-page">
    <div class="hcd-container">
        <nav class="hcd-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <span>/</span>
            <a href="{{ route('website.health-corner.index') }}">Góc sức khoẻ</a>
            <span>/</span>
            <a href="{{ route('website.health-corner.index', ['category' => $category->id]) }}">{{ $category->name }}</a>
            <span>/</span>
            <span>{{ $article->title }}</span>
        </nav>

        <div class="hcd-layout">
            <article class="hcd-article" itemscope itemtype="https://schema.org/Article">
                <header class="hcd-header">
                    <a
                        href="{{ route('website.health-corner.index', ['category' => $category->id]) }}"
                        class="hcd-category"
                    >
                        {{ $category->name }}
                    </a>

                    <h1 class="hcd-title" itemprop="headline">{{ $article->title }}</h1>
                    <p class="hcd-desc" itemprop="description">{{ $articleDescription }}</p>

                    <div class="hcd-meta">
                        <span>Tác giả: Nhà thuốc Phương Anh</span>
                        <time
                            itemprop="datePublished"
                            datetime="{{ \Carbon\Carbon::parse($article->posted_at ?: $article->created_at)->format('c') }}"
                        >
                            {{ \Carbon\Carbon::parse($article->posted_at ?: $article->created_at)->format('d/m/Y') }}
                        </time>
                    </div>
                </header>

                <div class="hcd-hero">
                    <img src="{{ $heroImage }}" alt="{{ $article->title }}" itemprop="image">
                </div>

                <div class="hcd-content-wrap">
                    <div class="hcd-toc" id="hcdToc" hidden>
                        <h2>Mục lục bài viết</h2>
                        <ul id="hcdTocList"></ul>
                    </div>

                    <div class="hcd-content" id="hcdArticleContent" itemprop="articleBody">
                        {!! $article->content !!}
                    </div>

                    <div class="hcd-footer">
                        <div class="hcd-footer__cat">
                            <span>Chuyên mục:</span>
                            <strong>{{ $category->name }}</strong>
                        </div>
                    </div>
                </div>
            </article>

            <aside>
                @if($relatedArticles->count() > 0)
                    <div class="hcd-side-card">
                        <h3>Bài viết liên quan</h3>
                        <div class="hcd-side-list">
                            @foreach($relatedArticles as $related)
                                @php
                                    $relatedThumb = $related->avatar ?: $related->banner;
                                    if ($relatedThumb && !\Illuminate\Support\Str::startsWith($relatedThumb, ['http://', 'https://'])) {
                                        $relatedThumb = asset($relatedThumb);
                                    }
                                    if (!$relatedThumb) {
                                        $relatedThumb = asset('phuonganh/img/health-side-1-placeholder.jpg');
                                    }
                                @endphp

                                <a
                                    href="{{ route('website.health-corner.show', ['category' => $related->id_category, 'article' => $related->id]) }}"
                                    class="hcd-side-link"
                                >
                                    <div class="hcd-side-link__thumb">
                                        <img src="{{ $relatedThumb }}" alt="{{ $related->title }}" loading="lazy">
                                    </div>
                                    <div>
                                        <h4 class="hcd-side-link__title">{{ $related->title }}</h4>
                                        <div class="hcd-side-link__meta">
                                            {{ \Carbon\Carbon::parse($related->posted_at)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="hcd-side-card">
                    <h3>Bài viết mới</h3>
                    <div class="hcd-side-list">
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
                                class="hcd-side-link"
                            >
                                <div class="hcd-side-link__thumb">
                                    <img src="{{ $latestThumb }}" alt="{{ $latest->title }}" loading="lazy">
                                </div>
                                <div>
                                    <h4 class="hcd-side-link__title">{{ $latest->title }}</h4>
                                    <div class="hcd-side-link__meta">
                                        {{ \Carbon\Carbon::parse($latest->posted_at)->format('d/m/Y') }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="hcd-side-card">
                    <h3>Danh mục bài viết</h3>
                    <div class="hcd-category-list">
                        @foreach($categories as $cat)
                            <a
                                href="{{ route('website.health-corner.index', ['category' => $cat->id]) }}"
                                class="hcd-category-item {{ $cat->id == $category->id ? 'hcd-category-item--active' : '' }}"
                            >
                                <span>{{ $cat->name }}</span>
                                <span>{{ $categoryCounts[$cat->id] ?? 0 }}</span>
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
    "@type":"Article",
    "headline":"{{ addslashes($article->title) }}",
    "description":"{{ addslashes($articleDescription) }}",
    "image":"{{ $heroImage }}",
    "datePublished":"{{ \Carbon\Carbon::parse($article->posted_at ?: $article->created_at)->format('c') }}",
    "author":{
        "@type":"Organization",
        "name":"Nhà thuốc Phương Anh"
    },
    "publisher":{
        "@type":"Organization",
        "name":"Nhà thuốc Phương Anh"
    },
    "mainEntityOfPage":"{{ route('website.health-corner.show', ['category' => $category->id, 'article' => $article->id]) }}"
}
</script>

<script type="application/ld+json">
{
    "@context":"https://schema.org",
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
            "name":"{{ $category->name }}",
            "item":"{{ route('website.health-corner.index', ['category' => $category->id]) }}"
        },
        {
            "@type":"ListItem",
            "position":4,
            "name":"{{ addslashes($article->title) }}",
            "item":"{{ route('website.health-corner.show', ['category' => $category->id, 'article' => $article->id]) }}"
        }
    ]
}
</script>

<script>
    (function () {
        const content = document.getElementById('hcdArticleContent');
        const toc = document.getElementById('hcdToc');
        const tocList = document.getElementById('hcdTocList');

        if (!content || !toc || !tocList) return;

        const headings = content.querySelectorAll('h2, h3');
        if (!headings.length) return;

        headings.forEach((heading, index) => {
            if (!heading.id) {
                heading.id = 'hcd-heading-' + (index + 1);
            }

            const li = document.createElement('li');
            if (heading.tagName.toLowerCase() === 'h3') {
                li.style.marginLeft = '14px';
            }

            const a = document.createElement('a');
            a.href = '#' + heading.id;
            a.textContent = heading.textContent.trim();

            li.appendChild(a);
            tocList.appendChild(li);
        });

        toc.hidden = false;
    })();
</script>
@endsection