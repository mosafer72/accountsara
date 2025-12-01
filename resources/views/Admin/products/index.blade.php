@extends('Admin.app')

@section('title', 'مدیریت محصولات')

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
            <li><a href="{{ route('dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.products.index') }}" class="is-active">مدیریت محصولات</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{ route('admin.products.index') }}">لیست محصولات</a>
                <a class="tab__item" href="{{ route('admin.products.create') }}">ایجاد محصول جدید</a>
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
                        <th>عنوان</th>
                        <th>دسته‌بندی</th>
                        <th>تعداد</th>
                        <th>تخفیف (%)</th>
                        <th>تصویر</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($products as $product)
                    <tr role="row">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->discount_percent }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" width="60" alt="{{ $product->title }}">
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge bg-success">فعال</span>
                            @else
                                <span class="badge bg-secondary">غیرفعال</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="item-delete mlg-15" title="حذف"></button>
                            </form>

                            <a href="{{ route('admin.products.edit', $product) }}" class="item-edit mlg-15" title="ویرایش"></a>
                            <a href="{{ asset('storage/'.$product->image) }}" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">هیچ محصولی یافت نشد.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
             {!! $orders->links('pagination::default') !!}
        </div>
    </div>
</div>
@endsection
