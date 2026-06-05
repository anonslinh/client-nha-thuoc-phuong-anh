@extends('website.layout.index')

@section('style')
<style>
    .dsa-page{
        padding: 28px 0 56px;
        background: #f6f8fc;
    }

    .dsa-container{
        width: min(1280px, calc(100% - 32px));
        margin: 0 auto;
    }

    .dsa-breadcrumb{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        font-size: 14px;
        color: #667085;
    }

    .dsa-breadcrumb a{
        color: #0ea5c6;
        text-decoration: none;
    }

    .dsa-breadcrumb a:hover{
        text-decoration: underline;
    }

    .dsa-layout{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 24px;
        align-items: start;
    }

    .dsa-article,
    .dsa-side-card{
        background: #fff;
        border-radius: 28px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .08);
    }

    .dsa-article{
        overflow: hidden;
    }

    .dsa-header{
        padding: 30px 32px 22px;
        border-bottom: 1px solid #edf2f7;
    }

    .dsa-back{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        padding: 10px 14px;
        border-radius: 999px;
        background: #f4f8fb;
        color: #0ea5c6;
        text-decoration: none;
        font-size: 14px;
        font-weight: 800;
    }

    .dsa-category{
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

    .dsa-title{
        margin: 0 0 14px;
        font-size: 42px;
        line-height: 1.2;
        font-weight: 900;
        color: #0f172a;
    }

    .dsa-desc{
        margin: 0 0 16px;
        font-size: 17px;
        line-height: 1.8;
        color: #5f6b7a;
    }

    .dsa-meta{
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        font-size: 14px;
        color: #667085;
        font-weight: 700;
    }

    .dsa-hero{
        background: #eef3f8;
    }

    .dsa-hero img{
        width: 100%;
        max-height: 560px;
        object-fit: cover;
        display: block;
    }

    .dsa-content-wrap{
        padding: 28px 32px 34px;
    }

    .dsa-toc{
        background: #f8fbfd;
        border: 1px solid #e5eef5;
        border-radius: 20px;
        padding: 18px 18px 14px;
        margin-bottom: 24px;
    }

    .dsa-toc h2{
        margin: 0 0 10px;
        font-size: 18px;
        font-weight: 900;
        color: #0f172a;
    }

    .dsa-toc ul{
        margin: 0;
        padding-left: 18px;
    }

    .dsa-toc li{
        margin: 8px 0;
    }

    .dsa-toc a{
        color: #0ea5c6;
        text-decoration: none;
        line-height: 1.6;
    }

    .dsa-toc a:hover{
        text-decoration: underline;
    }

    .dsa-content{
        color: #1f2937;
        font-size: 17px;
        line-height: 1.9;
        word-break: break-word;
    }

    .dsa-content > *:first-child{
        margin-top: 0 !important;
    }

    .dsa-content h2,
    .dsa-content h3,
    .dsa-content h4{
        color: #0f172a;
        line-height: 1.35;
        font-weight: 900;
        margin: 28px 0 14px;
    }

    .dsa-content h2{ font-size: 30px; }
    .dsa-content h3{ font-size: 24px; }
    .dsa-content h4{ font-size: 20px; }

    .dsa-content p{
        margin: 0 0 16px;
    }

    .dsa-content ul,
    .dsa-content ol{
        margin: 0 0 18px 22px;
        padding: 0;
    }

    .dsa-content li{
        margin-bottom: 8px;
    }

    .dsa-content img{
        max-width: 100%;
        height: auto;
        border-radius: 18px;
        display: block;
        margin: 20px auto;
    }

    .dsa-content table{
        width: 100%;
        border-collapse: collapse;
        overflow: hidden;
        display: block;
        margin: 18px 0;
        border-radius: 14px;
    }

    .dsa-content table td,
    .dsa-content table th{
        border: 1px solid #e5edf5;
        padding: 10px 12px;
    }

    .dsa-content blockquote{
        margin: 18px 0;
        padding: 16px 18px;
        border-left: 4px solid #0ea5c6;
        background: #f8fbfd;
        border-radius: 0 14px 14px 0;
        color: #334155;
    }

    .dsa-footer{
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid #edf2f7;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .dsa-footer__cat{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        background: #f4f8fb;
        font-size: 14px;
        color: #0f172a;
        font-weight: 800;
    }

    .dsa-side-card{
        padding: 20px;
    }

    .dsa-side-card + .dsa-side-card{
        margin-top: 18px;
    }

    .dsa-side-card h3{
        margin: 0 0 14px;
        font-size: 20px;
        font-weight: 900;
        color: #0f172a;
    }

    .dsa-side-list{
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .dsa-side-link{
        display: grid;
        grid-template-columns: 88px minmax(0, 1fr);
        gap: 12px;
        text-decoration: none;
        color: inherit;
    }

    .dsa-side-link__thumb{
        width: 88px;
        height: 72px;
        border-radius: 14px;
        overflow: hidden;
        background: #eef3f8;
    }

    .dsa-side-link__thumb img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .dsa-side-link__title{
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

    .dsa-side-link__meta{
        font-size: 13px;
        color: #667085;
    }

    .dsa-category-list{
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .dsa-category-item{
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

    .dsa-category-item:hover{
        background: #eef8fb;
        color: #0ea5c6;
    }

    .dsa-category-item--active{
        background: #e8f9fd;
        color: #0ea5c6;
    }

    @media (max-width: 1199px){
        .dsa-layout{
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px){
        .dsa-page{
            padding: 20px 0 40px;
        }

        .dsa-container{
            width: min(100%, calc(100% - 20px));
        }

        .dsa-header{
            padding: 22px 18px 18px;
        }

        .dsa-title{
            font-size: 28px;
        }

        .dsa-desc{
            font-size: 15px;
        }

        .dsa-content-wrap{
            padding: 20px 18px 24px;
        }

        .dsa-content{
            font-size: 15px;
            line-height: 1.8;
        }

        .dsa-content h2{ font-size: 24px; }
        .dsa-content h3{ font-size: 20px; }
        .dsa-content h4{ font-size: 18px; }
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
        $heroImage = asset('phuonganh/img/disease-men-placeholder.webp');
    }
@endphp

<section class="dsa-page">
    <div class="dsa-container">
        <nav class="dsa-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <span>/</span>
            <span>{{ $typeLabel }}</span>
            <span>/</span>
            <a href="{{ route('website.disease.category', ['category' => $category->id]) }}">{{ $category->name }}</a>
            <span>/</span>
            <span>{{ $article->title }}</span>
        </nav>

        <div class="dsa-layout">
            <article class="dsa-article" itemscope itemtype="https://schema.org/Article">
                <header class="dsa-header">
                    <a
                        href="{{ route('website.disease.category', ['category' => $category->id]) }}"
                        class="dsa-back"
                    >
                        ← Quay lại danh mục bệnh
                    </a>

                    <a
                        href="{{ route('website.disease.category', ['category' => $category->id]) }}"
                        class="dsa-category"
                    >
                        {{ $category->name }}
                    </a>

                    <h1 class="dsa-title" itemprop="headline">{{ $article->title }}</h1>
                    <p class="dsa-desc" itemprop="description">{{ $articleDescription }}</p>

                    <div class="dsa-meta">
                        <span>{{ $typeLabel }}</span>
                        <time
                            itemprop="datePublished"
                            datetime="{{ \Carbon\Carbon::parse($article->posted_at ?: $article->created_at)->format('c') }}"
                        >
                            {{ \Carbon\Carbon::parse($article->posted_at ?: $article->created_at)->format('d/m/Y') }}
                        </time>
                    </div>
                </header>

                <div class="dsa-hero">
                    <img src="{{ $heroImage }}" alt="{{ $article->title }}" itemprop="image">
                </div>

                <div class="dsa-content-wrap">
                    <div class="dsa-toc" id="dsaToc" hidden>
                        <h2>Mục lục bài viết</h2>
                        <ul id="dsaTocList"></ul>
                    </div>

                    <div class="dsa-content" id="dsaArticleContent" itemprop="articleBody">
                        {!! $article->content !!}
                    </div>

                    <div class="dsa-footer">
                        <div class="dsa-footer__cat">
                            <span>Danh mục:</span>
                            <strong>{{ $category->name }}</strong>
                        </div>
                    </div>
                </div>
            </article>

            <aside>
                @if($relatedArticles->count() > 0)
                    <div class="dsa-side-card">
                        <h3>Bài viết liên quan</h3>
                        <div class="dsa-side-list">
                            @foreach($relatedArticles as $related)
                                @php
                                    $relatedThumb = $related->avatar ?: $related->banner;
                                    if ($relatedThumb && !\Illuminate\Support\Str::startsWith($relatedThumb, ['http://', 'https://'])) {
                                        $relatedThumb = asset($relatedThumb);
                                    }
                                    if (!$relatedThumb) {
                                        $relatedThumb = asset('phuonganh/img/disease-men-placeholder.webp');
                                    }
                                @endphp

                                <a
                                    href="{{ route('website.disease.article', ['category' => $related->id_category, 'article' => $related->id]) }}"
                                    class="dsa-side-link"
                                >
                                    <div class="dsa-side-link__thumb">
                                        <img src="{{ $relatedThumb }}" alt="{{ $related->title }}">
                                    </div>
                                    <div>
                                        <h4 class="dsa-side-link__title">{{ $related->title }}</h4>
                                        <div class="dsa-side-link__meta">
                                            {{ \Carbon\Carbon::parse($related->posted_at ?: $related->created_at)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($latestArticles->count() > 0)
                    <div class="dsa-side-card">
                        <h3>Bài viết mới</h3>
                        <div class="dsa-side-list">
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
                                    class="dsa-side-link"
                                >
                                    <div class="dsa-side-link__thumb">
                                        <img src="{{ $latestThumb }}" alt="{{ $latest->title }}">
                                    </div>
                                    <div>
                                        <h4 class="dsa-side-link__title">{{ $latest->title }}</h4>
                                        <div class="dsa-side-link__meta">
                                            {{ \Carbon\Carbon::parse($latest->posted_at)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($relatedCategories->count() > 0)
                    <div class="dsa-side-card">
                        <h3>Danh mục cùng nhóm</h3>
                        <div class="dsa-category-list">
                            @foreach($relatedCategories as $relatedCategory)
                                <a
                                    href="{{ route('website.disease.category', ['category' => $relatedCategory->id]) }}"
                                    class="dsa-category-item {{ $relatedCategory->id == $category->id ? 'dsa-category-item--active' : '' }}"
                                >
                                    <span>{{ $relatedCategory->name }}</span>
                                    <span>{{ $relatedCategoryCountMap[$relatedCategory->id] ?? 0 }}</span>
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
    "mainEntityOfPage":"{{ route('website.disease.article', ['category' => $category->id, 'article' => $article->id]) }}"
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const content = document.getElementById('dsaArticleContent');
    const toc = document.getElementById('dsaToc');
    const tocList = document.getElementById('dsaTocList');

    if (!content || !toc || !tocList) return;

    const headings = content.querySelectorAll('h2, h3');
    if (!headings.length) return;

    headings.forEach((heading, index) => {
        if (!heading.id) {
            heading.id = 'dsa-heading-' + (index + 1);
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
});
</script>
@endsection