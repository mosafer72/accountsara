@extends('Admin.app')

@section('title', 'لیست اسلایدها')

@section('content')

<div class="content">
             @include("Admin.layouts.header")

        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
                <li><a href="{{ route('admin.sliders.index') }}" class="is-active">اسلایدشو</a></li>
            </ul>
        </div>

        <div class="main-content font-size-13">
            <div class="tab__box">
                <div class="tab__items">
                    <a class="tab__item is-active" href="{{ route('admin.sliders.index') }}">لیست اسلایدها</a>
                    <a class="tab__item" href="{{ route('admin.sliders.create') }}">ایجاد اسلاید جدید</a>
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
                    @forelse ($sliders as $slider)
                        <tr role="row">
                            <td><a href="">{{ $slider->id }}</a></td>
                            <td><a href="">{{ $slider->title }}</a></td>
                            <td>
                                <a href="{{ asset('storage/'.$slider->image) }}" target="_blank">
                                    <img class="img__slideshow" src="{{ asset('storage/'.$slider->image) }}" alt="{{ $slider->title }}">
                                </a>
                            </td>
                            <td>
                                @if($slider->link)
                                    <a href="{{ $slider->link }}" target="_blank">{{ $slider->link }}</a>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td>{{ jdate($slider->created_at)->format('Y/m/d') }}</td>
                            <td>
                                @if($slider->status)
                                    <span class="badge bg-success">فعال</span>
                                @else
                                    <span class="badge bg-secondary">غیرفعال</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="item-delete mlg-15" title="حذف"></button>
                                </form>

                                <form action="{{ route('admin.sliders.toggle', $slider) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="{{ $slider->status ? 'item-reject' : 'item-confirm' }} mlg-15"
                                            title="{{ $slider->status ? 'غیرفعال کردن' : 'فعال کردن' }}"></button>
                                </form>

                                <a href="{{ route('admin.sliders.edit', $slider) }}" class="item-edit mlg-15" title="ویرایش"></a>
                                <a href="{{ asset('storage/'.$slider->image) }}" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">هیچ اسلایدی یافت نشد.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
       
@endsection
