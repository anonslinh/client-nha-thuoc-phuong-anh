@extends('website.layout.index')

@section('content')
    <section class="lc-search-page">
        <div class="lc-container">
            <div class="lc-search-page-head">
                <h1 class="lc-search-page-title">Kết quả tìm kiếm</h1>
                @if(!empty($keywordTitle))
                    <p class="lc-search-page-sub">
                        Từ khóa: <strong>{{ $keywordTitle }}</strong>
                    </p>
                @endif
            </div>

            <div class="lc-search-result-block">
                <h2 class="lc-search-result-heading">Sản phẩm tìm thấy</h2>

                @if(!empty($searchProducts) && count($searchProducts) > 0)
                    <div class="lc-search-result-grid">
                        @foreach($searchProducts as $product)
                            <article class="lc-product-card--flash">
                                <div class="lc-product-image-wrap">
                                    <img src="{{ $product->thumbnail ?? asset('images/no-image.png') }}"
                                        alt="{{ $product->name }}">
                                </div>

                                <h3 class="lc-product-name">{{ $product->name }}</h3>

                                <div class="lc-product-price-row">
                                    <div class="lc-product-price-sale">
                                        {{ number_format((float)($product->sale_price ?? 0), 0, ',', '.') }}đ
                                    </div>

                                    @if(!empty($product->base_price))
                                        <div class="lc-product-price-original">
                                            {{ number_format((float)$product->base_price, 0, ',', '.') }}đ
                                        </div>
                                    @endif
                                </div>

                                <button class="lc-product-btn-buy" type="button">Chọn mua</button>
                            </article>
                        @endforeach
                    </div>

                    <div class="lc-search-pagination">
                        {{ $searchProducts->links() }}
                    </div>
                @else
                    <div class="lc-search-empty">Không tìm thấy sản phẩm phù hợp.</div>
                @endif
            </div>
        </div>
    </section>
@endsection