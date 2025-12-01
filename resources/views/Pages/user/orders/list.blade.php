@extends("Pages.user.user_app")
@section("user_content")
    <div>سفارشات من</div>
    <div class="p-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">شماره</th>
                    <th scope="col">تاریخ</th>
                    <th scope="col">قیمت</th>
                    <th scope="col">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $counter }}</th>
                        <td>{{ $order->number }}</td>
                        <td>
                            @if ($order->status == "paid")
                                <span class="btn btn-success">پرداخت شده</span>
                            @else
                                <span class="btn btn-sm btn-warning">در انتظار پرداخت</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-center" dir="ltr">{{ jdate($order->created_at) }}</span>
                        </td>
                        <td>
                            @if ($order->status != "paid")
                                <a href class="btn btn-sm btn-success">پرداخت</a>
                            @endif
                        </td>
                    </tr>
                    @php
                        $counter++
                    @endphp
                @endforeach
            </tbody>
        </table>
        {!! $orders->links() !!}
    </div>
@endsection
