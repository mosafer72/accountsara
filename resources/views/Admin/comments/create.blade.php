@extends('Admin.app')

@section('title', 'ثبت کامنت')

@section('content')
<div class="content">
    <div class="header d-flex item-center bg-white width-100 border-bottom padding-12-30">
        <div class="header__right d-flex flex-grow-1 item-center">
            <span class="bars"></span>
            <a class="header__logo" href="{{ url('/') }}"></a>
        </div>
        <div class="header__left d-flex flex-end item-center margin-top-2">
            <a href="{{ route('logout') }}" class="logout" title="خروج"></a>
        </div>
    </div>

    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.comments.index') }}">کامنت‌ها</a></li>
            <li><a href="#" class="is-active">ثبت کامنت</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        @if(session('success'))
            <div class="alert alert-success m-2 p-2">{{ session('success') }}</div>
        @endif

        <div class="form__box margin-bottom-30">
            <form action="{{ route('admin.comments.store') }}" method="POST" class="padding-30 bg-white border-radius-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="parent_id" value="{{ request()->get('parent_id') }}">

                <div class="col-12 margin-bottom-15">
                    <label class="label">عنوان</label>
                    <input type="text" name="title" class="input" required>
                </div>

                <div class="col-12 margin-bottom-15">
                    <label class="label">متن کامنت</label>
                    <textarea name="content" class="input"></textarea>
                </div>

                <button type="submit" class="btn btn-brand">ثبت کامنت</button>
                <a href="{{ route('admin.comments.index') }}" class="btn btn-gray">بازگشت</a>
            </form>
        </div>
    </div>
</div>
@endsection
