@extends('Admin.app')

@section('title', 'ایجاد کاربر جدید')

@section('content')
    <div class="content">
        @include("Admin.layouts.header")


        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
                <li><a href="{{ route('admin.users.index') }}">کاربران</a></li>
                <li><a href="#" class="is-active">ایجاد کاربر جدید</a></li>
            </ul>
        </div>

        <div class="main-content font-size-13">
            <div class="tab__box">
                <div class="tab__items">
                    <a class="tab__item" href="{{ route('admin.users.index') }}">لیست کاربران</a>
                    <a class="tab__item is-active" href="{{ route('admin.users.create') }}">ایجاد کاربر جدید</a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success m-2 p-2">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
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
                <form action="{{ route('admin.users.store') }}" method="POST" class="padding-30 bg-white border-radius-3">
                    @csrf

                    <div class="row no-gutters">
                        <div class="col-12 margin-bottom-15">
                            <label class="label">نام</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="input" required>
                            @error('name')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">ایمیل</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="input" required>
                            @error('email')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">رمز عبور</label>
                            <input type="password" name="password" class="input" required>
                            @error('password')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">تکرار رمز عبور</label>
                            <input type="password" name="password_confirmation" class="input" required>
                        </div>

                        <div class="col-12 margin-bottom-15">
                            <label class="label">نقش</label>
                            <select name="is_admin" class="input">
                                <option value="0" {{ old('is_admin') == 0 ? 'selected' : '' }}>کاربر</option>
                                <option value="1" {{ old('is_admin') == 1 ? 'selected' : '' }}>ادمین</option>
                            </select>
                        </div>

                        <div class="col-12 margin-top-20">
                            <button type="submit" class="btn btn-brand">ایجاد کاربر</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-gray">بازگشت</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection