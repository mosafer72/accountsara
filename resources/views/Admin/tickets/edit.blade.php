@extends('Admin.app')

@section('title', 'ویرایش تخفیف')

@section('content')
<div class="content">
    @include("Admin.layouts.header")
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.discounts.index') }}">تخفیف‌ها</a></li>
            <li><a href="#" class="is-active">ویرایش تخفیف</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item" href="{{ route('admin.discounts.index') }}">لیست تخفیف‌ها</a>
                <a class="tab__item is-active" href="#">ویرایش تخفیف</a>
            </div>
        </div>

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
            <form action="{{ route('admin.discounts.update', $discount) }}" method="POST" class="padding-30 bg-white border-radius-3">
                @csrf
                @method('PUT')

                <div class="row no-gutters">
                    <div class="col-12 margin-bottom-15">
                        <label class="label">عنوان تخفیف</label>
                        <input type="text" name="title" value="{{ old('title',$discount->title) }}" class="input" required>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">نوع تخفیف</label>
                        <select name="type" class="input">
                            <option value="percentage" {{ old('type',$discount->type)=='percentage' ? 'selected':'' }}>درصدی</option>
                            <option value="fixed" {{ old('type',$discount->type)=='fixed' ? 'selected':'' }}>مبلغ ثابت (تومان)</option>
                        </select>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">مقدار تخفیف</label>
                        <input type="number" step="0.01" name="value" value="{{ old('value',$discount->value) }}" class="input" required>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">دسته‌بندی (اختیاری)</label>
                        <select name="category_id" class="input">
                            <option value="">بدون دسته‌بندی</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id',$discount->category_id)==$category->id ? 'selected':'' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">محصولات (چندتایی)</label>
                        <select name="products[]" class="input" multiple>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ in_array($product->id, old('products',$selectedProducts)) ? 'selected':'' }}>
                                    {{ $product->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">تاریخ شروع</label>
                        <input type="datetime-local" name="start_at" value="{{ old('start_at',$discount->start_at?->format('Y-m-d\TH:i')) }}" class="input">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">تاریخ پایان</label>
                        <input type="datetime-local" name="end_at" value="{{ old('end_at',$discount->end_at?->format('Y-m-d\TH:i')) }}" class="input">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">وضعیت</label>
                        <select name="status" class="input">
                            <option value="1" {{ old('status',$discount->status)==1 ? 'selected':'' }}>فعال</option>
                            <option value="0" {{ old('status',$discount->status)==0 ? 'selected':'' }}>غیرفعال</option>
                        </select>
                    </div>

                    <div class="col-12 margin-top-20">
                        <button type="submit" class="btn btn-brand">بروزرسانی تخفیف</button>
                        <a href="{{ route('admin.discounts.index') }}" class="btn btn-gray">بازگشت</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
