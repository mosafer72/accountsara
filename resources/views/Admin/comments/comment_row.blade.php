<tr>
    <td>{{ $comment->id }}</td>
    <td style="padding-left: {{ $level * 30 }}px;">
        {{ $comment->title }}
        @if($comment->replies->count())
            <span class="badge bg-secondary">{{ $comment->replies->count() }} پاسخ</span>
        @endif
    </td>
    <td>{{ $comment->user->name }}</td>
    <td>{{ $comment->product->title }}</td>
    <td>
        <span class="badge {{ $comment->is_active ? 'bg-success' : 'bg-secondary' }}">
            {{ $comment->is_active ? 'فعال' : 'غیرفعال' }}
        </span>
    </td>
    <td>
        <a href="{{ route('admin.comments.edit', $comment) }}" class="item-edit" title="ویرایش"></a>
        <a href="{{ route('admin.comments.create', $comment->product_id) }}?parent_id={{ $comment->id }}" class="item-eye" title="جواب دادن"></a>

        <form action="{{ route('admin.comments.toggle', $comment) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="{{ $comment->is_active ? 'item-reject' : 'item-confirm' }}" title="{{ $comment->is_active ? 'غیرفعال کردن' : 'فعال کردن' }}"></button>
        </form>

        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="item-delete" title="حذف"></button>
        </form>
    </td>
</tr>

@if($comment->replies->count())
    @foreach($comment->replies as $reply)
        @include('Admin.comments.partials.comment_row', ['comment' => $reply, 'level' => $level + 1])
    @endforeach
@endif
