@extends('Admin.app')

@section('title', 'لیست میانبرها')

@section('content')

<div class="content">
             @include("Admin.layout.header")

        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
                <li><a href="{{ route('admin.shortcuts.index') }}" class="is-active">میانبرشو</a></li>
            </ul>
        </div>

        <div class="main-content font-size-13">
            <div class="tab__box">
                <div class="tab__items">
                    <a class="tab__item is-active" href="{{ route('admin.shortcuts.index') }}">لیست میانبرها</a>
                    <a class="tab__item" href="{{ route('admin.shortcuts.create') }}">ایجاد میانبر جدید</a>
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
                            <th>تصویر</th>
                            <th>لینک</th>
                            <th>تاریخ ایجاد</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($shortcuts as $shortcut)
                        <tr role="row">
                            <td><a href="">{{ $shortcut->id }}</a></td>
                            <td><a href="">{{ $shortcut->title }}</a></td>
                            <td>
                                @if(isset($shortcut->image))
                                    <a href="{{ asset('storage/'.$shortcut->image) }}" target="_blank">
                                        <img class="img__slideshow" src="{{ asset('storage/'.$shortcut->image) }}" alt="{{ $shortcut->title }}">
                                    </a>
                                @else
                                     بدون عکس
                                @endif
                            </td>
                            <td>
                                @if($shortcut->link)
                                    <a href="{{ $shortcut->link }}" target="_blank">{{ $shortcut->link }}</a>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td>{{ jdate($shortcut->created_at)->format('Y/m/d') }}</td>
                            <td>
                                @if($shortcut->status)
                                    <span class="badge bg-success">فعال</span>
                                @else
                                    <span class="badge bg-secondary">غیرفعال</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.shortcuts.destroy', $shortcut) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="item-delete mlg-15" title="حذف"></button>
                                </form>

                                <form action="{{ route('admin.shortcuts.toggle', $shortcut) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="{{ $shortcut->status ? 'item-reject' : 'item-confirm' }} mlg-15"
                                            title="{{ $shortcut->status ? 'غیرفعال کردن' : 'فعال کردن' }}"></button>
                                </form>

                                <a href="{{ route('admin.shortcuts.edit', $shortcut) }}" class="item-edit mlg-15" title="ویرایش"></a>
                                <a href="{{ asset('storage/'.$shortcut->image) }}" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">هیچ میانبری یافت نشد.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
       
@endsection
