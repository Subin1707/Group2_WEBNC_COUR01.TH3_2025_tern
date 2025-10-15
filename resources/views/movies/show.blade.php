@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $movie->title }}</h1>

    {{-- Hiển thị poster nếu có --}}
    @if($movie->poster)
        <img src="{{ asset('storage/' . $movie->poster) }}" 
             alt="{{ $movie->title }}" 
             class="img-fluid mb-3 rounded shadow">
    @endif

    {{-- Mô tả phim --}}
    <p>{{ $movie->description ?? 'Không có mô tả' }}</p>

    {{-- Thông tin chi tiết --}}
    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Thể loại:</strong> {{ $movie->genre ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Thời lượng:</strong> {{ $movie->duration ?? 'N/A' }} phút</li>
        <li class="list-group-item"><strong>Ngày tạo:</strong> {{ $movie->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Ngày cập nhật:</strong> {{ $movie->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}</li>
    </ul>

    {{-- Nút hành động --}}
    <div class="d-flex gap-2 mb-5">
        <a href="{{ route('movies.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>

        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-warning">✏️ Sửa</a>

            <form action="{{ route('admin.movies.destroy', $movie->id) }}" 
                  method="POST" 
                  onsubmit="return confirm('Bạn có chắc muốn xóa phim này không?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">🗑️ Xóa</button>
            </form>
        @endif
    </div>

    {{-- ================= COMMENTS ================= --}}
    <div class="blog_1l3 mt-4">
        <h3>Recent Comments ({{ $comments->total() ?? 0 }})</h3>
    </div>

    <div class="blog_1l5 mt-3">
        @forelse($comments as $comment)
            <div class="blog_1l5i row mb-3">
                <div class="col-md-2 col-2 pe-0">
                    <div class="blog_1l5il">
                        <img src="{{ asset('img/default_user.png') }}" class="w-100" alt="avatar">
                    </div>
                </div>
                <div class="col-md-10 col-10">
                    <div class="blog_1l5ir">
                        <h5>
                            <a href="#">{{ $comment->author?->name ?? 'Khách' }}</a>
                            <span class="font_14 col_light">/ {{ $comment->created_at->format('d/m/Y') }}</span>
                        </h5>
                        <p class="font_14"><strong>{{ $comment->title }}</strong><br>{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
            <hr>
        @empty
            <p>Chưa có bình luận nào.</p>
        @endforelse

        {{-- Phân trang --}}
        <div class="mt-3">
            {{ $comments->links() }}
        </div>
    </div>

    {{-- FORM COMMENT --}}
    <div class="blog_1l3 mt-4">
        <h3>Leave a Comment</h3>
    </div>
    <div class="blog_1l6 mt-3">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('movies.comments.store', $movie->id) }}" method="POST">
            @csrf
            {{-- Hidden để gửi movie_id --}}
            <input type="hidden" name="movies_id" value="{{ $movie->id }}">
            
            <div class="blog_1dt5 row mt-3">
                <div class="col-md-6">
                    <div class="blog_1dt5l">
                        <input name="title" value="{{ old('title') }}" class="form-control mb-3" placeholder="Title" type="text">
                        <textarea name="content" placeholder="Comment" class="form-control form_text" rows="5">{{ old('content') }}</textarea>
                        
                        <h6 class="mt-3 mb-0">
                            <button type="submit" class="button p-3 pt-2 pb-2">Comment</button>
                        </h6>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
