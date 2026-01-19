@extends('layouts.app')

@section('title', 'Quản lý nhân viên')

@section('content')
<div class="container mx-auto py-8 text-gray-200">

    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">👔 Nhân viên</h1>
        <a href="{{ route('admin.staffs.create') }}"
           class="bg-green-600 px-4 py-2 rounded">
            + Thêm nhân viên
        </a>
    </div>

    <table class="w-full bg-white/10 rounded">
        <thead>
            <tr class="text-left">
                <th class="p-3">Tên</th>
                <th>Email</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        @foreach($staffs as $staff)
            <tr class="border-t border-white/10">
                <td class="p-3">{{ $staff->name }}</td>
                <td>{{ $staff->email }}</td>
                <td class="space-x-2">
                    <a href="{{ route('admin.staffs.show', $staff) }}">👁</a>
                    <a href="{{ route('admin.staffs.edit', $staff) }}">✏</a>
                    <form class="inline"
                          action="{{ route('admin.staffs.destroy', $staff) }}"
                          method="POST">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Xoá nhân viên?')">🗑</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
@endsection
