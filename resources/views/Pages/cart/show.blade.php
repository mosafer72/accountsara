@extends("Pages.layouts.master")
@section("content")
<section class="game-section pb-120 pt-120 mt-lg-0 mt-sm-15 mt-10">
  <div class="container">
    <div class="row align-items-center justify-content-between mb-lg-15 mb-md-8 mb-sm-6 mb-4">
      <div class="">
        <h2 class="display-four tcn-1 cursor-scale growUp title-anim">سبد خرید شما</h2>
      </div>
    </div>

   {{-- ... بالای صفحه، همان کد خودت ... --}}

@if (auth()->check())
  @if(count($data["cart"])>0)

    <div class="row gy-lg-10 gy-6">
      @foreach ($data["cart"] as $product)
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="game-card-wrapper mx-auto">
            <div class="game-card mb-5 p-2">
              <div class="game-card-border"></div>
              <div class="game-card-border-overlay"></div>
              <div class="game-img">
                <img class="w-100 h-100" src="{{ asset('storage/'.$product->product->image) }}" alt="{{ $product->product->title }}">
              </div>
              <div class="game-link d-center">
                <a href="{{ route('cart.delete',['id'=>$product->product_id]) }}" class="btn2">
                  <i class="ti ti-trash fs-2xl"></i>
                </a>
              </div>

            </div>
            <a href="#"><h4 class="game-title mb-0 tcn-1 cursor-scale growDown2 title-anim">{{ $product->product->title }}</h4></a>
             <div class="card-title d-block tcn-1"> نوع :
                            @if($product->type)
                                 اختصاصی
                            @else
                                اشتراکی
                            @endif
             </div>
            <div>{{ number_format($product->unit_price * intval(setting("doller_price"))) }} تومان</div>
          </div>
        </div>
      @endforeach
    </div>

    @php
      $subtotal = collect($data["cart"])->sum(fn($i) => $i->qty * $i->unit_price  * intval(setting("doller_price")));
      $coupon   = session('cart_coupon');
      $discount = $coupon['discount'] ?? 0;
      $payable  = max($subtotal - $discount, 0);
    @endphp

    {{-- باکس خلاصه + فرم تخفیف + دکمه‌ها --}}
    <div class="row mt-15">
      <div class="col-lg-6">
        <div class="bgn-4 rounded p-4">
          <h5 class="tcn-1 mb-4">خلاصه پرداخت</h5>
          <div class="d-flex justify-content-between tcn-1 mb-2">
            <span>جمع جزء</span>
            <span>{{ number_format($subtotal,2) }}</span>
          </div>

          @if($coupon)
            <div class="d-flex justify-content-between tcn-1 mb-2">
              <span>تخفیف ({{ e($coupon['title']) }})</span>
              <span>- {{ number_format($discount) }}</span>
            </div>
          @endif

          <hr class="my-3">
          <div class="d-flex justify-content-between tcn-1 fs-lg">
            <strong>مبلغ قابل پرداخت</strong>
            <strong>{{ number_format($payable) }}</strong>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="bgn-4 rounded p-4">
          <h5 class="tcn-1 mb-4">کد تخفیف</h5>

          @error('coupon') <div class="alert alert-danger">{{ $message }}</div> @enderror
          @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

          @if(!$coupon)
            <form method="POST" action="{{ route('cart.coupon.apply') }}" class="d-flex gap-2 flex-wrap">
              @csrf
              <input type="text" name="coupon_code" class="form-control"
                     placeholder="مثلاً OFF10" style="max-width:260px" required>
              <button class="bttn py-sm-3 py-2 px-lg-8 px-sm-6 px-5 bgp-1 tcn-1 rounded-4">
                اعمال تخفیف
              </button>
            </form>
          @else
            <div class="d-flex align-items-center gap-2 mb-3 tcn-1">
              <i class="ti ti-badge-check fs-xl"></i>
              <span>کد <strong>{{ e($coupon['title']) }}</strong> اعمال شد.</span>
            </div>
            <form method="POST" action="{{ route('cart.coupon.remove') }}">
              @csrf @method('DELETE')
              <button class="bttn py-sm-3 py-2 px-lg-8 px-sm-6 px-5 bgp-2 tcn-1 rounded-4">
                حذف کد تخفیف
              </button>
            </form>
          @endif
        </div>
      </div>
    </div>

    <div class="row mt-6">
      <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <a href="{{ url('/') }}" class="bttn py-sm-4 py-3 px-lg-10 px-sm-8 px-6 bgp-2 tcn-1 rounded-4">
          <i class="ti ti-arrow-right fs-xl ms-2"></i> بازگشت
        </a>
        <a href="{{ route("checkout.place") }}" class="bttn py-sm-4 py-3 px-lg-10 px-sm-8 px-6 bgp-1 tcn-1 rounded-4">
          <i class="ti ti-credit-card fs-xl ms-2"></i> پرداخت
        </a>
      </div>
    </div>

  @else
    <div class="alert alert-warning">سبد خرید شما خالی است</div>
  @endif
@else
  <div class="alert alert-warning">ابتدا وارد اکانت خود شوید
    <a href="{{ route('login') }}" class="btn btn-success btn-sm">ورود</a>
  </div>
@endif

  </div>
</section>
@endsection
