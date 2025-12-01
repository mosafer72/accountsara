@extends('Admin.app')

@section('title', 'ایجاد تخفیف جدید')

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
            <li><a href="{{ route('admin.discounts.index') }}">تخفیف‌ها</a></li>
            <li><a href="#" class="is-active">ایجاد تخفیف جدید</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item" href="{{ route('admin.discounts.index') }}">لیست تخفیف‌ها</a>
                <a class="tab__item is-active" href="{{ route('admin.discounts.create') }}">ایجاد تخفیف جدید</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success m-2 p-2">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="m-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form__box">
            <form action="{{ route('admin.discounts.store') }}" method="POST" class="padding-30 bg-white border-radius-3">
                @csrf
                <div class="row no-gutters">
                    <div class="col-12 margin-bottom-15">
                        <label class="label">عنوان تخفیف</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="input" required>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">نوع تخفیف</label>
                        <select name="type" class="input">
                            <option value="percentage" {{ old('type')=='percentage' ? 'selected':'' }}>درصدی</option>
                            <option value="fixed" {{ old('type')=='fixed' ? 'selected':'' }}>مبلغ ثابت (تومان)</option>
                        </select>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">مقدار تخفیف</label>
                        <input type="number" step="0.01" name="value" value="{{ old('value') }}" class="input" required>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">دسته‌بندی (اختیاری)</label>
                        <select name="category_id" class="input">
                            <option value="">بدون دسته‌بندی</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected':'' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">محصولات (چندتایی)</label>
                        <select name="products[]" class="input" multiple>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ collect(old('products'))->contains($product->id) ? 'selected':'' }}>
                                    {{ $product->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">تاریخ شروع</label>
                        <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" class="input">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">تاریخ پایان</label>
                        <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" class="input">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">وضعیت</label>
                        <select name="status" class="input">
                            <option value="1" {{ old('status',1)==1 ? 'selected':'' }}>فعال</option>
                            <option value="0" {{ old('status',1)==0 ? 'selected':'' }}>غیرفعال</option>
                        </select>
                    </div>

                    <div class="col-12 margin-top-20">
                        <button type="submit" class="btn btn-brand">ایجاد تخفیف</button>
                        <a href="{{ route('admin.discounts.index') }}" class="btn btn-gray">بازگشت</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
