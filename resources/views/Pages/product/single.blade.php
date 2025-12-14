@extends("Pages.layouts.master")
@section('title')
    خرید {{ $product->title }} | تحویل فوری – Accountsara
@endsection

@section('meta_description')
    خرید {{ $product->title }} با تحویل فوری، گارانتی فعال و پشتیبانی ۲۴ ساعته از Accountsara.
@endsection

@section("content")
    
    <section class="team-profile-banner pb-120 mt-lg-0 mt-sm-15">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12">
                    <a href="javascript:void(0)" onclick="window.history.back()" class="back-btn"><i
                            class="ti ti-arrow-narrow-right fs-2xl"></i></a>
                </div>
            </div>
            <div class="row">
                @if(session('success'))
                    <div class="alert alert-success m-2 p-2">{{ session('success') }}</div>
                @endif
                @if ($errors->any())

                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="col-12 mb-lg-20 mb-15 pb-lg-10 pb-6">
                    <div class="parallax-banner-area parallax-container">
                        <div class="parallax-img team-banner position-relative"
                            style="translate: none; rotate: none; scale: none; transform: translate(0%, 17.3274%) translate3d(0px, 0px, 0px);">
                            <img class="w-100 h-100 tbi rounded-5" src="/assets/img/team-x.png" alt="بنر مسابقات">
                            <div class="team-profile d-between position-absolute z-1 w-100 px-lg-15 px-md-10 px-sm-6 px-4">
                                <div class="d-flex align-items-center gap-sm-6 gap-3">
                                    <div class="team-thumb">
                                        <img class="w-100 h-100 alt rounded-circle"  src="{{ asset('storage/'.$product->image) }}" width="60" alt="{{ $product->title }}">
                                    </div>
                                    <div class="team-details mb-3">
                                        <h3 class="team-name">{{ $product->title }}</h3>
                                        <div class="d-flex gap-sm-6 gap-2 align-items-center flex-wrap">
                                            <div class="d-flex gap-sm-3 gap-1 align-items-center">
                                                <i class="ti ti-users fs-2xl"></i>
                                                <span class="tcn-6"> اکانت{{ $product->needle }} نفره </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-lg-6 g-4 position-relative">
                <div class="col-lg-4 col-sm-6">
                    <div class="team-info p-xl-8 p-md-6 p-2 bgn-4 d-flex align-items-center gap-lg-6 gap-4 rounded">
                        <div class="team-info-icon">
                            <img class="w-100" src="/assets/img/price.png" alt="img">
                        </div>
                        <div class="team-info-details">
                            <h3 class="team-info-text tcn-1 mt-2">{{ number_format($product->price * intval(setting("doller_price"))) }} تومان </h3>
                            <span class="team-info-title tcn-6">قیمت </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="team-info p-xl-8 p-md-6 p-2 bgn-4 d-flex align-items-center gap-lg-6 gap-4 rounded">
                        <div class="team-info-icon">
                            <img class="w-100" src="/assets/img/buyers.png" alt="img">
                        </div>
                        <div class="team-info-details">
                            <h3 class="team-info-text tcn-1">{{ rand(1,30) }} نفر از ما</h3>
                            <span class="team-info-title tcn-6">این محصول را خریده‌اند</span>
                        </div>
                    </div>
                </div>
                @if($product->type)
                    <div class="col-lg-4 col-sm-6">
                        <div class="team-info p-xl-8 p-md-6 p-2 bgn-4 d-flex align-items-center gap-lg-6 gap-4 rounded">
                            <a href="{{ route("cart.add", ["id" => $product->id]) }}"
                                class="btn-rounded-cus wallet-btn border-0 d-flex align-items-center gap-3 p-xl-2 p-0 ps-xl-6 rounded-3 position-relative pe-3">
                                <span class="btn-circle fs-2xl">
                                    <i class="ti ti-shopping-cart"></i>
                                </span>
                                <span class="text-nowrap p-3">اضافه به سبد خرید</span>
                            </a>
                        </div>
                    </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger m-2 p-4"> {{ $error }} </div>
                    @endforeach
                @endif
            </div>
        </div>
        @if (!$product->type)
            <section class="sign-in-section pb-4 mt-lg-0 mt-sm-15">
                <div class="container mt-7">
                    <div class="row justify-content-center">

                        <div class="col-lg-12">

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger m-2 p-4"> {{ $error }} </div>
                                @endforeach
                            @endif
                            <div class="form-area p-4">
                                <h1 class="tcn-1 text-right cursor-scale growUp mb-6" style="font-size:15px">اطلاعات حساب کاربری
                                    خود را وارد کنید</h1>
                                <form dir="ltr" action="{{ route("cart.add", ["id" => $product->id]) }}" method="post"
                                    id="add_to_cart_form">
                                    @csrf
                                    <div class="sign-in-form  d-flex">
                                        <div class="single-input mb-6 me-30">
                                            <input type="email" dir="ltr" name="email" placeholder="email"
                                                value="{{ old("email") }}">
                                        </div>
                                        <div class="single-input mb-6 ms-10">
                                            <input dir="ltr" type="password" name="password" placeholder="password">
                                        </div>
                                    </div>
                                    <button
                                        class="add_to_cart btn-rounded-cus wallet-btn border-0 d-flex align-items-center gap-3 p-xl-2 p-0 ps-xl-6 rounded-3 position-relative">
                                        <span class="text-nowrap d-none d-xl-block">اضافه به سید خرید</span>
                                        <span class="btn-circle fs-2xl">
                                            <i class="ti ti-shopping-cart"></i>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

    </section>
@endsection
@section("script")
    <script>
        $(document).on("click", ".add_to_cart", function () {
            $("add_to_cart_form").submit();
        })
    </script>
@endsection
