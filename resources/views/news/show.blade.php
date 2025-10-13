@extends("layouts.app1")
@section('content')
<div class="container">
    <h1>{{ $news->title }}</h1>
    <p>{{ $news->content }}</p>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @include('comment.form', ['news' => $news])

    <div class="card mt-4">
        <div class="card-body">
            @auth
                @include('comment.form', ['news' => $news])
            @else
                <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để bình luận.</p>
            @endauth
        </div>
    </div>
    @include('comment.list', ['comments' => $comments])
    <div class="d-flex justify-content-center mt-3">
        {{ $comments->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection