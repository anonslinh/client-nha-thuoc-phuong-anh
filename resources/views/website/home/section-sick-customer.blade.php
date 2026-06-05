@php
    $listSick = $listSick ?? (object) [
        'default_type' => 1,
        'groups' => collect(),
    ];

    $diseaseGroups = collect($listSick->groups ?? []);
    $defaultDiseaseType = (int) ($listSick->default_type ?? 1);
@endphp

<style>
    #pa-disease-hub{
        padding: 28px 0 10px;
    }

    #pa-disease-hub .pa-ds-wrap{
        width: 100%;
    }

    #pa-disease-hub .pa-ds-header{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    #pa-disease-hub .pa-ds-title-wrap{
        display: flex;
        align-items: center;
        gap: 12px;
    }

    #pa-disease-hub .pa-ds-icon{
        width: 25px;
        height: 25px;
        border-radius: 16px;
        background: linear-gradient(135deg, #10b7d3 0%, #1593cf 100%);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        box-shadow: 0 16px 28px rgba(20, 144, 207, .18);
        flex: 0 0 auto;
    }

    #pa-disease-hub .pa-ds-title{
        margin: 0;
        font-size: 23px;
        line-height: 1.2;
        font-weight: 800;
        color: #0f172a;
    }

    #pa-disease-hub .pa-ds-viewall{
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        color: #10a7d6;
        font-size: 14px;
        font-weight: 800;
    }

    #pa-disease-hub .pa-ds-switch{
        display: inline-flex;
        gap: 10px;
        padding: 8px;
        border-radius: 999px;
        background: #eef5fb;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    #pa-disease-hub .pa-ds-switch-btn{
        border: 0;
        outline: 0;
        cursor: pointer;
        min-height: 50px;
        padding: 0 22px;
        border-radius: 999px;
        background: transparent;
        color: #425466;
        font-size: 18px;
        font-weight: 800;
        transition: all .2s ease;
    }

    #pa-disease-hub .pa-ds-switch-btn--active{
        background: linear-gradient(135deg, #12b8d4 0%, #1593cf 100%);
        color: #fff;
        box-shadow: 0 12px 24px rgba(20, 144, 207, .18);
    }

    #pa-disease-hub .pa-ds-panel[hidden]{
        display: none !important;
    }

    #pa-disease-hub .pa-ds-mode-head{
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        padding: 26px 28px;
        background:
            radial-gradient(circle at top right, rgba(255,255,255,.16), transparent 24%),
            linear-gradient(135deg, #0ea5c6 0%, #0f7db8 100%);
        color: #fff;
        box-shadow: 0 20px 42px rgba(14, 165, 198, .16);
        margin-bottom: 22px;
    }

    #pa-disease-hub .pa-ds-mode-badge{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 34px;
        padding: 0 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.16);
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    #pa-disease-hub .pa-ds-mode-title{
        margin: 0 0 8px;
        font-size: 30px;
        line-height: 1.25;
        font-weight: 900;
    }

    #pa-disease-hub .pa-ds-mode-desc{
        margin: 0;
        max-width: 860px;
        font-size: 15px;
        line-height: 1.8;
        color: rgba(255,255,255,.94);
    }

    #pa-disease-hub .pa-ds-grid{
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    #pa-disease-hub .pa-ds-card{
        background: #fff;
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .08);
        border: 1px solid #edf2f7;
        display: flex;
        flex-direction: column;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    #pa-disease-hub .pa-ds-card:hover{
        transform: translateY(-4px);
        box-shadow: 0 24px 46px rgba(15, 23, 42, .12);
    }

    #pa-disease-hub .pa-ds-card-media{
        position: relative;
        aspect-ratio: 16 / 10;
        background: linear-gradient(180deg, #eef4f8 0%, #f8fbfd 100%);
        overflow: hidden;
    }

    #pa-disease-hub .pa-ds-card-media img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    #pa-disease-hub .pa-ds-card-media::after{
        content: "";
        position: absolute;
        inset: auto 0 0 0;
        height: 42%;
        background: linear-gradient(to top, rgba(15, 23, 42, .52) 0%, rgba(15, 23, 42, 0) 100%);
    }

    #pa-disease-hub .pa-ds-card-count{
        position: absolute;
        left: 16px;
        bottom: 14px;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 34px;
        padding: 0 14px;
        border-radius: 999px;
        background: rgba(15, 23, 42, .74);
        color: #fff;
        font-size: 13px;
        font-weight: 800;
    }

    #pa-disease-hub .pa-ds-card-body{
        padding: 22px 22px 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    #pa-disease-hub .pa-ds-card-title{
        margin: 0 0 10px;
        font-size: 24px;
        line-height: 1.35;
        font-weight: 900;
        color: #0f172a;
    }

    #pa-disease-hub .pa-ds-card-desc{
        margin: 0 0 16px;
        font-size: 15px;
        line-height: 1.7;
        color: #667085;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 50px;
    }

    #pa-disease-hub .pa-ds-list-head{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
    }

    #pa-disease-hub .pa-ds-list-title{
        font-size: 14px;
        font-weight: 900;
        color: #0f172a;
    }

    #pa-disease-hub .pa-ds-list-sub{
        font-size: 12px;
        color: #98a2b3;
        font-weight: 700;
    }

    #pa-disease-hub .pa-ds-article-list{
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 18px;
    }

    #pa-disease-hub .pa-ds-article-item{
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 15px;
        line-height: 1.6;
        color: #334155;
    }

    #pa-disease-hub .pa-ds-article-dot{
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: linear-gradient(135deg, #12b8d4 0%, #1593cf 100%);
        margin-top: 8px;
        flex: 0 0 auto;
    }

    #pa-disease-hub .pa-ds-actions{
        margin-top: auto;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    #pa-disease-hub .pa-ds-btn{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 46px;
        padding: 0 18px;
        border-radius: 14px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 900;
        transition: all .2s ease;
    }

    #pa-disease-hub .pa-ds-btn--primary{
        background: linear-gradient(135deg, #12b8d4 0%, #1593cf 100%);
        color: #fff;
        box-shadow: 0 12px 24px rgba(20, 144, 207, .16);
    }

    #pa-disease-hub .pa-ds-btn--ghost{
        background: #f7fafc;
        border: 1px solid #dbe5ef;
        color: #0f172a;
    }

    #pa-disease-hub .pa-ds-btn:hover{
        transform: translateY(-1px);
    }

    #pa-disease-hub .pa-ds-empty{
        background: #fff;
        border-radius: 24px;
        padding: 34px 22px;
        text-align: center;
        color: #667085;
        box-shadow: 0 14px 32px rgba(15, 23, 42, .06);
    }

    @media (max-width: 1399px){
        #pa-disease-hub .pa-ds-grid{
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px){
        #pa-disease-hub{
            padding: 20px 0 6px;
        }

        #pa-disease-hub .pa-ds-header{
            align-items: flex-start;
            flex-direction: column;
        }

        #pa-disease-hub .pa-ds-title{
            font-size: 28px;
        }

        #pa-disease-hub .pa-ds-viewall{
            font-size: 16px;
        }

        #pa-disease-hub .pa-ds-switch{
            width: 100%;
            border-radius: 20px;
        }

        #pa-disease-hub .pa-ds-switch-btn{
            flex: 1;
            min-width: 0;
            font-size: 14px;
            padding: 0 14px;
        }

        #pa-disease-hub .pa-ds-mode-head{
            border-radius: 22px;
            padding: 20px 18px;
        }

        #pa-disease-hub .pa-ds-mode-title{
            font-size: 22px;
        }

        #pa-disease-hub .pa-ds-grid{
            grid-template-columns: 1fr;
        }

        #pa-disease-hub .pa-ds-card{
            border-radius: 22px;
        }

        #pa-disease-hub .pa-ds-card-body{
            padding: 18px;
        }

        #pa-disease-hub .pa-ds-card-title{
            font-size: 20px;
        }

        #pa-disease-hub .pa-ds-card-desc,
        #pa-disease-hub .pa-ds-article-item{
            font-size: 14px;
        }

        #pa-disease-hub .pa-ds-actions{
            flex-direction: column;
        }

        #pa-disease-hub .pa-ds-btn{
            width: 100%;
        }
    }
