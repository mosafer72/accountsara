@extends("Pages.layouts.master")

@section("content")
  <!-- Hero Section start  -->
  <section class="hero-section pt-20 pb-120 position-relative">
    <div class="gradient-bg"></div>
    <div class="gradient-bg2"></div>
    <div class="star-area">
      <div class="big-star">
        <img class="w-100" src="./assets/img/big-star.png" alt="ستاره">
      </div>
      <div class="small-star">
        <img class="w-100" src="./assets/img/small-star.png" alt="ستاره">
      </div>
    </div>
    <div class="rotate-award">
      <img class="w-100" src="./assets/img/award.png" alt="جایزه">
    </div>
    <div class="container pt-120 pb-15">
      <div class="row g-6 justify-content-between">
        <div class="col-lg-5 col-md-6 col-sm-8 mt-0 mt-md-2">
          <div class="hero-content">
            <ul class="d-flex gap-3 fs-2xl fw-semibold heading-font mb-5 list-icon title-anim">
              <li>شماره مجازی</li>
              <li>اکانت هوش مصنویی</li>
            </ul>
            <h1 class="hero-title display-one tcn-1 cursor-scale growUp mb-10">
              بهترین ها
              <span class="d-block tcp-1"> را با ما</span>
               تجربه کنید
            </h1>
          </div>
        </div>
        <div class="col-xl-3 col-md-2 col-4 order-md-last order-lg-1">
          <div class="hero-banner-area">
            <div class="hero-banner-bg">
              <img class="w-100" src="./assets/img/bg-1.png" alt="بنر">
            </div>
            <div class="hero-banner-img">
              <img class="w-100 hero" src="./assets/img/hero.png" alt="بنر">
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-5 col-md-6 order-md-1 order-lg-last">
          <div class="hero-content">
            <div class="card-area py-lg-8 py-6 px-lg-6 px-3 rounded-5 tilt mb-10" data-tilt>
              <h3 class="tcn-1 dot-icon cursor-scale growDown mb-6 title-anim">جدیدترین محصولات</h3>
              <div class="hr-line mb-6"></div>
              <div class="card-items d-grid gap-5">
                @foreach ($last_products as $product)
                  <div class="card-item d-flex align-items-center gap-4">
                    <div class="card-img-area rounded-circle overflow-hidden">
                      <img  class="w-100" src="{{ asset('storage/'.$product->image) }}" width="60" alt="{{ $product->title }}">
                    </div>
                    <div class="card-info">
                      <h4 class="card-title fw-semibold tcn-1 mb-1 cursor-scale growDown2 title-anim">{{ $product->title }}
                      </h4>
                      <p class="card-text tcs-1 fw-medium">{{ number_format($product->price * intval(setting("doller_price"))) }} تومان</p>
                    </div>
                  </div>
                  <div class="hr-line"></div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="grid-lines overflow-hidden">
      <div class="lines">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>
      <div class="lines">
        <div class="line-vertical"></div>
        <div class="line-vertical"></div>
        <div class="line-vertical"></div>
        <div class="line-vertical"></div>
        <div class="line-vertical"></div>
        <div class="line-vertical"></div>
        <div class="line-vertical"></div>
        <div class="line-vertical"></div>
        <div class="line-vertical"></div>
        <div class="line-vertical"></div>
      </div>
    </div>
  </section>
  <!-- Hero Section end  -->

  <!-- 3D swiper section start-->
  <section class="swiper-3d-section position-relative z-1" id="swiper-3d">
    <div class="container">
      <!-- Slider main container -->
      <div class="swiper swiper-3d-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
          <!-- Slides -->
          @foreach ($sliders as $slider)
            <div class="swiper-slide">
              <div class="card-3d d-grid justify-content-center p-3">
                <div class="img-area w-100 mb-8 position-relative">
                  <!-- <span
                          class="card-date position-absolute top-0 start-0 py-2 px-3 mt-4 ms-5 tcn-1 d-flex align-items-center gap-1 fs-sm">
                          <i class="ti ti-calendar-due"></i> 15.02.2022</span> -->
                  <img class="w-100" src="{{ asset('storage/'.$slider->image) }}" width="60" alt="{{ $slider->title }}">
                  <span class="card-status position-absolute end-0 py-2 px-6 tcn-1 fs-sm">
                    <a href="{{ route("product.show_more", ["id" => $slider->id]) }}"
                      class="dot-icon alt-icon pe-3">مشاهده</a>
                  </span>
                </div>
                <h5 class="card-title text-center tcn-1 mb-4 title-anim">{{ $slider->title }}</h5>
                <div class="d-center">
                  <div class="card-info d-center gap-3 py-1 px-3">
                    <div class="d-flex align-items-center gap-2">
                      <img class="" style="width:30px;height:30px" src="assets/img/tether.png" alt="تتر">
                      <span class="tcn-1 fs-xs">{{ number_format($slider->price * intval(setting("doller_price"))) }} تومان </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="swiper-btn-area d-center gap-6">
          <div class="swiper-btn swiper-3d-button-next box-style">
            <i class="ti ti-chevron-right fs-xl"></i>
          </div>
          <div class="swiper-btn swiper-3d-button-prev box-style">
            <i class="ti ti-chevron-left fs-xl"></i>
          </div>
        </div>
      </div>
  </section>
  <!-- 3D swiper section end-->
