@extends("Pages.layouts.master")

@section('title')
    خرید
    @isset($category)
        اکانت {{ $category->name }}
    @else
        اکانت پریمیوم
    @endisset
    | لیست قیمت و تحویل فوری – Accountsara
@endsection

@section('meta_description')
لیست قیمت و خرید
@isset($category)
    اکانت {{ $category->name }}
@else
    اکانت‌های پریمیوم
@endisset
با تحویل فوری، پشتیبانی کامل و خرید امن از Accountsara.
@endsection

@section("content")
    <style>
        .pagination {
            margin: auto;
        }
    </style>
    <section class="tournament-section pb-120 pt-120 mt-sm-15 mt-120">
        <div class="tournament-wrapper alt">
            <div class="container">
                <div class="row justify-content-between align-items-end mb-8">
                    <div class="col">
                        <h2 class="display-four tcn-1 cursor-scale growUp title-anim">
                            @isset($category)
                                {{  $category->name }}
                            @else
                                محصولات
                            @endisset
                        </h2>
                    </div>
                </div>
                <div class="singletab tournaments-tab">
                    <!-- <div class="d-between gap-6 flex-wrap mb-lg-15 mb-sm-10 mb-6">
                            <ul class="tablinks d-flex flex-wrap align-items-center gap-3">
                                <li class="nav-links active">
                                    <button class="tablink py-sm-3 py-2 px-sm-8 px-6 rounded-pill tcn-1">همه</button>
                                </li>
                                <li class="nav-links">
                                    <button class="tablink py-sm-3 py-2 px-sm-8 px-6 rounded-pill tcn-1">فعال</button>
                                </li>
                                <li class="nav-links">
                                    <button class="tablink py-sm-3 py-2 px-sm-8 px-6 rounded-pill tcn-1">بزودی</button>
                                </li>
                                <li class="nav-links">
                                    <button class="tablink py-sm-3 py-2 px-sm-8 px-6 rounded-pill tcn-1">پایان
                                        یافته</button>
                                </li>
                            </ul>
                            <div class="px-6">
                                <a href="#"
                                    class="btn-half-border position-relative d-inline-block py-2 bgp-1 px-6 rounded-pill">بیشتر
                                    ببینید</a>
                            </div>
                        </div> -->
                    <div class="tabcontents">
                        <div class="tabitem active">
                            <div class="row justify-content-md-start justify-content-center g-6">
                                @if(count($products) > 0)
                                    @foreach ($products as $product)
                                        <div class="col-xl-4 col-md-6 col-sm-10">
                                            <div class="tournament-card p-xl-4 p-3 pb-xl-8 bgn-4">
                                                <div class="tournament-img mb-8 position-relative">
                                                    <div class="img-area overflow-hidden">
                                                        <img class="w-100" src="{{ asset('storage/' . $product->image) }}"
                                                            alt="{{ $product->title }}">
                                                    </div>
                                                    <span class="card-status position-absolute end-0 py-2 px-6 tcn-1 fs-sm">
                                                        <a href="{{ route("product.show_more", ["id" => $product->id]) }}"
                                                            class="dot-icon alt-icon pe-3">مشاهده</a>
                                                    </span>
                                                </div>
                                                <div class="tournament-content px-xxl-4">
                                                    <div class="tournament-info mb-5">
                                                        <a href="{{ route("product.show_more", ["id" => $product->id]) }}"
                                                            class="d-block">
                                                            <h4
                                                                class="tournament-title tcn-1 mb-1 cursor-scale growDown title-anim">
                                                                {{ $product->title }}</h4>
                                                        </a>
                                                        <span class="tcn-6 fs-sm">
                                                            @if($product->title)
                                                                اشتراکی {{ $product->needle }} نفره
                                                            @else
                                                                اختصاصی
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="hr-line line3"></div>
                                                    <div class="card-info d-flex align-items-center gap-3 flex-wrap my-5">
                                                        <div
                                                            class="price-money bgn-3 d-flex align-items-center gap-3 py-2 px-3 h-100">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <img class="" style="width:30px" src="/assets/img/price.png"
                                                                    alt="تتر">
                                                                <span
                                                                    class="tcn-1 fs-sm">{{ number_format($product->price * intval(setting("doller_price"))) }}
                                                                    تومان </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="hr-line line3"></div>
                                                    <div class="card-more-info d-between mt-6">
                                                        <div class="teams-info d-between gap-xl-5 gap-3">
                                                            <div class="player d-flex align-items-center gap-1">
                                                                <i class="ti ti-user fs-base"></i>
                                                                <span class="tcn-6 fs-sm">{{ $product->sell_count }} نفر تهیه
                                                                    کرده‌اند</span>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route("product.show_more", ["id" => $product->id]) }}"
                                                            class="btn2">
                                                            <i class="ti ti-arrow-left fs-2xl"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {!! $products->links('pagination::default') !!}
                                @else
                                    <div class="alert alert-danger">
                                        به این دسته بندی به زودی محصول اضافه خواهد شد.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection