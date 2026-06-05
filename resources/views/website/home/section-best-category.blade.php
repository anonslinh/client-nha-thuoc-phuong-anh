<section class="lc-featured" aria-label="Danh mục nổi bật">
    <div class="lc-container">
        <header class="lc-section-header">
            <div class="lc-section-header-icon">🏷️</div>
            <h2 class="lc-section-header-title">Danh mục nổi bật</h2>
        </header>

        <div class="lc-featured-grid">
            @forelse($bestCategories as $category)
                <a href="{{ $category['url'] }}" class="lc-featured-card">
                    <div class="lc-featured-icon-circle">
                        @if(!empty($category['image']))
                            <img style=" border-radius: 60%; " src="{{ $category['image'] }}" alt="{{ $category['name'] }}" />
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