</style>

<section id="pa-disease-hub" aria-label="Bệnh">
    <div class="lc-container">
        <div class="pa-ds-wrap">
            <div class="pa-ds-header">
                <div class="pa-ds-title-wrap">
                    <div class="pa-ds-icon">➕</div>
                    <h4 class="pa-ds-title">Bệnh</h2>
                </div>

                <a href="javascript:void(0)" class="pa-ds-viewall">
                    <span>Xem tất cả</span>
                    <span>›</span>
                </a>
            </div>

            <div class="pa-ds-switch">
                @foreach($diseaseGroups as $group)
                    <button
                    style="
                            font-family: system-ui, -apple-system, BlinkMacSystemFont, &quot;SF Pro Text&quot;, &quot;Helvetica Neue&quot;, Arial, sans-seri;
                        "
                        class="pa-ds-switch-btn {{ $group->type === $defaultDiseaseType ? 'pa-ds-switch-btn--active' : '' }}"
                        type="button"
                        data-pa-disease-type="{{ $group->type }}"
                    >
                        {{ $group->label }}
                    </button>
                @endforeach
            </div>

            @foreach($diseaseGroups as $group)
                @php
                    $groupCount = collect($group->categories ?? [])->count();
                @endphp

                <div
                    class="pa-ds-panel"
                    data-pa-disease-panel="{{ $group->type }}"
                    @if($group->type !== $defaultDiseaseType) hidden @endif
                >
                    <div class="pa-ds-mode-head">
                        <div class="pa-ds-mode-badge">
                            <!-- <span>📚</span> -->
                            <span>{{ $group->label }}</span>
                        </div>

                        <h3 class="pa-ds-mode-title">
                            {{ $group->label }} dành cho người dùng cần tra cứu nhanh
                        </h3>

                        <p class="pa-ds-mode-desc">
                            Khám phá các nhóm bệnh nổi bật, xem nhanh những bài viết được quan tâm nhiều trong từng danh mục
                            và tiếp cận thông tin theo cách trực quan hơn.
                            @if($groupCount > 0)
                                Hiện đang có {{ $groupCount }} danh mục trong nhóm này.
                            @endif
                        </p>
                    </div>

                    @if(collect($group->categories ?? [])->count() > 0)
                        <div class="pa-ds-grid">
                            @foreach($group->categories as $category)
                                @php
                                    $categoryImage = $category->image ?? null;

                                    if ($categoryImage && !\Illuminate\Support\Str::startsWith($categoryImage, ['http://', 'https://'])) {
                                        $categoryImage = asset($categoryImage);
                                    }

                                    if (!$categoryImage) {
                                        $categoryImage = asset('phuonganh/img/disease-men-placeholder.webp');
                                    }

                                    $articles = collect($category->articles ?? []);
                                    $articleCount = $articles->count();
                                    $cardDesc = $category->short_description ?: 'Tổng hợp các bài viết nổi bật trong danh mục này để người dùng dễ tra cứu và tiếp cận thông tin.';
                                @endphp

                                <article class="pa-ds-card">
                                    <div class="pa-ds-card-media">
                                        <img src="{{ $categoryImage }}" alt="{{ $category->name }}">
                                        <div class="pa-ds-card-count">
                                            <span>📄</span>
                                            <span>{{ $articleCount }} bài viết</span>
                                        </div>
                                    </div>

                                    <div class="pa-ds-card-body">
                                        <h3 class="pa-ds-card-title">{{ $category->name }}</h3>

                                        <p class="pa-ds-card-desc">{{ $cardDesc }}</p>

                                        <div class="pa-ds-list-head">
                                            <div class="pa-ds-list-title">Chủ đề nổi bật</div>
                                            <div class="pa-ds-list-sub">Cập nhật mới</div>
                                        </div>

                                        <ul class="pa-ds-article-list">
                                            @forelse($articles as $article)
                                                <li class="pa-ds-article-item">
                                                    <span class="pa-ds-article-dot"></span>
                                                    <a
                                                        href="{{ route('website.disease.article', ['category' => $category->id, 'article' => $article->id]) }}"
                                                        style="text-decoration:none;color:inherit;"
                                                    >
                                                        {{ $article->title }}
                                                    </a>
                                                </li>
                                            @empty
                                                <li class="pa-ds-article-item">
                                                    <span class="pa-ds-article-dot"></span>
                                                    <span>Hiện chưa có bài viết trong danh mục này</span>
                                                </li>
                                            @endforelse
                                        </ul>

                                        <div class="pa-ds-actions">
                                            <a href="{{ route('website.disease.category', ['category' => $category->id]) }}" class="pa-ds-btn pa-ds-btn--primary">
                                                <span>Tìm hiểu thêm</span>
                                                <span>›</span>
                                            </a>

                                            <a href="javascript:void(0)" class="pa-ds-btn pa-ds-btn--ghost">
                                                <span>Xem danh mục</span>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="pa-ds-empty">
                            Hiện chưa có dữ liệu danh mục bệnh cho nhóm <strong>{{ $group->label }}</strong>.
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const root = document.getElementById('pa-disease-hub');
    if (!root) return;

    const buttons = root.querySelectorAll('[data-pa-disease-type]');
    const panels = root.querySelectorAll('[data-pa-disease-panel]');

    function activatePanel(type) {
        buttons.forEach(function (button) {
            button.classList.toggle(
                'pa-ds-switch-btn--active',
                button.getAttribute('data-pa-disease-type') === String(type)
            );
        });

        panels.forEach(function (panel) {
            panel.hidden = panel.getAttribute('data-pa-disease-panel') !== String(type);
        });
    }

    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            activatePanel(this.getAttribute('data-pa-disease-type'));
        });
    });

    activatePanel({{ $defaultDiseaseType }});
});
</script>