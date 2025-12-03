@extends('Admin.app')

@section('title', 'ویرایش کامنت')

@section('content')
    <div class="content">
        @include("Admin.layout.header")


        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
                <li><a href="{{ route('admin.comments.index') }}">کامنت‌ها</a></li>
                <li><a href="#" class="is-active">ویرایش کامنت</a></li>
            </ul>
        </div>

        <div class="main-content font-size-13">
            <div class="tab__box">
                <div class="tab__items">
                    <a class="tab__item" href="{{ route('admin.comments.index') }}">لیست کامنت‌ها</a>
                    <a class="tab__item is-active" href="#">ویرایش کامنت</a>
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
                <form action="{{ route('admin.comments.update', $comment) }}" method="POST"
                    class="padding-30 bg-white border-radius-3">
                    @csrf
                    @method('PATCH')

                    <div class="row no-gutters">
                        <div class="col-12 margin-bottom-15">
                            <label class="label">عنوان کامنت</label>
                            <input type="text" name="title" value="{{ old('title', $comment->title) }}" class="input"
                                required>
                            @error('title')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">محتوای کامنت</label>
                            <textarea name="content" class="input">{{ old('content', $comment->content) }}</textarea>
                            @error('content')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">وضعیت</label>
                            <select name="is_active" class="input">
                                <option value="1" {{ $comment->is_active ? 'selected' : '' }}>فعال</option>
                                <option value="0" {{ !$comment->is_active ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>

                        <div class="col-12 margin-top-20">
                            <button type="submit" class="btn btn-brand">به‌روزرسانی کامنت</button>
                            <a href="{{ route('admin.comments.index') }}" class="btn btn-gray">بازگشت</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection