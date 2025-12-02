@extends('Admin.app')

@section('title','تیکت‌ها')

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
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.tickets.index') }}" class="is-active">تیکت‌ها</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box mb-3">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{ route('admin.tickets.index') }}">لیست تیکت‌ها</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success m-2 p-2">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger m-2 p-2">{{ session('error') }}</div>
        @endif

        <!-- فرم ایجاد تیکت جدید -->
        <div class="form__box mb-4">
            <form action="{{ route('admin.tickets.store') }}" method="POST" class="padding-20 bg-white border-radius-3">
                @csrf
                <div class="row no-gutters">
                    <div class="col-12 margin-bottom-15">
                        <label class="label">موضوع تیکت</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="input" required>
                        @error('subject')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 margin-bottom-15">
                        <label class="label">متن تیکت</label>
                        <textarea name="content" class="input" required>{{ old('content') }}</textarea>
                        @error('content')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 margin-top-20">
                        <button type="submit" class="btn btn-brand">ثبت تیکت</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- لیست تیکت‌ها -->
        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>کاربر</th>
                        <th>موضوع</th>
                        <th>متن</th>
                        <th>وضعیت</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->user->name }}</td>
                            <td>{{ $ticket->subject }}</td>
                            <td>{{ Str::limit($ticket->content,50) }}</td>
                            <td>
                                <span class="badge {{ $ticket->status=='open' ? 'bg-success':'bg-secondary' }}">{{ $ticket->status }}</span>
                            </td>
                            <td>{{ jdate($ticket->created_at)->format('Y/m/d H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.tickets.toggle',$ticket) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="item-confirm" title="تغییر وضعیت"></button>
                                </form>
                            </td>
                        </tr>

                        <!-- پاسخ‌ها -->
                        @if($ticket->children)
                            @include('Admin.tickets.replies',['replies'=>$ticket->children,'level'=>1])
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">هیچ تیکتی یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
