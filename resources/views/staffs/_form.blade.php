@csrf

<div class="bg-gray-900 rounded-xl shadow-lg border border-gray-700 p-6 space-y-5">

    <div>
        <label class="block text-sm mb-1">Tên nhân viên</label>
        <input type="text" name="name"
               value="{{ old('name', $staff->name ?? '') }}"
               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring focus:ring-blue-500">
    </div>

    <div>
        <label class="block text-sm mb-1">Email</label>
        <input type="email" name="email"
               value="{{ old('email', $staff->email ?? '') }}"
               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring focus:ring-blue-500">
    </div>

    <div>
        <label class="block text-sm mb-1">
            Mật khẩu {{ isset($staff) ? '(để trống nếu không đổi)' : '' }}
        </label>
        <input type="password" name="password"
               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white">
    </div>

    <div>
        <label class="block text-sm mb-1">Xác nhận mật khẩu</label>
        <input type="password" name="password_confirmation"
               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white">
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.staffs.index') }}"
           class="px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-sm">
            Huỷ
        </a>
        <button type="submit"
                class="px-5 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-semibold">
            💾 Lưu lại
        </button>
    </div>

</div>
