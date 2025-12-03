@extends('Admin.app')

@section('title', 'لیست دسته‌بندی‌ها')

@section('content')
    <div class="content">
        @include("Admin.layout.header")


        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
                <li><a href="{{ route('admin.categories.index') }}" class="is-active">دسته‌بندی‌ها</a></li>
            </ul>
        </div>

        <div class="main-content font-size-13">
            <div class="tab__box">
                <div class="tab__items">
                    <a class="tab__item is-active" href="{{ route('admin.categories.index') }}">لیست دسته‌بندی‌ها</a>
                    <a class="tab__item" href="{{ route('admin.categories.create') }}">ایجاد دسته‌بندی جدید</a>
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
                            <th>نام دسته‌بندی</th>
                            <th>توضیحات</th>
                            <th>تاریخ ایجاد</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $category)
                            <tr role="row">
                                <td><a href="">{{ $category->id }}</a></td>
                                <td><a href="">{{ $category->name }}</a></td>
                                <td>{{ $category->description ?? '-' }}</td>
                                <td>{{ jdate($category->created_at)->format('Y/m/d') }}</td>
                                <td>
                                    @if($category->status)
                                        <span class="badge bg-success">فعال</span>
                                    @else
                                        <span class="badge bg-secondary">غیرفعال</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="item-delete mlg-15" title="حذف"></button>
                                    </form>

                                    <form action="{{ route('admin.categories.toggle', $category) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="{{ $category->status ? 'item-reject' : 'item-confirm' }} mlg-15"
                                            title="{{ $category->status ? 'غیرفعال کردن' : 'فعال کردن' }}"></button>
                                    </form>

                                    <a href="{{ route('admin.categories.edit', $category) }}" class="item-edit mlg-15"
                                        title="ویرایش"></a>
                                    <a href="{{ route('admin.categories.show', $category) }}" class="item-eye mlg-15"
                                        title="مشاهده"></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">هیچ دسته‌بندی‌ای یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection