@extends("Admin.app")

@section("content")
<style>
    .pending {
        position: relative;
    }
    .pending ::after{
        content: "";
        position: absolute;
        right: 0;
        height: 90%;
        background-color: red;
        width: 5px;
        top: 5%;
    }
</style>
    <div class="content">
        @include("Admin.layout.header")

        <div class="breadcrumb">
            <ul>
                <li><a href="index.html" title="پیشخوان">پیشخوان</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="row no-gutters font-size-13 margin-bottom-10">
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> موجودی حساب فعلی </p>
                    <p>2,500,000 تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> کل فروش دوره ها</p>
                    <p>2,500,000 تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> کارمزد کسر شده </p>
                    <p>2,500,000 تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
                    <p> درآمد خالص </p>
                    <p>2,500,000 تومان</p>
                </div>
            </div>
            <div class="row no-gutters font-size-13 margin-bottom-10">
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> درآمد امروز </p>
                    <p>500,000 تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> درآمد 30 روز گذاشته</p>
                    <p>2,500,000 تومان</p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                    <p> تسویه حساب در حال انجام </p>
                    <p>0 تومان </p>
                </div>
                <div class="col-3 padding-20 border-radius-3 bg-white  margin-bottom-10">
                    <p>تراکنش های موفق امروز (0) تراکنش </p>
                    <p>2,500,000 تومان</p>
                </div>
            </div>
            <div class="row no-gutters font-size-13 margin-bottom-10">
                <div class="col-8 padding-20 bg-white margin-bottom-10 margin-left-10 border-radius-3">
                    محل قرار گیری نمودار
                </div>
                <div class="col-4 info-amount padding-20 bg-white margin-bottom-12-p margin-bottom-10 border-radius-3">

                    <p class="title icon-outline-receipt">موجودی قابل تسویه </p>
                    <p class="amount-show color-444">600,000<span> تومان </span></p>
                    <p class="title icon-sync">در حال تسویه</p>
                    <p class="amount-show color-444">0<span> تومان </span></p>
                    <a href="/" class=" all-reconcile-text color-2b4a83">همه تسویه حساب ها</a>
                </div>
            </div>
            <div class="row bg-white no-gutters font-size-13">
                <div class="title__row">
                    <p>تراکنش های اخیر شما</p>
                    <a class="all-reconcile-text margin-left-20 color-2b4a83">نمایش همه تراکنش ها</a>
                </div>
                <div class="table__box">
                    <table width="100%" class="table">
                        <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>شناسه پرداخت</th>
                                <th>ایمیل پرداخت کننده</th>
                                <th>مبلغ (تومان)</th>
                                <th>درامد شما</th>
                                <th>درامد سایت</th>
                                <th>تاریخ و ساعت</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ($orders as $order)
                                <tr role="row" class="<?php if($order->deliverity==1) {echo "delivered";} else{echo "pending";} ?>">
                                    <td><a href=""> {{ $counter }}</a></td>
                                    <td>{{ $order->number }}</td>
                                    <td>{{ $order->subtotal }}</td>
                                    <td>{{ $order->subtotal }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ jdate($order->paid_at)->format('Y/m/d H:m') }}</td>
                                    <td>
                                        @if ($order->status == "paid")
                                            <span class="btn btn-success">پرداخت شده</span>
                                        @else
                                            <span class="btn btn-sm btn-warning">در انتظار پرداخت</span>
                                        @endif
                                    </td>
                                    <td class="i__oprations">
                                        <a href="" class="item-delete margin-left-10" title="حذف"></a>
                                        <a href="{{ route("admin.orders.show_more",$order->id) }}" class="item-edit  margin-left-10" title='ویرایش'></a>
                                        <a href="" class="item-eye" title='مشاهده'></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $orders->links('pagination::default') !!}
                </div>
            </div>
        </div>
    </div>
@endsection