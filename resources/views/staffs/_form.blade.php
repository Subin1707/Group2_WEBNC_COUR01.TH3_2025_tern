@csrf

<div class="bg-white/10 p-6 rounded-xl shadow-md space-y-4">

    {{-- TÊN --}}
    <div>
        <label class="block mb-1">Tên nhân viên</label>
        <input
            type="text"
            name="name"
            value="{{ old('name', $staff->name ?? '') }}"
            class="w-full px-4 py-2 rounded bg-black text-white border border-gray-600"
            required
        >
        @error('name')
            <p class="text-red-400 text-sm">{{ $message }}</p>
        @enderror
    </div>

    {{-- EMAIL --}}
    <div>
        <label class="block mb-1">Email</label>
        <input
            type="email"
            name="email"
            value="{{ old('email', $staff->email ?? '') }}"
            class="w-full px-4 py-2 rounded bg-black text-white border border-gray-600"
            required
        >
        @error('email')
            <p class="text-red-400 text-sm">{{ $message }}</p>
        @enderror
    </div>

    {{-- PASSWORD --}}
    <div>
        <label class="block mb-1">
            Mật khẩu
            @isset($staff)
                <span class="text-sm text-gray-400">(bỏ trống nếu không đổi)</span>
            @endisset
        </label>
        <input
            type="password"
            name="password"
            class="w-full px-4 py-2 rounded bg-black text-white border border-gray-600"
            @unless(isset($staff)) required @endunless
        >
        @error('password')
            <p class="text-red-400 text-sm">{{ $message }}</p>
        @enderror
    </div>

    {{-- CONFIRM PASSWORD --}}
    <div>
        <label class="block mb-1">Nhập lại mật khẩu</label>
        <input
            type="password"
            name="password_confirmation"
            class="w-full px-4 py-2 rounded bg-black text-white border border-gray-600"
            @unless(isset($staff)) required @endunless
        >
    </div>

    {{-- ACTION --}}
    <div class="flex gap-3 mt-6">
        <button
            type="submit"
            class="bg-green-600 hover:bg-green-700 px-6 py-2 rounded text-white"
        >
            💾 Lưu
        </button>

        <a
            href="{{ route('admin.staffs.index') }}"
            class="bg-gray-600 hover:bg-gray-700 px-6 py-2 rounded text-white"
        >
            ⬅ Quay lại
        </a>
    </div>

</div>
