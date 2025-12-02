@extends('Admin.app')

@section('content')
<div class="content">
        @include("Admin.layouts.header")

    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.sliders.index') }}">اسلایدشو</a></li>
            <li><a href="#" class="is-active">ایجاد اسلاید جدید</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item" href="{{ route('admin.sliders.index') }}">لیست اسلایدها</a>
                <a class="tab__item is-active">ایجاد اسلاید جدید</a>
            </div>
        </div>

        <div class="bg-white padding-30 border-radius-3">
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label for="title">عنوان اسلاید:</label>
                <input type="text" id="title" name="title" class="text" placeholder="مثلاً دوره لاراول" value="{{ old('title') }}">
                @error('title') <p class="text-error">{{ $message }}</p> @enderror

                <label for="link">لینک:</label>
                <input type="text" id="link" name="link" class="text" placeholder="مثلاً https://netcopy.ir" value="{{ old('link') }}">
                @error('link') <p class="text-error">{{ $message }}</p> @enderror

                <label for="image">تصویر:</label>
                <div class="file-upload">
                    <div class="i-file-upload">
                        <span>آپلود تصویر</span>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                </div>
                @error('image') <p class="text-error">{{ $message }}</p> @enderror

                <button type="submit" class="btn btn-netcopy_net">ثبت اسلاید</button>
            </form>
        </div>
    </div>
</div>
@endsection
