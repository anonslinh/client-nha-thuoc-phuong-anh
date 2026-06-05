{{-- resources/views/client/blog/index.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
  @php use Illuminate\Support\Str; @endphp
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  {{-- SEO BASIC --}}
  <title>{{ $seoTitle ?? 'Bài viết | 1986Hotels' }}</title>
  <meta name="description" content="{{ $seoDescription ?? 'Cập nhật bài viết, kinh nghiệm du lịch, tin tức và ưu đãi mới nhất từ 1986Hotels.' }}">
  <link rel="canonical" href="{{ $canonical ?? url()->current() }}">

  {{-- Pagination SEO --}}
  @if(isset($posts) && method_exists($posts, 'previousPageUrl') && $posts->previousPageUrl())
    <link rel="prev" href="{{ $posts->previousPageUrl() }}">
  @endif
  @if(isset($posts) && method_exists($posts, 'nextPageUrl') && $posts->nextPageUrl())
    <link rel="next" href="{{ $posts->nextPageUrl() }}">
  @endif

  {{-- OG / Twitter --}}
  @php
    $ogImage = $ogImage ?? asset('assets/assetsclient/img/logo.jpg');
  @endphp
  <meta property="og:locale" content="vi_VN">
  <meta property="og:type" content="website">
  <meta property="og:title" content="{{ $seoTitle ?? 'Bài viết | 1986Hotels' }}">
  <meta property="og:description" content="{{ $seoDescription ?? 'Cập nhật bài viết, kinh nghiệm du lịch, tin tức và ưu đãi mới nhất từ 1986Hotels.' }}">
  <meta property="og:url" content="{{ $canonical ?? url()->current() }}">
  <meta property="og:image" content="{{ $ogImage }}">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $seoTitle ?? 'Bài viết | 1986Hotels' }}">
  <meta name="twitter:description" content="{{ $seoDescription ?? 'Cập nhật bài viết, kinh nghiệm du lịch, tin tức và ưu đãi mới nhất từ 1986Hotels.' }}">
  <meta name="twitter:image" content="{{ $ogImage }}">

  <!--favicon-->
  <link rel="icon" href="https://1986hotelscualo.com/assets/assetsclient/img/logo.jpg" type="image/x-icon">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet">

  <!-- Css Styles -->
  <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/bootstrap.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/font-awesome.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/elegant-icons.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/flaticon.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/owl.carousel.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/nice-select.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/jquery-ui.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/magnific-popup.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/slicknav.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/assetsclient/css/style.css') }}" type="text/css">

  {{-- Luxury tweaks --}}
  <style>
    :root{
      --lux-gold: #c9a86a;
      --lux-ink: #0f0f10;
      --lux-soft: #f7f5f1;
      --lux-line: #ebebeb;
    }
    .lux-hero{
      background: linear-gradient(180deg, rgba(15,15,16,.88), rgba(15,15,16,.55)),
                  url("/assets/assetsclient/img/hero/hero-1.jpg") center/cover no-repeat;
      padding: 90px 0;
      position: relative;
    }
    .lux-hero h1{
      color: #fff;
      font-family: "Lora", serif;
      letter-spacing: .5px;
      margin-bottom: 10px;
    }
    .lux-hero p{
      color: rgba(255,255,255,.85);
      margin: 0;
      max-width: 720px;
    }
    .lux-breadcrumb{
      color: rgba(255,255,255,.8);
      font-size: 14px;
      margin-top: 10px;
    }
    .lux-breadcrumb a{ color: rgba(255,255,255,.92); }
    .lux-breadcrumb span.sep{ margin: 0 8px; opacity: .7; }

    .lux-card{
      border: 1px solid var(--lux-line);
      background: #fff;
      box-shadow: 0 8px 26px rgba(15,15,16,.06);
      transition: all .25s ease;
      height: 100%;
    }
    .lux-card:hover{
      transform: translateY(-2px);
      box-shadow: 0 14px 36px rgba(15,15,16,.10);
    }
    .lux-thumb{
      position: relative;
      overflow: hidden;
      background: var(--lux-soft);
    }
    .lux-thumb img{
      width: 100%;
      height: 220px;
      object-fit: cover;
      transition: transform .35s ease;
      display:block;
    }
    .lux-card:hover .lux-thumb img{ transform: scale(1.03); }

    .lux-badge{
      position: absolute;
      left: 14px;
      top: 14px;
      background: rgba(15,15,16,.92);
      color: #fff;
      padding: 6px 10px;
      font-size: 12px;
      letter-spacing: .4px;
      border: 1px solid rgba(201,168,106,.45);
    }

    .lux-body{
      padding: 18px 18px 16px;
    }
    .lux-meta{
      display:flex;
      flex-wrap:wrap;
      gap:10px;
      font-size: 12px;
      color: #7a7a7a;
      margin-bottom: 8px;
    }
    .lux-meta i{ color: var(--lux-gold); margin-right: 6px; }
    .lux-title{
      font-family: "Lora", serif;
      font-size: 20px;
      line-height: 1.35;
      margin-bottom: 10px;
      color: var(--lux-ink);
    }
    .lux-title a{ color: var(--lux-ink); }
    .lux-excerpt{
      color:#5f5f5f;
      font-size: 14px;
      line-height: 1.7;
      margin-bottom: 12px;
    }
    .lux-readmore{
      display:inline-flex;
      align-items:center;
      gap:10px;
      font-weight: 600;
      color: var(--lux-gold);
      letter-spacing: .2px;
    }
    .lux-readmore i{ font-size: 16px; }

    /* Sidebar */
    .lux-box{
      border: 1px solid var(--lux-line);
      background:#fff;
      box-shadow: 0 8px 26px rgba(15,15,16,.05);
      padding: 18px;
      margin-bottom: 22px;
    }
    .lux-box h4{
      font-family:"Lora", serif;
      font-size: 18px;
      margin-bottom: 12px;
      padding-bottom: 10px;
      border-bottom: 1px solid var(--lux-line);
    }
    .lux-search{
      position: relative;
    }
    .lux-search input{
      width:100%;
      height: 48px;
      padding: 0 44px 0 14px;
      border: 1px solid var(--lux-line);
      outline: none;
    }
    .lux-search button{
      position:absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      border: none;
      background: transparent;
      color: var(--lux-gold);
      font-size: 18px;
    }
    .lux-list a{
      display:flex;
      justify-content:space-between;
      padding: 10px 0;
      border-bottom: 1px dashed #efefef;
      color:#222;
    }
    .lux-list a:last-child{ border-bottom: none; }
    .lux-tag{
      display:inline-block;
      border: 1px solid var(--lux-line);
      padding: 6px 10px;
      margin: 6px 6px 0 0;
      font-size: 12px;
      color:#333;
      transition: all .2s ease;
    }
    .lux-tag:hover{
      border-color: rgba(201,168,106,.7);
      color: var(--lux-gold);
    }

    /* Pagination */
    .pagination{ justify-content:center; }
    .page-item.active .page-link{
      background: var(--lux-ink);
      border-color: var(--lux-ink);
    }
    .page-link{ color: var(--lux-ink); }
  </style>

  {{-- JSON-LD: Website + Blog (CollectionPage) --}}
  <script type="application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"CollectionPage",
    "name":"{{ $seoTitle ?? 'Bài viết | 1986Hotels' }}",
    "description":"{{ $seoDescription ?? 'Cập nhật bài viết, kinh nghiệm du lịch, tin tức và ưu đãi mới nhất từ 1986Hotels.' }}",
    "url":"{{ $canonical ?? url()->current() }}"
  }
  </script>
