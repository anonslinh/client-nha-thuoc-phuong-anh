<style>
    .lc-featured--balanced .lc-featured-grid {
        grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
        gap: 18px !important;
    }

    .lc-featured--balanced .lc-featured-card {
        min-height: 180px !important;
        padding: 22px 14px 18px !important;
        justify-content: center !important;
        gap: 8px !important;
        text-decoration: none !important;
    }

    .lc-featured--balanced .lc-featured-icon-circle {
        width: 72px !important;
        height: 72px !important;
        margin: 0 auto 8px !important;
        border-radius: 22px !important;
        background: linear-gradient(180deg, #ffffff 0%, #eefbf7 100%) !important;
        border: 1px solid rgba(15, 139, 124, .12) !important;
        box-shadow: 0 12px 28px rgba(15, 139, 124, .10) !important;
    }

    .lc-featured--balanced .lc-featured-card:hover .lc-featured-icon-circle {
        border-color: rgba(24, 183, 179, .32) !important;
        box-shadow: 0 16px 34px rgba(15, 139, 124, .16) !important;
    }

    .lc-featured--balanced .lc-featured-icon-circle img {
        width: 50px !important;
        height: 50px !important;
        border-radius: 16px !important;
        object-fit: contain !important;
        display: block !important;
    }

    .lc-featured--balanced .lc-featured-icon-fallback {
        font-size: 30px !important;
        line-height: 1 !important;
    }

    .lc-featured--balanced .lc-featured-name {
        min-height: 38px !important;
        margin: 0 !important;
        color: #071827 !important;
        font-size: 14px !important;
        font-weight: 800 !important;
        line-height: 1.35 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .lc-featured--balanced .lc-featured-count {
        margin-top: 0 !important;
        color: #607083 !important;
        font-size: 12px !important;
        line-height: 1.35 !important;
    }

    @media (max-width: 1199px) {
        .lc-featured--balanced .lc-featured-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }
    }

    @media (max-width: 767px) {
        .lc-featured--balanced {
            padding-top: 14px !important;
            padding-bottom: 14px !important;
        }

        .lc-featured--balanced .lc-section-header {
            margin-bottom: 10px !important;
        }

        .lc-featured--balanced .lc-featured-grid {
            display: flex !important;
            grid-template-columns: none !important;
            gap: 10px !important;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            padding: 2px 2px 10px !important;
            scroll-snap-type: x proximity;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .lc-featured--balanced .lc-featured-grid::-webkit-scrollbar {
            display: none;
        }

        .lc-featured--balanced .lc-featured-card {
            flex: 0 0 82px !important;
            width: 82px !important;
            min-width: 82px !important;
            min-height: 96px !important;
            padding: 10px 6px 9px !important;
            border-radius: 16px !important;
            scroll-snap-align: start;
            box-shadow: 0 8px 20px rgba(9,47,48,.06) !important;
        }

        .lc-featured--balanced .lc-featured-icon-circle {
            width: 48px !important;
            height: 48px !important;
            border-radius: 15px !important;
            margin-bottom: 7px !important;
        }

        .lc-featured--balanced .lc-featured-icon-circle img {
            width: 34px !important;
            height: 34px !important;
            border-radius: 10px !important;
        }

        .lc-featured--balanced .lc-featured-name {
            min-height: 28px !important;
            font-size: 10px !important;
            line-height: 1.22 !important;
            font-weight: 850 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .lc-featured--balanced .lc-featured-count {
            display: none !important;
        }
    }
</style>

<section class="lc-featured lc-featured--balanced" aria-label="Danh mục nổi bật">
    <div class="lc-container">
        <header class="lc-section-header">
            <div class="lc-section-header-icon">🏷️</div>
            <h2 class="lc-section-header-title">Danh mục thuốc</h2>
        </header>

        <div class="lc-featured-grid">
            @forelse($bestCategories as $category)
                <a href="{{ $category['url'] }}" class="lc-featured-card">
                    <div class="lc-featured-icon-circle">
                        @if(!empty($category['image']))
                            <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" />
                        @else
                            <span class="lc-featured-icon-fallback">🏷️</span>
                        @endif
                    </div>

                    <div class="lc-featured-name">
                        {{ $category['name'] }}
                    </div>

                    <div class="lc-featured-count">
                        {{ number_format($category['product_count'], 0, ',', '.') }} sản phẩm
                    </div>
                </a>
            @empty
                <div class="lc-featured-empty">
                    Đang cập nhật danh mục nổi bật.
                </div>
            @endforelse
        </div>
    </div>
</section>
