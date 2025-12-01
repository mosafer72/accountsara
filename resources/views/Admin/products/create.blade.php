@extends('Admin.app')

@section('title', 'ایجاد محصول جدید')

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
                <li><a href="{{ route('admin.products.index') }}">محصولات</a></li>
                <li><a href="#" class="is-active">ایجاد محصول جدید</a></li>
            </ul>
        </div>

        <div class="main-content font-size-13">
            <div class="tab__box">
                <div class="tab__items">
                    <a class="tab__item" href="{{ route('admin.products.index') }}">لیست محصولات</a>
                    <a class="tab__item is-active" href="{{ route('admin.products.create') }}">ایجاد محصول جدید</a>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger m-2 p-2">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form__box">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="padding-30 bg-white border-radius-3">
                    @csrf

                    <div class="row no-gutters">
                        <div class="col-12 margin-bottom-15">
                            <label class="label">عنوان محصول</label>
                            <input type="text" name="title" class="input" value="{{ old('title') }}" required>
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">توضیحات</label>
                            <textarea name="description" class="input">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-6 margin-bottom-15">
                            <label class="label">تعداد موجودی</label>
                            <input type="number" name="quantity" class="input" value="{{ old('quantity', 1) }}" min="1">
                        </div>
                         <div class="col-6 margin-bottom-15">
                            <label class="label">قیمت</label>
                            <input type="text" name="price" class="input" value="{{ old('price', 1) }}">
                        </div>
                        <div class="col-6 margin-bottom-15">
                            <label class="label">تعداد نفرات</label>
                            <input type="text" name="needle" class="input" value="{{ old('needle', 1) }}">
                        </div>

                        <div class="col-6 margin-bottom-15">
                            <label class="label">درصد تخفیف (اختیاری)</label>
                            <input type="number" name="discount_percent" class="input" value="{{ old('discount_percent', 0) }}" min="0" max="100">
                        </div>

                        <div class="col-6 margin-bottom-15">
                            <label class="label">دسته‌بندی</label>
                            <select name="category_id" class="input">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 margin-bottom-15">
                            <label class="label">زمان فعال‌سازی (اختیاری)</label>
                            <input type="datetime-local" name="active_at" class="input" value="{{ old('active_at') }}">
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">تصویر محصول</label>
                            <input type="file" name="image" class="input">
                        </div>
                         <div class="col-12 margin-bottom-15">
                            <label class="label">بنر محصول</label>
                            <input type="file" name="banner" class="input">
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">وضعیت نمایش</label>
                            <select name="is_active" class="input">
                                <option value="1" selected>فعال</option>
                                <option value="0">غیرفعال</option>
                            </select>
                        </div>


                        <div class="col-12 margin-bottom-15">
                            <label class="label">وضعیت اشتراک</label>
                            <select name="type" class="input">
                                <option value="1" selected>اشتراکی </option>
                                <option value="0">اختصاصی</option>
                            </select>
                        </div>

                        <div class="col-12 margin-top-20">
                            <button type="submit" class="btn btn-brand">ایجاد محصول</button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-gray">بازگشت</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>
@endsection
