@if($errors->any())
    <div class="alert alert-danger">
        <ul class ="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('news.comments.store', $news->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Tiêu đề (không bắt buộc)</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Nội dung</label>
        <textarea name="content" id="content" rows="4" class="form-control">{{ old('content') }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Gửi bình luận</button>
</form>
