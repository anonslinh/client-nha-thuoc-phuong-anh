@php
    $healthCornerList = $healthCornerList ?? collect();
@endphp

<style>
    #pa-health-corner .pa-hc-panels{
        width: 100%;
        margin-top: 22px;
    }

    #pa-health-corner .pa-hc-panel[hidden]{
        display: none !important;
    }

    #pa-health-corner .pa-hc-layout{
        width: 100%;
        display: grid;
        grid-template-columns: minmax(0, 1.38fr) minmax(380px, 0.92fr);
        gap: 24px;
        align-items: stretch;
    }

    #pa-health-corner .pa-hc-featured{
        min-width: 0;
        background: #ffffff;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    #pa-health-corner .pa-hc-featured-link{
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }

    #pa-health-corner .pa-hc-featured-link:hover{
        color: inherit;
    }

    #pa-health-corner .pa-hc-featured-media{
        position: relative;
        min-height: 520px;
        background: #edf2f7;
        overflow: hidden;
    }

    #pa-health-corner .pa-hc-featured-media img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    #pa-health-corner .pa-hc-featured-overlay{
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to top,
            rgba(15, 23, 42, 0.82) 0%,
            rgba(15, 23, 42, 0.22) 42%,
            rgba(15, 23, 42, 0) 70%
        );
    }

    #pa-health-corner .pa-hc-featured-chip{
        position: absolute;
        left: 22px;
        bottom: 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 999px;
        background: rgba(17, 24, 39, 0.82);
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        z-index: 2;
    }

    #pa-health-corner .pa-hc-featured-chip-dot{
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #35e06b;
        flex: 0 0 auto;
    }

    #pa-health-corner .pa-hc-featured-body{
        padding: 28px 28px 30px;
    }

    #pa-health-corner .pa-hc-featured-title{
        margin: 0 0 14px;
        font-size: 34px;
        line-height: 1.28;
        font-weight: 800;
        color: #182230;
    }

    #pa-health-corner .pa-hc-featured-desc{
        margin: 0;
        font-size: 18px;
        line-height: 1.72;
        color: #5f6b7a;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    #pa-health-corner .pa-hc-side{
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    #pa-health-corner .pa-hc-item{
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.10);
        overflow: hidden;
    }

    #pa-health-corner .pa-hc-item-link{
        display: grid;
        grid-template-columns: 190px minmax(0, 1fr);
        gap: 16px;
        align-items: stretch;
        padding: 14px;
        min-height: 156px;
        text-decoration: none;
        color: inherit;
    }

    #pa-health-corner .pa-hc-item-link:hover{
        color: inherit;
    }

    #pa-health-corner .pa-hc-item-thumb{
        width: 100%;
        height: 128px;
        border-radius: 18px;
        overflow: hidden;
        background: #eef3f8;
    }

    #pa-health-corner .pa-hc-item-thumb img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    #pa-health-corner .pa-hc-item-body{
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    #pa-health-corner .pa-hc-item-category{
        margin-bottom: 8px;
        font-size: 15px;
        line-height: 1.4;
        font-weight: 700;
        color: #6c7685;
    }

    #pa-health-corner .pa-hc-item-title{
        margin: 0 0 8px;
        font-size: 22px;
        line-height: 1.38;
        font-weight: 800;
        color: #182230;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    #pa-health-corner .pa-hc-item-desc{
        margin: 0;
        font-size: 15px;
        line-height: 1.6;
        color: #687384;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    #pa-health-corner .pa-hc-empty{
        background: #fff;
        border-radius: 24px;
        padding: 24px;
        color: #667085;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
    }

    @media (max-width: 1399px){
        #pa-health-corner .pa-hc-layout{
            grid-template-columns: minmax(0, 1.25fr) minmax(340px, 0.95fr);
        }

        #pa-health-corner .pa-hc-featured-media{
            min-height: 470px;
        }

        #pa-health-corner .pa-hc-featured-title{
            font-size: 30px;
        }

        #pa-health-corner .pa-hc-item-link{
            grid-template-columns: 160px minmax(0, 1fr);
        }

        #pa-health-corner .pa-hc-item-thumb{
            height: 116px;
        }

        #pa-health-corner .pa-hc-item-title{
            font-size: 20px;
        }
    }

    @media (max-width: 1199px){
        #pa-health-corner .pa-hc-layout{
            grid-template-columns: 1fr;
        }

        #pa-health-corner .pa-hc-featured-media{
            min-height: 420px;
        }
    }

    @media (max-width: 767px){
        #pa-health-corner .pa-hc-panels{
            margin-top: 16px;
        }

        #pa-health-corner .pa-hc-featured{
            border-radius: 22px;
        }

        #pa-health-corner .pa-hc-featured-media{
            min-height: 250px;
        }

        #pa-health-corner .pa-hc-featured-chip{
            left: 14px;
            bottom: 14px;
            padding: 8px 12px;
            font-size: 14px;
        }

        #pa-health-corner .pa-hc-featured-body{
            padding: 18px;
        }

        #pa-health-corner .pa-hc-featured-title{
            font-size: 22px;
            margin-bottom: 10px;
        }

        #pa-health-corner .pa-hc-featured-desc{
            font-size: 14px;
            -webkit-line-clamp: 4;
        }

        #pa-health-corner .pa-hc-side{
            gap: 14px;
        }

        #pa-health-corner .pa-hc-item{
            border-radius: 18px;
        }

        #pa-health-corner .pa-hc-item-link{
            grid-template-columns: 110px minmax(0, 1fr);
            gap: 12px;
            padding: 12px;
            min-height: unset;
        }

        #pa-health-corner .pa-hc-item-thumb{
            height: 88px;
            border-radius: 12px;
        }

        #pa-health-corner .pa-hc-item-category{
            font-size: 12px;
            margin-bottom: 4px;
        }

        #pa-health-corner .pa-hc-item-title{
            font-size: 16px;
            margin-bottom: 5px;
        }

        #pa-health-corner .pa-hc-item-desc{
            font-size: 13px;
            -webkit-line-clamp: 2;
        }
    }
