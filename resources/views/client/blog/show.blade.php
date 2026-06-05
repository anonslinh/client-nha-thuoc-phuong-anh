{{-- resources/views/client/blog/show.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
  @php use Illuminate\Support\Str; @endphp
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  @php
    $title = $post->seo_title ?? $post->title ?? 'Bài viết';
    $desc  = $post->meta_description
      ?? $post->excerpt
      ?? Str::limit(strip_tags($post->content ?? ''), 160);

    $canonical = $canonical ?? url()->current();
    $thumb = $post->image_url ?? $post->thumbnail_url ?? asset('assets/assetsclient/img/blog/blog-1.jpg');
    $published = $post->published_at ?? $post->created_at;
    $updated = $post->updated_at ?? $published;
    $catName = optional($post->category)->name ?? ($post->category_name ?? null);
    $author  = $post->author_name ?? '1986Hotels';
  @endphp

  <title>{{ $title }} | 1986Hotels</title>
  <meta name="description" content="{{ $desc }}">
  <link rel="canonical" href="{{ $canonical }}">

  {{-- OG / Twitter --}}
  <meta property="og:locale" content="vi_VN">
  <meta property="og:type" content="article">
  <meta property="og:title" content="{{ $title }} | 1986Hotels">
  <meta property="og:description" content="{{ $desc }}">
  <meta property="og:url" content="{{ $canonical }}">
  <meta property="og:image" content="{{ $thumb }}">
  <meta property="article:published_time" content="{{ optional($published)->toIso8601String() }}">
  <meta property="article:modified_time" content="{{ optional($updated)->toIso8601String() }}">
  @if($catName) <meta property="article:section" content="{{ $catName }}"> @endif

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $title }} | 1986Hotels">
  <meta name="twitter:description" content="{{ $desc }}">
  <meta name="twitter:image" content="{{ $thumb }}">

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

  <style>
    :root{
      --lux-gold: #c9a86a;
      --lux-ink: #0f0f10;
      --lux-soft: #f7f5f1;
      --lux-line: #ebebeb;
    }
    .lux-cover{
      background: linear-gradient(180deg, rgba(15,15,16,.88), rgba(15,15,16,.55)),
                  url("{{ $thumb }}") center/cover no-repeat;
      padding: 95px 0 70px;
      position: relative;
    }
    .lux-cover h1{
      color:#fff;
      font-family:"Lora", serif;
      letter-spacing:.4px;
      line-height: 1.2;
      margin-bottom: 12px;
      text-shadow: 0 10px 30px rgba(0,0,0,.22);
    }
    .lux-cover .lux-meta{
      color: rgba(255,255,255,.86);
      font-size: 14px;
      display:flex;
      flex-wrap:wrap;
      gap: 14px;
      align-items:center;
    }
    .lux-cover .lux-meta i{ color: var(--lux-gold); margin-right:6px; }
    .lux-breadcrumb{
      color: rgba(255,255,255,.8);
      font-size: 14px;
      margin-top: 12px;
    }
    .lux-breadcrumb a{ color: rgba(255,255,255,.92); }
    .lux-breadcrumb span.sep{ margin: 0 8px; opacity:.7; }

    .lux-article{
      background:#fff;
      border: 1px solid var(--lux-line);
      box-shadow: 0 10px 30px rgba(15,15,16,.06);
      padding: 22px;
      margin-top: -40px;
      position: relative;
      z-index: 2;
    }
    .lux-article .lead{
      font-size: 16px;
      line-height: 1.85;
      color:#4e4e4e;
      border-left: 3px solid rgba(201,168,106,.75);
      padding-left: 14px;
      margin-bottom: 18px;
    }
    .lux-content{
      color:#2a2a2a;
      font-size: 16px;
      line-height: 1.9;
    }
    .lux-content h2, .lux-content h3{
      font-family:"Lora", serif;
      margin-top: 26px;
      margin-bottom: 12px;
      color: var(--lux-ink);
    }
    .lux-content img{
      max-width: 100%;
      height: auto;
      display:block;
      margin: 18px auto;
    }
    .lux-divider{
      height: 1px;
      background: var(--lux-line);
      margin: 18px 0;
    }

    .lux-share{
      display:flex;
      flex-wrap:wrap;
      gap:10px;
      align-items:center;
    }
    .lux-pill{
      border: 1px solid var(--lux-line);
      padding: 8px 12px;
      font-size: 13px;
      color:#222;
      display:inline-flex;
      align-items:center;
      gap: 8px;
      transition: all .2s ease;
      background:#fff;
    }
    .lux-pill:hover{
      border-color: rgba(201,168,106,.7);
      color: var(--lux-gold);
    }

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
    .lux-list a{
      display:flex;
      justify-content:space-between;
      padding: 10px 0;
      border-bottom: 1px dashed #efefef;
      color:#222;
    }
    .lux-list a:last-child{ border-bottom: none; }

    /* Related */
    .lux-related .lux-thumb{
      overflow:hidden;
      background: var(--lux-soft);
    }
    .lux-related img{
      width:100%;
      height:160px;
      object-fit:cover;
      display:block;
    }
    .lux-related .title{
      font-family:"Lora", serif;
      font-size: 16px;
      line-height:1.35;
      margin: 12px 0 0;
      color: var(--lux-ink);
    }
  </style>

  {{-- JSON-LD: Breadcrumb + BlogPosting --}}
  <script type="application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[
      {"@type":"ListItem","position":1,"name":"Trang chủ","item":"{{ url('/') }}"},
      {"@type":"ListItem","position":2,"name":"Bài viết","item":"{{ route('client.blog.index') }}"},
      {"@type":"ListItem","position":3,"name":"{{ addslashes($title) }}","item":"{{ $canonical }}"}
    ]
  }
  </script>

  <script type="application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"BlogPosting",
    "headline":"{{ addslashes($title) }}",
    "description":"{{ addslashes($desc) }}",
    "image":"{{ $thumb }}",
    "author":{"@type":"Person","name":"{{ addslashes($author) }}"},
    "publisher":{"@type":"Organization","name":"1986Hotels","logo":{"@type":"ImageObject","url":"{{ asset('assets/assetsclient/img/logo.png') }}"}},
    "datePublished":"{{ optional($published)->toIso8601String() }}",
    "dateModified":"{{ optional($updated)->toIso8601String() }}",
    "mainEntityOfPage":{"@type":"WebPage","@id":"{{ $canonical }}"}
  }
  </script>
