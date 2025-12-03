@extends('Admin.app')

@section('title', 'ویرایش دسته‌بندی')

@section('content')
    <div class="content">
                 @include("Admin.layout.header")

        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
                <li><a href="{{ route('admin.categories.index') }}">دسته‌بندی‌ها</a></li>
                <li><a href="#" class="is-active">ویرایش دسته‌بندی</a></li>
            </ul>
        </div>

        <div class="main-content font-size-13">
            <div class="tab__box">
                <div class="tab__items">
                    <a class="tab__item" href="{{ route('admin.categories.index') }}">لیست دسته‌بندی‌ها</a>
                    <a class="tab__item is-active" href="#">ویرایش دسته‌بندی</a>
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
            <div class="form__box">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST"
                    class="padding-30 bg-white border-radius-3">
                    @csrf
                    @method('PUT')

                    <div class="row no-gutters">
                        <div class="col-12 margin-bottom-15">
                            <label class="label">عنوان دسته‌بندی</label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="input"
                                required>
                            @error('name')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">توضیحات</label>
                            <textarea name="description"
                                class="input">{{ old('description', $category->description) }}</textarea>
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">وضعیت</label>
                            <select name="status" class="input">
                                <option value="active" {{ $category->status ? 'selected' : '' }}>فعال</option>
                                <option value="inactive" {{ !$category->status ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>

                        <div class="col-12 margin-top-20">
                            <button type="submit" class="btn btn-brand">ویرایش دسته‌بندی</button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-gray">بازگشت</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection