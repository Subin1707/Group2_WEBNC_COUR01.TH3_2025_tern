@extends('layouts.app')

@section('title', 'Quản lý nhân viên')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 text-gray-100">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">
                👔 Quản lý nhân viên
            </h1>
            <p class="text-gray-400 text-sm mt-1">
                Tạo, chỉnh sửa và quản lý tài khoản nhân viên hệ thống
            </p>
        </div>

        <a href="{{ route('admin.staffs.create') }}"
           class="flex items-center gap-2 px-5 py-3 rounded-xl
                  bg-gradient-to-r from-green-500 to-emerald-600
                  hover:from-green-600 hover:to-emerald-700
                  shadow-lg shadow-green-900/40
                  text-white font-semibold transition-all">
            ➕ Thêm nhân viên
        </a>
    </div>

    {{-- CARD --}}
    <div class="backdrop-blur-xl bg-white/5 border border-white/10
                rounded-2xl shadow-2xl overflow-hidden">

        {{-- TABLE --}}
        <table class="w-full">
            <thead>
                <tr class="bg-white/10 text-gray-300 text-sm">
                    <th class="px-8 py-5 text-left">Nhân viên</th>
                    <th class="px-8 py-5 text-left">Email</th>
                    <th class="px-8 py-5 text-center">Hành động</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/10">
                @forelse($staffs as $staff)
                    <tr class="hover:bg-white/5 transition">

                        {{-- NAME --}}
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full
                                            bg-gradient-to-br from-blue-500 to-purple-600
                                            flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($staff->name,0,1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold">
                                        {{ $staff->name }}
                                    </p>
                                    <span class="text-xs text-green-400">
                                        Nhân viên
                                    </span>
                                </div>
                            </div>
                        </td>

                        {{-- EMAIL --}}
                        <td class="px-8 py-6 text-gray-400">
                            {{ $staff->email }}
                        </td>

                        {{-- ACTION --}}
                        <td class="px-8 py-6 text-center space-x-2">

                            <a href="{{ route('admin.staffs.edit', $staff) }}"
                               class="inline-flex items-center gap-1
                                      px-4 py-2 rounded-lg
                                      bg-blue-600/20 text-blue-400
                                      hover:bg-blue-600 hover:text-white
                                      transition">
                                ✏ Sửa
                            </a>

                            <form action="{{ route('admin.staffs.destroy', $staff) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Bạn chắc chắn muốn xoá nhân viên này?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="inline-flex items-center gap-1
                                           px-4 py-2 rounded-lg
                                           bg-red-600/20 text-red-400
                                           hover:bg-red-600 hover:text-white
                                           transition">
                                    🗑 Xoá
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3"
                            class="px-8 py-12 text-center text-gray-400">
                            Chưa có nhân viên nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- FOOTER --}}
        <div class="px-8 py-4 bg-white/5 border-t border-white/10">
            {{ $staffs->links() }}
        </div>
    </div>
</div>
@endsection