</head>

<body>
  <!-- Page Preloder -->
  <div id="preloder"><div class="loader"></div></div>

  <!-- Offcanvas Menu Section Begin -->
  <div class="offcanvas-menu-overlay"></div>
  <div class="canvas-open"><i class="icon_menu"></i></div>
  <div class="offcanvas-menu-wrapper">
    <div class="canvas-close"><i class="icon_close"></i></div>
    <div class="search-icon search-switch"><i class="icon_search"></i></div>
    <div class="header-configure-area">
      <div class="language-option">
        <img src="{{ asset('assets/assetsclient/img/logo.jpg') }}" alt="">
        <span>EN <i class="fa fa-angle-down"></i></span>
        <div class="flag-dropdown">
          <ul><li><a href="#">Zi</a></li><li><a href="#">Fr</a></li></ul>
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
                  <ul><li><a href="#">Zi</a></li><li><a href="#">Fr</a></li></ul>
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
              <div class="nav-right search-switch"><i class="icon_search"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Header End -->

  {{-- COVER --}}
  <section class="lux-cover">
    <div class="container">
      <h1>{{ $post->title }}</h1>
      <div class="lux-meta">
        <div><i class="fa fa-calendar"></i> {{ optional($published)->format('d/m/Y') }}</div>
        <div><i class="fa fa-user"></i> {{ $author }}</div>
        @if($catName)<div><i class="fa fa-folder-open"></i> {{ $catName }}</div>@endif
      </div>

      <div class="lux-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">Trang chủ</a>
        <span class="sep">/</span>
        <a href="{{ route('client.blog.index') }}">Bài viết</a>
        <span class="sep">/</span>
        <span>{{ Str::limit($post->title, 60) }}</span>
      </div>
    </div>
  </section>

  {{-- CONTENT --}}
  <section class="spad" style="padding-top:55px;">
    <div class="container">
      <div class="row">
        {{-- MAIN --}}
        <div class="col-lg-8">
          <article class="lux-article" itemscope itemtype="https://schema.org/BlogPosting">
            <meta itemprop="headline" content="{{ $title }}">
            <meta itemprop="datePublished" content="{{ optional($published)->toIso8601String() }}">
            <meta itemprop="dateModified" content="{{ optional($updated)->toIso8601String() }}">
            <meta itemprop="image" content="{{ $thumb }}">

            @if(!empty($post->excerpt))
              <p class="lead" itemprop="description">{{ $post->excerpt }}</p>
            @else
              <p class="lead" itemprop="description">{{ $desc }}</p>
            @endif

            <div class="lux-divider"></div>

            <div class="lux-content" itemprop="articleBody">
              {!! $post->content !!}
            </div>

            <div class="lux-divider"></div>

            {{-- Tags + Share --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center" style="gap:12px;">
              <div>
                @if(!empty($post->tags) && count($post->tags))
                  <span style="font-weight:600; margin-right:8px;">Thẻ:</span>
                  @foreach($post->tags as $tag)
                    <a class="lux-pill" href="{{ route('client.blog.index', ['tag' => $tag->slug ?? $tag->id]) }}">
                      <i class="fa fa-tag"></i> {{ $tag->name }}
                    </a>
                  @endforeach
                @endif
              </div>

              <div class="lux-share">
                <span style="font-weight:600;">Chia sẻ:</span>
                @php
                  $shareUrl = urlencode($canonical);
                  $shareTitle = urlencode($post->title);
                @endphp
                <a class="lux-pill" target="_blank" rel="noopener"
                   href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}">
                  <i class="fa fa-facebook"></i> Facebook
                </a>
                <a class="lux-pill" target="_blank" rel="noopener"
                   href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}">
                  <i class="fa fa-twitter"></i> Twitter
                </a>
              </div>
            </div>
          </article>

          {{-- Related posts --}}
          @if(!empty($relatedPosts) && count($relatedPosts))
            <div class="mt-4">
              <h3 style="font-family:'Lora',serif; margin-bottom:14px;">Bài viết liên quan</h3>
              <div class="row lux-related">
                @foreach($relatedPosts as $rp)
                  @php
                    $rpUrl = route('client.blog.show', $rp);
                    $rpThumb = $rp->thumbnail_url ?? $rp->image_url ?? asset('assets/assetsclient/img/blog/blog-2.jpg');
                  @endphp
                  <div class="col-md-4 mb-3">
                    <div style="border:1px solid #ebebeb; background:#fff; box-shadow:0 8px 26px rgba(15,15,16,.05); padding:12px;">
                      <a class="lux-thumb" href="{{ $rpUrl }}">
                        <img src="{{ $rpThumb }}" alt="{{ $rp->title }}" loading="lazy">
                      </a>
                      <div class="title">
                        <a href="{{ $rpUrl }}" style="color:#0f0f10;">{{ Str::limit($rp->title, 52) }}</a>
                      </div>
                      <div style="color:#888; font-size:12px; margin-top:6px;">
                        <i class="fa fa-calendar" style="color:#c9a86a;"></i>
                        {{ optional($rp->published_at ?? $rp->created_at)->format('d/m/Y') }}
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>

        {{-- SIDEBAR --}}
        <aside class="col-lg-4">
          <div class="lux-box">
            <h4>Tìm kiếm</h4>
            <form action="{{ route('client.blog.index') }}" method="GET" class="d-flex" style="gap:10px;">
              <input type="text" name="q" value="{{ request('q') }}" placeholder="Nhập từ khoá..."
                     style="flex:1; height:48px; padding:0 14px; border:1px solid #ebebeb;">
              <button type="submit" class="bk-btn" style="height:48px; line-height:48px; padding:0 16px;">Tìm</button>
            </form>
          </div>

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

          <div class="lux-box">
            <h4>Chuyên mục</h4>
            <div class="lux-list">
              @if(!empty($categories) && count($categories))
                @foreach($categories as $cat)
                  @php
                    $catKey = $cat->slug ?? $cat->id;
                    $catUrl = route('client.blog.index', ['category' => $catKey]);
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
                <a href="#"><img src="/assets/assetsclient/img/footer-logo.png" alt=""></a>
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
