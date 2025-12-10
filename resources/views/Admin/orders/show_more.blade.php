@extends('Admin.app')

@section('title', 'ویرایش سفارش')

@section('content')
    <div class="content">
        @include("Admin.layout.header")

        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
                <li><a href="{{ route('admin.orders.index') }}">سفارشات</a></li>
                <li><a href="#" class="is-active">ویرایش سفارش</a></li>
            </ul>
        </div>

        <div class="main-content font-size-13">

            @if(session('success'))
                <div class="alert alert-success m-2 p-2">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form__box">
                <form action="{{ route('admin.orders.update', $order) }}" 
                      method="POST" 
                      class="padding-30 bg-white border-radius-3">
                    @csrf
                    @method('PUT')

                    <div class="row no-gutters">

                        {{-- اطلاعات سفارش --}}
                        <div class="col-12 margin-bottom-15">
                            <label class="label">شماره سفارش</label>
                            <input type="text" class="input" value="{{ $order->id }}" disabled>
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">نام مشتری</label>
                            <input type="text" class="input" value="{{ $order->user->name ?? '---' }}" disabled>
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">مبلغ (تومان)</label>
                            <input type="text" class="input" value="{{ number_format($order->amount) }}" disabled>
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">وضعیت پرداخت</label>
                            <input type="text" class="input" 
                                   value="{{ $order->paid ? 'پرداخت شده' : 'در انتظار پرداخت' }}" 
                                   disabled>
                        </div>

                        {{-- فیلد قابل ویرایش: deliverity --}}
                        <div class="col-12 margin-bottom-15">
                            <label class="label">وضعیت تحویل</label>
                            <select name="deliverity" class="input">
                                <option value="0" {{ $order->deliverity == 0 ? 'selected' : '' }}>
                                    تحویل نشده
                                </option>
                                <option value="1" {{ $order->deliverity == 1 ? 'selected' : '' }}>
                                    تحویل مشتری شد
                                </option>
                            </select>
                            @error('deliverity')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- دکمه‌ها --}}
                        <div class="col-12 margin-top-20">
                            <button type="submit" class="btn btn-brand">ذخیره تغییرات</button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-gray">بازگشت</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
