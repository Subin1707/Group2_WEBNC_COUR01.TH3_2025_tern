@if($comments->count())
<h4>Bình luận ({{ $comments->total() }})</h4>
<div class="list-group">
    @foreach($comments as $comment)
        <div class="list-group-item mb-2">
            <div class="d-flex justify-content-between">
                <strong>{{ $comment->title ?? 'binh luan' }}</strong>
                <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
            </div>
            <p class="mb-1">{{ $comment->content }}</p>
            <small>Đăng bởi: {{ $comment->author?->name??'Khách' }}</small>
        </div>
    @endforeach
</div>
@else
    <p>Chưa có bình luận nào.</p>
@endif