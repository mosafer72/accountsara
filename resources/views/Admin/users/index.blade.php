@extends('Admin.app')

@section('title', 'لیست کاربران')

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
                <div class="dropdown__notification">
                    <div class="content__notification">
                        <span class="font-size-13">موردی برای نمایش وجود ندارد</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="logout" title="خروج"></a>
        </div>
    </div>

    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="is-active">کاربران</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{ route('admin.users.index') }}">لیست کاربران</a>
                <a class="tab__item" href="{{ route('admin.users.create') }}">ایجاد کاربر جدید</a>
            </div>
        </div>

        <div class="table__box">
            @if(session('success'))
                <div class="alert alert-success m-2 p-2">{{ session('success') }}</div>
            @endif

            <table class="table">
                <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th class="p-r-90">شناسه</th>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>نقش</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($users as $user)
                    <tr role="row">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->is_admin ? 'مدیر' : 'کاربر' }}</td>
                        <td>
                            @if($user->is_active ?? true)
                                <span class="badge bg-success">فعال</span>
                            @else
                                <span class="badge bg-secondary">غیرفعال</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="item-delete mlg-15" title="حذف"></button>
                            </form>

                            <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="{{ $user->is_active ?? true ? 'item-reject' : 'item-confirm' }} mlg-15"
                                        title="{{ $user->is_active ?? true ? 'غیرفعال کردن' : 'فعال کردن' }}"></button>
                            </form>

                            <a href="{{ route('admin.users.edit', $user) }}" class="item-edit mlg-15" title="ویرایش"></a>
                            <a href="{{ route('admin.users.loginAs', $user) }}" class="item-eye mlg-15" title="ورود به عنوان کاربر"></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">هیچ کاربری یافت نشد.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
