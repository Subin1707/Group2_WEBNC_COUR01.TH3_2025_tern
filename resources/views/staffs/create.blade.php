@extends('layouts.app')

@section('title', 'Thêm nhân viên')

@section('content')
<div class="container mx-auto py-8 text-gray-200">
    <h1 class="text-xl font-bold mb-6">➕ Thêm nhân viên</h1>

    <form action="{{ route('admin.staffs.store') }}" method="POST">
        @include('staffs._form')
    </form>
</div>
@endsection
