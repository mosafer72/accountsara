@extends('Admin.app')

@section('title', 'لیست کامنت‌ها')

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
            <li><a href="{{ route('dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.comments.index') }}" class="is-active">کامنت‌ها</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{ route('admin.comments.index') }}">لیست کامنت‌ها</a>
            </div>
        </div>

        <div class="table__box">
            <a href="{{ route('admin.comments.create', 1) }}" class="btn btn-brand m-2">ایجاد کامنت جدید</a>

            @if(session('success'))
                <div class="alert alert-success m-2 p-2">{{ session('success') }}</div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>کاربر</th>
                        <th>محصول</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comments as $comment)
                        @include('Admin.comments.comment_row', ['comment' => $comment, 'level' => 0])
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">هیچ کامنتی یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
