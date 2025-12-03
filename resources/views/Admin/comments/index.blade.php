@extends('Admin.app')

@section('title', 'لیست کامنت‌ها')

@section('content')
    <div class="content">
        @include("Admin.layout.header")
Í

        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
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