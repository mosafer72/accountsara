@extends("Pages.layouts.master")
@section("content")
    <section class="team-profile-banner pb-120 pt-120 mt-lg-0 mt-sm-15 mt-10">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12">
                    <a href="javascript:void(0)" onclick="window.history.back()" class="back-btn"><i
                            class="ti ti-arrow-narrow-right fs-2xl"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-lg-20 mb-15 pb-lg-10 pb-6">
                    <div class="parallax-banner-area parallax-container">
                        <div class="parallax-img team-banner position-relative"
                            style="translate: none; rotate: none; scale: none; transform: translate(0%, 17.3274%) translate3d(0px, 0px, 0px);">
                            <img class="w-100 h-100 tbi rounded-5" src="/assets/img/team-x.png" alt="بنر مسابقات">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <section class="sign-in-section pb-4 mt-lg-0 mt-sm-15">
            <div class="container mt-7">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        @if(session('success'))
                            <div class="alert alert-success m-2 p-2">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger m-2 p-4"> {{ $error }} </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
@section("script")
    <script>
        $(document).on("click", ".add_to_cart", function () {
            $("add_to_cart_form").submit();
        })
    </script>
@endsection
