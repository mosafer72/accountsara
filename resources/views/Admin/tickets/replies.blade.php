@foreach($replies as $reply)
<tr>
    <td>{{ $reply->id }}</td>
    <td>{{ $reply->user->name }}</td>
    <td style="padding-left: {{ $level*20 }}px;">{{ $reply->subject }}</td>
    <td>{{ Str::limit($reply->content,50) }}</td>
    <td>
        <span class="badge bg-secondary">پاسخ</span>
    </td>
    <td>{{ jdate($reply->created_at)->format('Y/m/d H:i') }}</td>
    <td>
        <!-- فرم پاسخ به این پاسخ -->
        <form action="{{ route('admin.tickets.store') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $reply->id }}">
            <input type="hidden" name="subject" value="پاسخ">
            <textarea name="content" placeholder="پاسخ..." required></textarea>
            <button type="submit" class="item-confirm" title="ارسال پاسخ"></button>
        </form>
    </td>
</tr>

@if($reply->children)
    @include('Admin.tickets.partials.replies',['replies'=>$reply->children,'level'=>$level+1])
@endif
@endforeach
