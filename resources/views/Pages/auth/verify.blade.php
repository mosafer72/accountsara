@extends("Pages.layouts.master")
@section("content")
<section class="sign-in-section pb-120 pt-120 mt-lg-4 mt-sm-15 mt-10">
        <div class="container pt-120 mt-lg-4">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="form-area">
                        <div class="muted" style="margin-bottom:10px">
                          کد ارسال‌شده به: <strong>{{ $phone }}</strong>
                        </div>
                        <h1 class="tcn-1 text-center cursor-scale growUp mb-10">ورود</h1>
                          <form  method="POST" action="{{ route('otp.verify') }}"  class="sign-in-form">
                            @csrf
                            <div class="single-input mb-6">
                                <input type="hidden" name="phone" value="{{ $phone }}">
                              <label for="">کد دریافت شده</label>
                                    <input id="code" type="text" name="code" inputmode="numeric" pattern="[0-9]*" maxlength="6" required autofocus placeholder="مثلاً 12345">
                            </div>
                            <div class="text-center">
                                <button class="bttn py-3 px-6 rounded bgp-1">تایید</button>
                            </div>
                        </form>
                        <div class="muted" style="margin-top:10px">
                          اگر کد نرسید، یک دقیقه بعد دوباره از صفحه قبل درخواست بدهید.
                        </div>

                        <div style="text-align:center;margin-top:8px">
                          <a href="{{ route('otp.phone.form') }}">ویرایش شماره</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