</head>

<body>
  <!-- Page Preloder -->
  <div id="preloder">
    <div class="loader"></div>
  </div>

  <!-- Offcanvas Menu Section Begin -->
  <div class="offcanvas-menu-overlay"></div>
  <div class="canvas-open">
    <i class="icon_menu"></i>
  </div>
  <div class="offcanvas-menu-wrapper">
    <div class="canvas-close">
      <i class="icon_close"></i>
    </div>
    <div class="search-icon search-switch">
      <i class="icon_search"></i>
    </div>
    <div class="header-configure-area">
      <div class="language-option">
        <img src="{{ asset('assets/assetsclient/img/logo.jpg') }}" alt="">
        <span>EN <i class="fa fa-angle-down"></i></span>
        <div class="flag-dropdown">
          <ul>
            <li><a href="#">Zi</a></li>
            <li><a href="#">Fr</a></li>
          </ul>
        </div>
      </div>
      <a href="{{ route('client.rooms.index') }}#bookingBox" class="bk-btn">Đặt phòng</a>
    </div>
    <nav class="mainmenu mobile-menu">
      <ul>
        <li><a href="{{ url('/') }}">Trang chủ</a></li>
        <li><a href="{{ route('client.rooms.index') }}">Phòng</a></li>
        <li><a href="#">Giới thiệu</a></li>
        <li class="active"><a href="{{ route('client.blog.index') }}">Bài viết</a></li>
        <li><a href="#">Liên hệ</a></li>
      </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="top-social">
      <a href="#"><i class="fa fa-facebook"></i></a>
      <a href="#"><i class="fa fa-instagram"></i></a>
    </div>
    <ul class="top-widget">
      <li><i class="fa fa-phone"></i> 0339662172</li>
      <li><i class="fa fa-envelope"></i> 1986hotel@gmail.com</li>
    </ul>
  </div>
  <!-- Offcanvas Menu Section End -->

  <!-- Header Section Begin -->
  <header class="header-section header-normal">
    <div class="top-nav">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <ul class="tn-left">
              <li><i class="fa fa-phone"></i>0339662172</li>
              <li><i class="fa fa-envelope"></i> 1986hotel@gmail.com</li>
            </ul>
          </div>
          <div class="col-lg-6">
            <div class="tn-right">
              <div class="top-social">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
              </div>
              <a href="{{ route('client.rooms.index') }}#bookingBox" class="bk-btn">Đặt Phòng Ngay</a>
              <div class="language-option">
                <img src="{{ asset('assets/assetsclient/img/flag.jpg') }}" alt="">
                <span>EN <i class="fa fa-angle-down"></i></span>
                <div class="flag-dropdown">
                  <ul>
                    <li><a href="#">Zi</a></li>
                    <li><a href="#">Fr</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="menu-item">
      <div class="container">
        <div class="row">
          <div class="col-lg-2">
            <div class="logo">
              <a href="{{ url('/') }}">
                <img src="{{ asset('assets/assetsclient/img/logo.png') }}" alt="1986Hotels">
              </a>
            </div>
          </div>
          <div class="col-lg-10">
            <div class="nav-menu">
              <nav class="mainmenu">
                <ul>
                  <li><a href="{{ url('/') }}">Trang chủ</a></li>
                  <li><a href="{{ route('client.rooms.index') }}">Phòng</a></li>
                  <li><a href="#">Giới thiệu</a></li>
                  <li class="active"><a href="{{ route('client.blog.index') }}">Bài viết</a></li>
                  <li><a href="#">Liên hệ</a></li>
                </ul>
              </nav>
              <div class="nav-right search-switch">
                <i class="icon_search"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Header End -->

  {{-- HERO --}}
  <section class="lux-hero">
    <div class="container">
      <h1>Bài viết</h1>
      <p>Gợi ý trải nghiệm, tin tức & ưu đãi giúp chuyến đi của bạn tinh tế hơn.</p>
      <div class="lux-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">Trang chủ</a>
        <span class="sep">/</span>
        <span>Bài viết</span>
      </div>
    </div>
  </section>

  {{-- CONTENT --}}
  <section class="spad" style="padding-top:55px;">
    <div class="container">
      <div class="row">
        {{-- MAIN --}}
        <div class="col-lg-8">
          <div class="row">
            @forelse(($posts ?? []) as $post)
              @php
                // ✅ route-model-binding: /bai-viet/{post:slug}
                $postUrl = route('client.blog.show', $post);

                $thumb = $post->thumbnail_url ?? $post->image_url ?? '/assets/assetsclient/img/blog/blog-1.jpg';
                $catName = optional($post->category)->name ?? ($post->category_name ?? 'Travel');
                $published = $post->published_at ?? $post->created_at;
                $excerpt = $post->excerpt ?? Str::limit(strip_tags($post->content ?? ''), 160);
              @endphp

              <div class="col-md-6 mb-4">
                <article class="lux-card">
                  <a class="lux-thumb" href="{{ $postUrl }}" aria-label="{{ $post->title }}">
                    <span class="lux-badge">{{ $catName }}</span>
                    <img src="{{ $thumb }}" alt="{{ $post->title }}" loading="lazy">
                  </a>
                  <div class="lux-body">
                    <div class="lux-meta">
                      <div><i class="fa fa-calendar"></i> {{ optional($published)->format('d/m/Y') }}</div>
                      @if(!empty($post->author_name))
                        <div><i class="fa fa-user"></i> {{ $post->author_name }}</div>
                      @endif
                    </div>
                    <h2 class="lux-title">
                      <a href="{{ $postUrl }}">{{ $post->title }}</a>
                    </h2>
                    <p class="lux-excerpt">{{ $excerpt }}</p>
                    <a class="lux-readmore" href="{{ $postUrl }}">
                      Xem chi tiết <i class="fa fa-long-arrow-right"></i>
                    </a>
                  </div>
                </article>
              </div>
            @empty
              <div class="col-12">
                <div class="alert alert-info">Chưa có bài viết nào.</div>
              </div>
            @endforelse
          </div>

          {{-- Pagination --}}
          @if(isset($posts) && method_exists($posts, 'links'))
            <div class="mt-4">
              {{ $posts->links('pagination::bootstrap-4') }}
            </div>
          @endif
        </div>

        {{-- SIDEBAR --}}
        <aside class="col-lg-4">
          {{-- Search --}}
          <div class="lux-box">
            <h4>Tìm kiếm</h4>
            <form class="lux-search" action="{{ route('client.blog.index') }}" method="GET" role="search">
              <input type="text" name="q" value="{{ request('q') }}" placeholder="Nhập từ khoá...">
              <button type="submit" aria-label="Search"><i class="fa fa-search"></i></button>
            </form>
          </div>

          {{-- Categories --}}
          <div class="lux-box">
            <h4>Chuyên mục</h4>
            <div class="lux-list">
              @if(!empty($categories) && count($categories))
                @foreach($categories as $cat)
                  @php
                    $catKey = $cat->slug ?? $cat->id;
                    $catUrl = route('client.blog.index', array_filter(['category' => $catKey, 'q' => request('q')]));
                    $count = $cat->posts_count ?? null;
                  @endphp
                  <a href="{{ $catUrl }}">
                    <span>{{ $cat->name }}</span>
                    @if(!is_null($count)) <span>({{ $count }})</span> @endif
                  </a>
                @endforeach
              @else
                <div style="color:#777;">Chưa có chuyên mục.</div>
              @endif
            </div>
          </div>

          {{-- Recent --}}
          <div class="lux-box">
            <h4>Bài mới</h4>
            <div class="lux-list">
              @if(!empty($recentPosts) && count($recentPosts))
                @foreach($recentPosts as $rp)
                  @php $rpUrl = route('client.blog.show', $rp); @endphp
                  <a href="{{ $rpUrl }}">
                    <span>{{ Str::limit($rp->title, 44) }}</span>
                    <span style="color:#999;">{{ optional($rp->published_at ?? $rp->created_at)->format('d/m') }}</span>
                  </a>
                @endforeach
              @else
                <div style="color:#777;">Chưa có bài mới.</div>
              @endif
            </div>
          </div>

          {{-- Tags --}}
          <div class="lux-box">
            <h4>Thẻ</h4>
            @if(!empty($tags) && count($tags))
              @foreach($tags as $tag)
                @php
                  $tagKey = $tag->slug ?? $tag->id;
                  $tagUrl = route('client.blog.index', array_filter(['tag' => $tagKey, 'q' => request('q')]));
                @endphp
                <a class="lux-tag" href="{{ $tagUrl }}">{{ $tag->name }}</a>
              @endforeach
            @else
              <div style="color:#777;">Chưa có thẻ.</div>
            @endif
          </div>
        </aside>
      </div>
    </div>
  </section>

  <!-- Footer Section Begin -->
  <footer class="footer-section">
    <div class="container">
      <div class="footer-text">
        <div class="row">
          <div class="col-lg-4">
            <div class="ft-about">
              <div class="logo">
                <a href="#">
                  <img src="/assets/assetsclient/img/footer-logo.png" alt="">
                </a>
              </div>
              <p>We inspire and reach millions of travelers<br /> across 90 local websites</p>
              <div class="fa-social">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-tripadvisor"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-youtube-play"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 offset-lg-1">
            <div class="ft-contact">
              <h6>Contact Us</h6>
              <ul>
                <li>(12) 345 67890</li>
                <li>info.colorlib@gmail.com</li>
                <li>856 Cordia Extension Apt. 356, Lake, United State</li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 offset-lg-1">
            <div class="ft-newslatter">
              <h6>New latest</h6>
              <p>Get the latest updates and offers.</p>
              <form action="#" class="fn-form">
                <input type="text" placeholder="Email">
                <button type="submit"><i class="fa fa-send"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright-option">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <ul>
              <li><a href="#">Contact</a></li>
              <li><a href="#">Terms of use</a></li>
              <li><a href="#">Privacy</a></li>
              <li><a href="#">Environmental Policy</a></li>
            </ul>
          </div>
          <div class="col-lg-5">
            <div class="co-text"><p>
              Copyright &copy;<script>document.write(new Date().getFullYear());</script>
              All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by
              <a href="https://colorlib.com" target="_blank">Colorlib</a>
            </p></div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer Section End -->

  <!-- Search model Begin -->
  <div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
      <div class="search-close-switch"><i class="icon_close"></i></div>
      <form class="search-model-form" action="{{ route('client.blog.index') }}" method="GET">
        <input type="text" name="q" id="search-input" placeholder="Search here.....">
      </form>
    </div>
  </div>
  <!-- Search model end -->

  <!-- Js Plugins -->
  <script src="/assets/assetsclient/js/jquery-3.3.1.min.js"></script>
  <script src="/assets/assetsclient/js/bootstrap.min.js"></script>
  <script src="/assets/assetsclient/js/jquery.magnific-popup.min.js"></script>
  <script src="/assets/assetsclient/js/jquery.nice-select.min.js"></script>
  <script src="/assets/assetsclient/js/jquery-ui.min.js"></script>
  <script src="/assets/assetsclient/js/jquery.slicknav.js"></script>
  <script src="/assets/assetsclient/js/owl.carousel.min.js"></script>
  <script src="/assets/assetsclient/js/main.js"></script>
</body>
</html>
