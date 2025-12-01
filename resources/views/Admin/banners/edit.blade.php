@extends('Admin.app')

@section('title', 'ویرایش بنر')

@section('content')
<div class="content">
    <div class="header d-flex item-center bg-white width-100 border-bottom padding-12-30">
        <div class="header__right d-flex flex-grow-1 item-center">
            <span class="bars"></span>
            <a class="header__logo" href="{{ url('/') }}"></a>
        </div>
        <div class="header__left d-flex flex-end item-center margin-top-2">
            <span class="account-balance font-size-12">موجودی : 2,500,000 تومان</span>
            <div class="notification margin-15">
                <a class="notification__icon"></a>
            </div>
            <a href="{{ route('logout') }}" class="logout" title="خروج"></a>
        </div>
    </div>

    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.banners.index') }}">بنرها</a></li>
            <li><a href="#" class="is-active">ویرایش بنر</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item" href="{{ route('admin.banners.index') }}">لیست بنرها</a>
                <a class="tab__item is-active" href="#">ویرایش بنر</a>
            </div>
        </div>

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

        <div class="form__box">
            <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="padding-30 bg-white border-radius-3">
                @csrf
                @method('PUT')

                <div class="row no-gutters">
                    <div class="col-12 margin-bottom-15">
                        <label class="label">عنوان بنر</label>
                        <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="input" required>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">تصویر بنر</label>
                        <input type="file" name="image" class="input">
                        @if($banner->image)
                            <div class="margin-top-10">
                                <img src="{{ asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}" width="150">
                            </div>
                        @endif
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">لینک</label>
                        <input type="url" name="link" value="{{ old('link', $banner->link) }}" class="input">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">موقعیت نمایش</label>
                        <select name="position" class="input" required>
                            <option value="top" {{ $banner->position == 'top' ? 'selected' : '' }}>بالا</option>
                            <option value="middle" {{ $banner->position == 'middle' ? 'selected' : '' }}>وسط</option>
                            <option value="bottom" {{ $banner->position == 'bottom' ? 'selected' : '' }}>پایین</option>
                        </select>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">وضعیت</label>
                        <select name="is_active" class="input">
                            <option value="1" {{ $banner->is_active ? 'selected' : '' }}>فعال</option>
                            <option value="0" {{ !$banner->is_active ? 'selected' : '' }}>غیرفعال</option>
                        </select>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">تاریخ شروع نمایش</label>
                        <input type="datetime-local" name="start_at" value="{{ old('start_at', $banner->start_at?->format('Y-m-d\TH:i')) }}" class="input">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">تاریخ پایان نمایش</label>
                        <input type="datetime-local" name="end_at" value="{{ old('end_at', $banner->end_at?->format('Y-m-d\TH:i')) }}" class="input">
                    </div>

                    <div class="col-12 margin-top-20">
                        <button type="submit" class="btn btn-brand">ویرایش بنر</button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-gray">بازگشت</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
