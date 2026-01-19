@extends('layouts.app')

@section('title', 'Quản lý nhân viên')

@section('content')
<div class="container mx-auto py-8 text-gray-200">

    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">👔 Quản lý nhân viên</h1>
        <a href="{{ route('admin.staffs.create') }}"
           class="bg-green-600 px-4 py-2 rounded hover:bg-green-700">
            ➕ Thêm nhân viên
        </a>
    </div>

    <table class="w-full bg-white/10 rounded">
        <thead>
            <tr class="text-left border-b border-white/20">
                <th class="p-3">Tên</th>
                <th>Email</th>
                <th class="p-3">Hành động</th>
            </tr>
        </thead>

        <tbody>
        @forelse($staffs as $staff)
            <tr class="border-t border-white/10">
                <td class="p-3">{{ $staff->name }}</td>
                <td>{{ $staff->email }}</td>
                <td class="p-3 space-x-3">

                    {{-- SỬA --}}
                    <a href="{{ route('admin.staffs.edit', $staff->id) }}"
                       class="text-blue-400 hover:underline">
                        ✏ Sửa
                    </a>

                    {{-- XOÁ --}}
                    <form class="inline"
                          action="{{ route('admin.staffs.destroy', $staff->id) }}"
                          method="POST"
                          onsubmit="return confirm('Bạn chắc chắn muốn xoá nhân viên này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:underline">
                            🗑 Xoá
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="p-4 text-center text-gray-400">
                    Chưa có nhân viên nào
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{-- PHÂN TRANG --}}
    <div class="mt-6">
        {{ $staffs->links() }}
    </div>

</div>
@endsection
