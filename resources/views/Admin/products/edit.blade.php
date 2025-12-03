@extends('Admin.app')

@section('title', 'ویرایش محصول')

@section('content')
<div class="content">
                @include("Admin.layout.header")


        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
                <li><a href="{{ route('admin.products.index') }}">محصولات</a></li>
                <li><a href="#" class="is-active">ویرایش محصول</a></li>
            </ul>
        </div>

        <div class="main-content font-size-13">
            <div class="tab__box">
                <div class="tab__items">
                    <a class="tab__item" href="{{ route('admin.products.index') }}">لیست محصولات</a>
                    <a class="tab__item is-active" href="#">ویرایش محصول</a>
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
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="padding-30 bg-white border-radius-3">
                    @csrf
                    @method('PUT')

                    <div class="row no-gutters">
                        <div class="col-12 margin-bottom-15">
                            <label class="label">عنوان محصول</label>
                            <input type="text" name="title" class="input" value="{{ old('title', $product->title) }}" required>
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">توضیحات</label>
                            <textarea name="description" class="input">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="col-6 margin-bottom-15">
                            <label class="label">تعداد موجودی</label>
                            <input type="number" name="quantity" class="input" value="{{ old('quantity', $product->quantity) }}" min="1">
                        </div>

                        <div class="col-6 margin-bottom-15">
                            <label class="label">قیمت</label>
                            <input type="text" name="price" class="input" value="{{ old('price', $product->price) }}" >
                        </div>
                        <div class="col-6 margin-bottom-15">
                            <label class="label">تعداد نفرات</label>
                            <input type="text" name="needle" class="input" value="{{ old('needle', $product->needle) }}" >
                        </div>
                        <div class="col-6 margin-bottom-15">
                            <label class="label">درصد تخفیف</label>
                            <input type="number" name="discount_percent" class="input" value="{{ old('discount_percent', $product->discount_percent) }}" min="0" max="100">
                        </div>

                        <div class="col-6 margin-bottom-15">
                            <label class="label">دسته‌بندی</label>
                            <select name="category_id" class="input">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $cat->id == $product->category_id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 margin-bottom-15">
                            <label class="label">زمان فعال‌سازی</label>
                            <input type="datetime-local" name="active_at" class="input"
                                   value="{{ old('active_at', $product->active_at ? $product->active_at->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">تصویر محصول</label>
                            <input type="file" name="image" class="input">
                            @if ($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" alt="" width="80" class="mt-2">
                            @endif
                        </div>
                        <div class="col-12 margin-bottom-15">
                            <label class="label">بنر محصول</label>
                            <input type="file" name="banner" class="input">
                            @if ($product->banner)
                                <img src="{{ asset('storage/'.$product->banner) }}" alt="" width="80" class="mt-2">
                            @endif
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">وضعیت نمایش</label>
                            <select name="is_active" class="input">
                                <option value="1" {{ $product->is_active ? 'selected' : '' }}>فعال</option>
                                <option value="0" {{ !$product->is_active ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                         <div class="col-12 margin-bottom-15">
                            <label class="label">نوع استفاده</label>
                            <select name="type" class="input">
                                <option value="1" {{ $product->is_active ? 'selected' : '' }}>اشتراکی</option>
                                <option value="0" {{ !$product->is_active ? 'selected' : '' }}>اختصاصس</option>
                            </select>
                        </div>

                        <div class="col-12 margin-top-20">
                            <button type="submit" class="btn btn-brand">بروزرسانی محصول</button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-gray">بازگشت</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>
@endsection
