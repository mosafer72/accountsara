@extends('Admin.app')

@section('content')
        @include("Admin.layout.header")

    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.sliders.index') }}">میانبرشو</a></li>
            <li><a href="#" class="is-active">ویرایش میانبر</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item" href="{{ route('admin.sliders.index') }}">لیست میانبرها</a>
                <a class="tab__item is-active">ویرایش میانبر</a>
            </div>
        </div>
        @if(session('success'))
                    <div class="alert alert-success m-2 p-2">
                        {{ session('success') }}
                    </div>
                @endif
                
            @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
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
        <div class="bg-white padding-30 border-radius-3">
            <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <label for="title">عنوان میانبر:</label>
                <input type="text" id="title" name="title" class="text" value="{{ old('title', $slider->title) }}">

                <label for="link">لینک:</label>
                <input type="text" id="link" name="link" class="text" value="{{ old('link', $slider->link) }}">

                <label for="image">تصویر جدید (اختیاری):</label>
                <div class="file-upload">
                    <div class="i-file-upload">
                        <span>انتخاب تصویر جدید</span>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                </div>

                @if($slider->image)
                    <p>تصویر فعلی:</p>
                    <img src="{{ asset('storage/'.$slider->image) }}" alt="" class="img__slideshow">
                @endif

                <button type="submit" class="btn btn-netcopy_net">بروزرسانی</button>
            </form>
        </div>
    </div>
@endsection
