@extends('layouts.app')
@section('title', 'Thêm tin tức')
@section('content')
    <h1>Thêm tin tức mới</h1>
    <form action="{{ route('news.store') }}" method="POST">
        @csrf
        <label>Tiêu đề</label>
        <input type="text" name="title">
        <label>Nội dung</label>
        <textarea name="content"></textarea>

        <button type="submit">Lưu</button>
    </form>
@endsection
