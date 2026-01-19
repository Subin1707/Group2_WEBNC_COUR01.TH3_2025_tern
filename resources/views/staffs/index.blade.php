@extends('layouts.app')

@section('title', 'Quản lý nhân viên')

@section('content')
<div class="max-w-6xl mx-auto py-10 text-gray-200">

    {{-- CARD --}}
    <div class="bg-gray-900 rounded-xl shadow-lg border border-gray-700">

        {{-- HEADER --}}
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700">
            <h1 class="text-xl font-bold flex items-center gap-2">
                👔 Quản lý nhân viên
            </h1>

            <a href="{{ route('admin.staffs.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                + Thêm nhân viên
            </a>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-800 text-gray-300 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-left">Tên</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffs as $staff)
                        <tr class="border-t border-gray-700 hover:bg-gray-800 transition">
                            <td class="px-6 py-4 font-medium">
                                {{ $staff->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-400">
                                {{ $staff->email }}
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">

                                <a href="{{ route('admin.staffs.edit', $staff) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-xs transition">
                                    ✏ Sửa
                                </a>

                                <form action="{{ route('admin.staffs.destroy', $staff) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Bạn chắc chắn muốn xoá nhân viên này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs transition">
                                        🗑 Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-gray-400">
                                Chưa có nhân viên nào
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-4 border-t border-gray-700">
            {{ $staffs->links() }}
        </div>

    </div>
</div>
@endsection
