@extends('Admin.app')

@section('title', 'لیست بنرها')

@section('content')
<div class="content">
    
    @include("Admin.layouts.header")

    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.banners.index') }}" class="is-active">بنرها</a></li>
        </ul>
    </div>

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{ route('admin.banners.index') }}">لیست بنرها</a>
                <a class="tab__item" href="{{ route('admin.banners.create') }}">ایجاد بنر جدید</a>
            </div>
        </div>

        <div class="table__box">
            @if(session('success'))
                <div class="alert alert-success m-2 p-2">{{ session('success') }}</div>
            @endif

            <table class="table">
                <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>تصویر</th>
                        <th>لینک</th>
                        <th>موقعیت</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($banners as $banner)
                    <tr role="row">
                        <td>{{ $banner->id }}</td>
                        <td>{{ $banner->title }}</td>
                        <td>
                            @if($banner->image)
                            <a href="{{ asset('storage/'.$banner->image) }}" target="_blank">
                                <img class="img__slideshow" src="{{ asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}">
                            </a>
                            @endif
                        </td>
                        <td>
                            @if($banner->link)
                                <a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $banner->position }}</td>
                        <td>
                            @if($banner->is_active)
                                <span class="badge bg-success">فعال</span>
                            @else
                                <span class="badge bg-secondary">غیرفعال</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="item-delete mlg-15" title="حذف"></button>
                            </form>

                            <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="{{ $banner->is_active ? 'item-reject' : 'item-confirm' }} mlg-15"
                                        title="{{ $banner->is_active ? 'غیرفعال کردن' : 'فعال کردن' }}"></button>
                            </form>

                            <a href="{{ route('admin.banners.edit', $banner) }}" class="item-edit mlg-15" title="ویرایش"></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">هیچ بنری یافت نشد.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
