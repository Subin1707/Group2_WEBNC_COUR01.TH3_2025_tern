@extends('layouts.app')
@section('title', 'Danh sách tin tức')
@section('content')
    <h1>Danh sách tin tức</h1>
    @auth
    <a href="{{ route('news.create') }}">Thêm tin tức mới</a>
    @endauth
    <ul>
        @foreach($news as $item)
            <li>
                <a href="{{ route('news.show', $item->id) }}">{{ $item->title }}</a>
                @auth
                @if(auth()->check() &&auth()->user()->role ==='admin')
                <a href="{{ route('news.edit', $item->id) }}">Chỉnh sửa</a>
                <form action="{{ route('news.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" >Xóa</button>
                </form>
                @endif
                @endauth
            </li>
        @endforeach
    </ul>
    <div>
        {{ $news->links() }}
    </div>
@endsection
