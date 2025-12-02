@extends('Admin.app')

@section('title', 'ایجاد بنر جدید')

@section('content')
<div class="content">
        @include("Admin.layouts.header")


    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.banners.index') }}">بنرها</a></li>
            <li><a href="#" class="is-active">ایجاد بنر جدید</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item" href="{{ route('admin.banners.index') }}">لیست بنرها</a>
                <a class="tab__item is-active" href="{{ route('admin.banners.create') }}">ایجاد بنر جدید</a>
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
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="padding-30 bg-white border-radius-3">
                @csrf
                <div class="row no-gutters">
                    <div class="col-12 margin-bottom-15">
                        <label class="label">عنوان بنر</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="input" required>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">تصویر بنر</label>
                        <input type="file" name="image" class="input" required>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">لینک</label>
                        <input type="url" name="link" value="{{ old('link') }}" class="input">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">موقعیت نمایش</label>
                        <select name="position" class="input" required>
                            <option value="top">بالا</option>
                            <option value="middle">وسط</option>
                            <option value="bottom">پایین</option>
                        </select>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">وضعیت</label>
                        <select name="is_active" class="input">
                            <option value="1" selected>فعال</option>
                            <option value="0">غیرفعال</option>
                        </select>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">تاریخ شروع نمایش</label>
                        <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" class="input">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">تاریخ پایان نمایش</label>
                        <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" class="input">
                    </div>

                    <div class="col-12 margin-top-20">
                        <button type="submit" class="btn btn-brand">ایجاد بنر</button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-gray">بازگشت</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
