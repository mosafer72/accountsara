@extends("Pages.layouts.master")
@section("content")
    <section class="sign-in-section pb-120 pt-120 mt-lg-4 mt-sm-15 mt-10">
        <div class="container pt-120 mt-lg-4">
            <div class="row justify-content-center">
                
                <div class="col-lg-6 m-auto">
                    @if(session('success'))
                    <div class="alert alert-success m-2 p-2 m-auto col-md-6 mb-5">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger m-auto col-md-6 mb-5">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert alert-danger m-auto col-md-12 mb-5" style="max-width:unset !important">
                        <ul class="m-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="form-area">
                        <h1 class="tcn-1 text-center cursor-scale growUp mb-10">ورود</h1>
                        <form action="{{ route('otp.send') }}" method="post" class="sign-in-form">
                            @csrf
                            <div class="single-input mb-6">
                                <label for="">تلفن همراه</label>
                                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                                    placeholder="مثلاً 0912xxxxxxx" required>
                            </div>
                            <div class="text-center">
                                <button class="bttn py-3 px-6 rounded bgp-1">ارسال کد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection