@extends('Admin.app')

@section('title','تنظیمات سایت')

@section('content')
<div class="content">
                         @include("Admin.layout.header")


    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="#" class="is-active">تنظیمات سایت</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="m-0">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form__box">
            <form action="{{ route('admin.settings.update') }}" method="POST" class="padding-30 bg-white border-radius-3">
                @csrf
                @method('PUT')

                <div class="row no-gutters">

                    <div class="col-12 margin-bottom-15">
                        <label class="label">نام سایت</label>
                        <input type="text" name="site_name" value="{{ setting('site_name') }}" class="input" placeholder="مثلاً فروشگاه من">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">ایمیل پشتیبانی</label>
                        <input type="email" name="support_email" value="{{ setting('support_email') }}" class="input" placeholder="info@example.com">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">شماره تماس</label>
                        <input type="text" name="support_phone"  value="{{ setting('support_phone') }}" class="input" placeholder="09123456789">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">آدرس</label>
                        <input type="text" name="address"   value="{{ setting('address') }}" class="input" placeholder="تهران، خیابان مثال">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">لینک اینستاگرام</label>
                        <input type="text" name="instagram"   value="{{ setting('instagram') }}" class="input" placeholder="https://instagram.com/...">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">لینک تلگرام</label>
                        <input type="text" name="telegram"   value="{{ setting('telegram') }}" class="input" placeholder="https://t.me/...">
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">توضیحات فوتر سایت</label>
                        <textarea name="footer_text" class="input" rows="3" placeholder="متن پایین سایت"> {{ setting('footer_text') }}</textarea>
                    </div>

                    <div class="col-12 margin-top-20">
                        <button type="submit" class="btn btn-brand">ذخیره تغییرات</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
