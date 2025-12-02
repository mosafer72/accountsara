@extends("Pages.user.user_app")
@section("user_content")
    <div class="p-4">
        @if(session('success'))
                <div class="alert alert-success m-2 p-2">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

        <!-- Personal Information -->
        <div class="mb-4 col-12 col-md-12 m-auto p-5 p-md-20 pt-5 bg-dark rounded-4 text-white">
            <h5 class="my-10 ">اطلاعات شخصی</h5>
            <form action="{{ route("profile.update") }}" method="post" class="row g-3 p-30">
                @csrf
                <div class="col-md-12">
                    <label class="form-label">نام و نام خانوادگی</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label">شماره موبایل</label>
                    <input type="" class="form-control" value="{{ $user->phone }}">
                </div>
                <button type="submit" class="btn btn-primary mt-10">Submit</button>
            </form>
        </div>
    </div>

@endsection