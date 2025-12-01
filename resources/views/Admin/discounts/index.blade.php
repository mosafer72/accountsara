@extends('Admin.app')

@section('title','لیست تخفیف‌ها')

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
            <li><a href="{{ route('admin.discounts.index') }}" class="is-active">تخفیف‌ها</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{ route('admin.discounts.index') }}">لیست تخفیف‌ها</a>
                <a class="tab__item" href="{{ route('admin.discounts.create') }}">ایجاد تخفیف جدید</a>
            </div>
        </div>

        <div class="table__box">
            @if(session('success'))
                <div class="alert alert-success m-2 p-2">{{ session('success') }}</div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>نوع</th>
                        <th>مقدار</th>
                        <th>دسته‌بندی</th>
                        <th>محصولات</th>
                        <th>ایجادکننده</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($discounts as $discount)
                        <tr>
                            <td>{{ $discount->id }}</td>
                            <td>{{ $discount->title }}</td>
                            <td>{{ $discount->type == 'percentage' ? 'درصدی' : 'مبلغ ثابت' }}</td>
                            <td>{{ $discount->value }}</td>
                            <td>{{ $discount->category?->name ?? '-' }}</td>
                            <td>
                                @foreach($discount->products as $product)
                                    <span class="badge bg-info">{{ $product->title }}</span>
                                @endforeach
                            </td>
                            <td>{{ $discount->user->name }}</td>
                            <td>
                                <span class="badge {{ $discount->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $discount->status ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.discounts.destroy',$discount) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="item-delete" title="حذف"></button>
                                </form>

                                <form action="{{ route('admin.discounts.toggle',$discount) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="{{ $discount->status ? 'item-reject' : 'item-confirm' }}" 
                                        title="{{ $discount->status ? 'غیرفعال کردن' : 'فعال کردن' }}">
                                    </button>
                                </form>

                                <a href="{{ route('admin.discounts.edit',$discount) }}" class="item-edit" title="ویرایش"></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">هیچ تخفیفی یافت نشد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
