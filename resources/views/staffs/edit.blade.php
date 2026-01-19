@extends('layouts.app')

@section('title', 'Sửa nhân viên')

@section('content')
<div class="container mx-auto py-8 text-gray-200">
    <h1 class="text-xl font-bold mb-6">✏️ Sửa nhân viên</h1>

    <form method="POST" action="{{ route('admin.staffs.update', $staff->id) }}">
        @method('PUT')
        @include('staffs._form', ['staff' => $staff])
    </form>
</div>
@endsection
