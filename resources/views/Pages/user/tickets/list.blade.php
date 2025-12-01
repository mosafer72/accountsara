@extends("Pages.user.user_app")
@section("user_content")
        <a class="btn btn-success" href="{{ route("profile.tickets.create") }}">ایجاد تیکت
            جدید</a>
        <div class="p-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">عنوان</th>
                        <th scope="col">تاریخ</th>
                        <th scope="col">وضعیت</th>
                        <th scope="col">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 1;
                    @endphp
                    @foreach ($tickets as $ticket)
                        <tr>
                            <th scope="row">{{ $counter }}</th>
                            <td>{{ $ticket->subject }}</td>
                            <td>
                                <span class="text-center" dir="ltr">{{ jdate($ticket->created_at) }}</span>
                            </td>
                            <td>@if ($ticket->status == "open")
                                <span class="bg-success rounded-2 px-2 text-white">باز</span>
                            @else
                                    <span class="bg-warning rounded-2 px-2">بسته</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route("profile.tickets.create", $ticket->id) }}" class="btn btn-sm btn-success">
                                    پاسخ دادن
                                </a>
                            </td>
                        </tr>
                        @php
                            $counter++
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection
