<header class="header-section w-100">
    <div class="py-sm-6 py-3 mx-xxl-20 mx-md-15 mx-3">
        <div class="d-flex align-items-center justify-content-between gap-xxl-10 gap-lg-8 w-100">
            <nav
                class="navbar-custom d-flex gap-lg-6 align-items-center flex-column flex-lg-row justify-content-start justify-content-lg-between w-100">
                <div class="top-bar w-100 d-flex align-items-center gap-lg-0 gap-6">
                    <button class="navbar-toggle-btn d-block d-lg-none" type="button">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <a class="navbar-brand d-flex align-items-center gap-4" href="/">
                        <img class="w-100 logo1" src="/assets/img/favicon.png" alt="فاوآیکون">
                        <img class="w-100 logo2" src="/assets/img/logo.png" alt="لوگو">
                    </a>
                </div>
                <div class="navbar-toggle-item w-100 position-lg-relative">
                    <ul class="custom-nav gap-lg-7 gap-3 cursor-scale growDown2 me-xxl-10" data-lenis-prevent>
                        <li class="menu-link">
                            <a href="/">خانه</a>
                        </li>
                        <li class="menu-item">
                            <button>دسته‌بندی‌ها</button>
                            <ul class="sub-menu">
                                @foreach ($data['categories'] as $cat)
                                    <li class="menu-link">
                                        <a href="{{ route("category.products", ["id" => $cat->id]) }}">{{ $cat->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="menu-link">
                            <a href="{{ route("about_us") }}">درباره ما</a>
                        </li>
                        <li class="menu-link">
                            <a href="{{ route("faq") }}">سوالات متداول</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="header-btn-area d-flex align-items-center gap-sm-6 gap-3">
                @if (!auth()->user())
                    <a href="{{ route("login") }}"
                        class="btn-rounded-cus wallet-btn border-0 d-flex align-items-center gap-3 p-xl-2 p-0 ps-xl-6 rounded-5 position-relative">
                        <span class="btn-circle fs-2xl">
                            <i class="ti ti-user"></i>
                        </span>
                        <span  class="text-nowrap d-none d-xl-block">ثبت نام |‌ ورود</span>
                    </a>
                @else
                    <button class="ntf-btn box-style fs-2xl p-3">
                        <i class="ti ti-shopping-cart"></i>
                    </button>
                    <div class="header-profile pointer">
                        <div class="profile-wrapper d-flex align-items-center gap-3">
                            <span class="btn-circle fs-2xl">
                                <i class="ti ti-user"></i>
                            </span>
                            <span
                                class="user-name d-none d-xxl-block text-nowrap">{{ auth()->user()->name ? auth()->user()->name : auth()->user()->phone }}</span>
                            <i class="ti ti-chevron-down d-none d-xxl-block"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>

<!-- header-section end -->

<!-- notification area start -->
<div class="notification-area p-4" data-lenis-prevent>
    <div class="notification-card d-grid gap-lg-4 gap-2" data-tilt>
        @if (auth()->check())
            @foreach ($data["cart"] as $product)
                <a href="#">
                    <div class="card-item d-flex align-items-center gap-4">
                        <div class="card-img-area">
                            <img class="rounded-1 w-100" src="{{ asset('storage/'.$product->product->image) }}" width="60" alt="{{ $product->product->title }}">
                        </div>
                        <div class="card-info">
                            <small class="card-title d-block tcn-1">{{ $product->product->title }}</small>
                            <small class="card-title d-block tcn-1"> نوع :
                            @if($product->type)
                                 اختصاصی
                            @else
                                اشتراکی
                            @endif
                            </small>
                            <small class="card-text d-block tcn-1 fs-sm"> قیمت : {{ number_format($product->unit_price) }} تومان</small>
                        </div>
                    </div>
                </a>
            @endforeach
            <div><a href="{{route("cart.show")}}" class="btn btn-success btn-sm">مشاهده</a></div>
        @else
            <a href="#">
                <div class="card-item d-flex align-items-center gap-4">
                    برای دیدن سبد خرید وارد شوید
                </div>
            </a>
        @endif

    </div>
</div>
<!-- notification area end -->
@if (auth()->check())
    <div class="user-account-popup p-4">
        <div class="account-items d-grid gap-1" data-tilt>
            <div class="user-level-area p-3">
                <div class="user-info d-between">
                    <span class="user-name fs-five"> کاربر
                        {{ auth()->user()->phone ? auth()->user()->name : auth()->user()->phone }}</span>
                </div>
            </div>
            <a href="{{ route("profile") }}" class="bttn account-item">پروفایل کاربری</a>
            <a href="{{ route("logout") }}" class="bttn account-item">خروج</a>
        </div>
    </div>
@endif