</style>

<section id="pa-health-corner" class="lc-health" aria-label="Góc sức khoẻ">
    <div class="lc-container">
        <div class="lc-health-header">
            <div class="lc-health-title-wrap">
                <div class="lc-section-header-icon">📚</div>
                <h2 class="lc-health-title">Góc sức khoẻ</h2>
            </div>

            <a href="{{ route('website.health-corner.index') }}" class="lc-health-viewall">
                <span>Xem tất cả</span>
                <span>›</span>
            </a>
        </div>

        @if($healthCornerList->count() > 0)
            <div class="lc-health-tags">
                @foreach($healthCornerList as $category)
                    <button
                        class="lc-health-tag {{ $loop->first ? 'lc-health-tag--active' : '' }}"
                        type="button"
                        data-health-tab="{{ $category->id }}"
                    >
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <div class="pa-hc-panels">
                @foreach($healthCornerList as $category)
                    @php
                        $featured = $category->featured;
                        $items = $category->items ?? collect();

                        $featuredImage = $featured ? ($featured->banner ?: $featured->avatar) : null;
                        if ($featuredImage && !\Illuminate\Support\Str::startsWith($featuredImage, ['http://', 'https://'])) {
                            $featuredImage = asset($featuredImage);
                        }
                        if (!$featuredImage) {
                            $featuredImage = asset('phuonganh/img/health-main-placeholder.jpg');
                        }

                        $featuredUrl = $featured
                            ? url('/goc-suc-khoe/' . $category->id . '/' . $featured->id)
                            : 'javascript:void(0)';

                        $featuredDesc = $featured
                            ? ($featured->short_description ?: \Illuminate\Support\Str::limit(strip_tags($featured->content), 180))
                            : '';

                    @endphp

                    <div class="pa-hc-panel" data-health-panel="{{ $category->id }}" @if(!$loop->first) hidden @endif>
                        <div class="pa-hc-layout">
                            <article class="pa-hc-featured">
                                <a href="{{ $featuredUrl }}" class="pa-hc-featured-link">
                                    <div class="pa-hc-featured-media">
                                        <img src="{{ $featuredImage }}" alt="{{ $featured->title ?? $category->name }}">
                                        <div class="pa-hc-featured-overlay"></div>

                                        <div class="pa-hc-featured-chip">
                                            <span class="pa-hc-featured-chip-dot"></span>
                                            <span>{{ $category->name }}</span>
                                        </div>
                                    </div>

                                    <div class="pa-hc-featured-body">
                                        <h3 class="pa-hc-featured-title">
                                            {{ $featured->title ?? $category->name }}
                                        </h3>

                                        <p class="pa-hc-featured-desc">
                                            {{ $featuredDesc }}
                                        </p>
                                    </div>
                                </a>
                            </article>

                            <div class="pa-hc-side">
                                @forelse($items as $article)
                                    @php
                                        $thumb = $article->avatar ?: $article->banner;
                                        if ($thumb && !\Illuminate\Support\Str::startsWith($thumb, ['http://', 'https://'])) {
                                            $thumb = asset($thumb);
                                        }
                                        if (!$thumb) {
                                            $thumb = asset('phuonganh/img/health-side-1-placeholder.jpg');
                                        }

                                        $articleUrl = url('/goc-suc-khoe/' . $category->id . '/' . $article->id);
                                        $articleDesc = $article->short_description
                                            ?: \Illuminate\Support\Str::limit(strip_tags($article->content), 95);
                                    @endphp

                                    <article class="pa-hc-item">
                                        <a href="{{ $articleUrl }}" class="pa-hc-item-link">
                                            <div class="pa-hc-item-thumb">
                                                <img src="{{ $thumb }}" alt="{{ $article->title }}">
                                            </div>

                                            <div class="pa-hc-item-body">
                                                <div class="pa-hc-item-category">{{ $category->name }}</div>

                                                <h4 class="pa-hc-item-title">
                                                    {{ $article->title }}
                                                </h4>

                                                <p class="pa-hc-item-desc">
                                                    {{ $articleDesc }}
                                                </p>
                                            </div>
                                        </a>
                                    </article>
                                @empty
                                    <div class="pa-hc-empty">
                                        Danh mục này hiện chưa có thêm bài viết để hiển thị.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<script>
    (function () {
        const root = document.getElementById('pa-health-corner');
        if (!root) return;

        const tabs = root.querySelectorAll('[data-health-tab]');
        const panels = root.querySelectorAll('[data-health-panel]');

        if (!tabs.length || !panels.length) return;

        const activateTab = (id) => {
            tabs.forEach((tab) => {
                const active = tab.getAttribute('data-health-tab') === String(id);
                tab.classList.toggle('lc-health-tag--active', active);
            });

            panels.forEach((panel) => {
                const active = panel.getAttribute('data-health-panel') === String(id);
                panel.hidden = !active;
            });
        };

        tabs.forEach((tab) => {
            tab.addEventListener('click', function () {
                activateTab(this.getAttribute('data-health-tab'));
            });
        });

        const firstTab = root.querySelector('[data-health-tab].lc-health-tag--active') || tabs[0];
        if (firstTab) {
            activateTab(firstTab.getAttribute('data-health-tab'));
        }
    })();
</script>