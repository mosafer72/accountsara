@extends('Admin.app')

@section('title', 'لیست کاربران')

@section('content')
    <div class="content">
        @include("Admin.layout.header")


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
                                        <button type="submit"
                                            class="{{ $user->is_active ?? true ? 'item-reject' : 'item-confirm' }} mlg-15"
                                            title="{{ $user->is_active ?? true ? 'غیرفعال کردن' : 'فعال کردن' }}"></button>
                                    </form>

                                    <a href="{{ route('admin.users.edit', $user) }}" class="item-edit mlg-15"
                                        title="ویرایش"></a>
                                    <a href="{{ route('admin.users.loginAs', $user) }}" class="item-eye mlg-15"
                                        title="ورود به عنوان کاربر"></a>
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
             {!! $users->links('pagination::default') !!}
        </div>
    </div>
@endsection