<section class="teams-card-section pb-120">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-lg-15 mb-10">
                    <h2 class="display-four tcn-1 cursor-scale growUp title-anim">میانبرها</h2>
                </div>
            </div>
            <!-- teams card  -->
            <div class="row g-6 justify-content-md-start justify-content-center mb-lg-15 mb-10">
                @foreach ($shortcuts as $shortcut)
                      <div class="col-xl-4 col-md-6">
                        <div class="team-card gap-6 p-xxl-8 p-4 bgn-4 box-style alt-box" data-tilt="" style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1); --x: 19px; --y: 0px;">
                            <div class="team-thumb">
                                <img class="w-100 rounded-circle" src="{{ asset('storage/'.$shortcut->image) }}" alt="تیم">
                            </div>
                            <div class="team-info w-100">
                                <div class="title-area d-flex gap-5 align-items-end mb-5">
                                    <a href="teams-details.html">
                                        <h4 class="tcn-1 cursor-scale growDown title-anim">{{ $shortcut->title }}</h4>
                                    </a>
                                </div>
                                <div class="player-info d-flex gap-6 align-items-center mb-6">
                                    <div class="d-flex gap-3 align-items-center">
                                        <i class="ti ti-users fs-2xl"></i>
                                        <span class="tcn-6">3 بازیکن</span>
                                    </div>
                                    <div class="d-flex gap-3 align-items-center">
                                        <i class="ti ti-world fs-2xl"></i>
                                        <span class="tcn-6">انگلیسی</span>
                                    </div>
                                </div>
                                <div class="d-between justify-content-center justify-content-xl-between flex-wrap w-100 gap-xxl-6 gap-3">
                                    <ul class="player-lists d-flex align-items-center">
                                        <li class="rounded-circle overflow-hidden me-n4">
                                            <img src="assets/img/player1.png" alt="بازیکن">
                                        </li>
                                        <li class="rounded-circle overflow-hidden me-n4">
                                            <img src="assets/img/player2.png" alt="بازیکن">
                                        </li>
                                        <li class="rounded-circle overflow-hidden me-n4">
                                            <img src="assets/img/player3.png" alt="بازیکن">
                                        </li>
                                        <li class="rounded-circle overflow-hidden me-n4">
                                            <img src="assets/img/player4.png" alt="بازیکن">
                                        </li>
                                        <li class="rounded-circle overflow-hidden heading-font fs-base">
                                            99+
                                        </li>
                                    </ul>
                                    <a href="teams-details.html" class="btn-half-border position-relative d-inline-block py-2 px-6 rounded-pill z-2">درخواست
                                        عضویت</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-center">
                <button class="btn-half-border position-relative d-inline-block py-2 bgp-1 px-6 rounded-pill z-2 border-0">بیشتر
                    ببینید</button>
            </div>
        </div>
    </section>
  <!-- tournament section start -->
  <section class="tournament-section pb-120" id="tournament-hero">
    <!-- Diamond animation -->
    <div class="diamond-area">
      <img class="w-100" src="assets/img/diamond.png" alt="الماس">
    </div>
    <!-- game console animation -->
    <div class="game-console-area">
      <img class="w-100" src="assets/img/game-console2.png" alt="دسته-عکس اکانت">
    </div>
    <div class="red-ball top-50"></div>
    <div class="tournament-wrapper">
      <div class="tournament-wrapper-border">
        <div class="container pt-120 pb-120">
          <div class="row justify-content-between align-items-center gy-sm-0 gy-4 mb-15">
            <div class="col-md-6 col-sm-8">
              <h2 class="display-four tcn-1 cursor-scale growUp title-anim">محبوب ترین‌ها</h2>
            </div>
            <div class="col-md-6 col-sm-4 text-sm-start">
              <a href="tournaments.html"
                class="btn-half-border position-relative d-inline-block py-2 px-6 bgp-1 rounded-pill">بیشتر
                ببینید</a>
            </div>
          </div>
          <div class="row justify-content-between align-items-center g-6">
            @foreach ($most_sell as $row)
              <div class="col-xl-4 col-md-6">
                <div class="tournament-card p-xl-4 p-3 bgn-4">
                  <div class="tournament-img mb-8 position-relative">
                    <div class="img-area overflow-hidden">
                      <img class="w-100" src="{{ asset('storage/'.$row->image) }}" width="60" alt="{{ $row->title }}">
                    </div>
                    <span class="card-status position-absolute end-0 py-2 px-6 tcn-1 fs-sm">
                      <a href="{{ route("product.show_more", ["id" => $row->id]) }}" class="dot-icon alt-icon pe-3">مشاهده</a>
                    </span>
                  </div>
                  <div class="tournament-content px-xl-4 px-sm-2">
                    <div class="tournament-info mb-5">
                      <a href="tournaments-details.html" class="d-block">
                        <h4 class="tournament-title tcn-1 mb-1 cursor-scale growDown title-anim">{{ $row->title }}</h4>
                      </a>
                      <span class="tcn-6 fs-sm">{{ $product->category->name }}</span>
                    </div>
                    <div class="hr-line line3"></div>
                    <div class="card-info d-flex align-items-center gap-3 flex-wrap my-5">
                      <div class="price-money bgn-3 d-flex align-items-center gap-3 py-2 px-3 h-100">
                        <div class="d-flex align-items-center gap-2">
                          <img class="" style="width:50px" src="assets/img/tether.png" alt="تتر">
                          <span class="tcn-1 fs-sm">{{ number_format($product->price * intval(setting("doller_price"))) }}</span>
                        </div>
                      </div>
                      <div class="ticket-fee bgn-3 d-flex align-items-center gap-1 py-2 px-3 h-100">
                        <i class="ti ti-ticket fs-base tcp-2"></i>
                        <span class="tcn-1 fs-sm">{{ $product->sell_count }}</span>
                      </div>
                    </div>
                    <div class="hr-line line3"></div>
                    <div class="card-more-info d-between mt-6">
                      <div class="teams-info d-between gap-xl-5 gap-3">
                        <div class="player d-flex align-items-center gap-1">
                          <i class="ti ti-user fs-base"></i>
                          <span class="tcn-6 fs-sm">{{ $product->sell_count }} خریدار </span>
                        </div>
                      </div>
                      <a href="{{ route("product.show_more", ["id" => $row->id]) }}"  class="btn2">
                        <i class="ti ti-arrow-left fs-2xl"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- tournament section end -->

  <!-- game section start  -->
  <section class="game-section">
    <div class="red-ball bottom-0 end-0"></div>
    <div class="container">
      <div class="row justify-content-between align-items-center mb-15">
        <div class="col-6">
          <h2 class="display-four tcn-1 cursor-scale growUp title-anim">محصولات دیگر</h2>
        </div>
        <div class="col-6 text-start">
          <a href="game.html" class="btn-half-border position-relative d-inline-block py-2 px-6 bgp-1 rounded-pill">بیشتر
            ببینید</a>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="swiper game-swiper">
            <div class="swiper-wrapper mb-lg-15 mb-10">

              @foreach ($low_sell as $pro)
                <div class="swiper-slide">
                  <div class="game-card-wrapper mx-auto">
                    <div class="game-card mb-5 p-2">
                      <div class="game-card-border"></div>
                      <div class="game-card-border-overlay"></div>
                      <div class="game-img alt">
                        <img  class="w-100" src="{{ asset('storage/'.$pro->image) }}" width="60" alt="{{ $pro->title }}">
                      </div>
                      <div class="game-link d-center">
                        <a href="{{ route("product.show_more", ["id" => $pro->id]) }}" class="btn2">
                          <i class="ti ti-arrow-left fs-2xl"></i>
                        </a>
                      </div>
                    </div>
                    <a href="game.html">
                      <h3 class="game-title mb-0 tcn-1 cursor-scale growDown2">{{ $pro->category->name }}</h3>
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="text-center d-center">
              <div class="game-swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- game section end  -->

  <!-- next level gaming section start -->
  <section class="next-level-gaming-section pt-120 pb-120" id="next-level-gaming">
    <div class="red-ball bottom-50"></div>
    <div class="container">
      <div class="row justify-content-between mb-15">
        <div class="col-lg-6 col-sm-10">
          <h2 class="display-four tcn-1 cursor-scale growUp title-anim">عکس اکانت کردن به سبک نوین</h2>
        </div>
      </div>
      <div class="row g-6">

        <div class="col-lg-4 col-md-6">
          <div class="next-level-game-card d-grid gap-5 py-lg-10 py-sm-6 py-4 px-xl-9 px-sm-5 px-3">
            <div class="card-icon">
              <i class="ti ti-12-hours fs-2xl tcn-1"></i>
            </div>
            <h4 class="card-title tcn-1 cursor-scale growDown2 title-anim">تحویل آنی فوری</h4>
            <p class="card-text tcs-6">تمام اکانت‌ها و شماره‌های مجازی بلافاصله بعد از پرداخت فعال و تحویل داده می‌شوند.
            </p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="next-level-game-card d-grid gap-5 py-lg-10 py-sm-6 py-4 px-xl-9 px-sm-5 px-3">
            <div class="card-icon">
              <i class="ti ti-tools fs-2xl tcn-1"></i>
            </div>
            <h4 class="card-title tcn-1 cursor-scale growDown2 title-anim">پشتیبانی ۲۴ ساعته</h4>
            <p class="card-text tcs-6">در هر ساعت شبانه‌روز پاسخگو هستیم و مشکلات شما را سریع حل می‌کنیم.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="next-level-game-card d-grid gap-5 py-lg-10 py-sm-6 py-4 px-xl-9 px-sm-5 px-3">
            <div class="card-icon">
              <i class="ti ti-coins fs-2xl tcn-1"></i>
            </div>
            <h4 class="card-title tcn-1 cursor-scale growDown2 title-anim">قیمت منصفانه دائم</h4>
            <p class="card-text tcs-6">قیمت‌ها بدون افزایش و نرخ واقعی و ثابت به شما ارائه می‌شود.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="next-level-game-card d-grid gap-5 py-lg-10 py-sm-6 py-4 px-xl-9 px-sm-5 px-3">
            <div class="card-icon">
              <i class="ti ti-free-rights fs-2xl tcn-1"></i>
            </div>
            <h4 class="card-title tcn-1 cursor-scale growDown2 title-anim">کیفیت تضمینی کامل</h4>
            <p class="card-text tcs-6">تمام اکانت‌ها سالم، معتبر، تست‌شده و بدون ریزش یا بلاک شدن ارائه می‌شوند.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="next-level-game-card d-grid gap-5 py-lg-10 py-sm-6 py-4 px-xl-9 px-sm-5 px-3">
            <div class="card-icon">
              <i class="ti ti-scale fs-2xl tcn-1"></i>
            </div>
            <h4 class="card-title tcn-1 cursor-scale growDown2 title-anim">تنوع سرویس بالا</h4>
            <p class="card-text tcs-6">ده‌ها نوع شماره و اکانت از کشورهای مختلف برای نیازهای مختلف شما فراهم شده است.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="next-level-game-card d-grid gap-5 py-lg-10 py-sm-6 py-4 px-xl-9 px-sm-5 px-3">
            <div class="card-icon">
              <i class="ti ti-license fs-2xl tcn-1"></i>
            </div>
            <h4 class="card-title tcn-1 cursor-scale growDown2 title-anim">امنیت و محرمانگی</h4>
            <p class="card-text tcs-6">اطلاعات کاربران رمزگذاری شده و هیچ‌وقت ذخیره، منتشر یا فروخته نمی‌شود.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- next level gaming section end -->

  <!-- call to action section start -->
  <div class="call-to-action pt-120 pb-120 bgn-4 overflow-x-hidden" id="cta">
    <div class="container">
      <div class="row justify-content-between g-6">
        <div class="col-lg-6">
          <span class="display-three tcn-1 cursor-scale growUp mb-8 d-block title-anim">بروز باشید</span>
          <span class="fs-lg tcn-6">سوال یا بازخوردی دارید؟ ما از اینکه با شما در ارتباط باشیم خوشحال میشویم. با
            .تیم ما تماس بگیرید یا از پلتفرم ما استفاده کنید</span>
        </div>
        <div class="col-xl-5 col-lg-6">
          <form action="#">
            <div class="single-input mb-6">
              <input type="email" placeholder="ایمیل خود را وارد کنید">
            </div>
            <div
              class="d-flex align-items-md-center align-items-start justify-content-between gap-lg-8 gap-6 flex-md-row flex-column">
              <div class="d-flex align-items-center gap-lg-4 gap-2">
                <label class="custom-checkbox">
                  <input type="checkbox">
                  <span class="checkmark"></span>
                </label>
                <span class="fs-base tcn-6">من <a href="#" class="tcp-1">
                    حریم خصوصی و خط مشی</a>
                  و <a href="terms-condition.html" class="tcp-1">شرایط و ضوابط</a>
                  را قبول میکنم.
                </span>
              </div>
              <button type="submit" class="bttn py-sm-4 py-3 px-lg-10 px-sm-8 px-6 bgp-1 tcn-1 rounded-4">تایید</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
