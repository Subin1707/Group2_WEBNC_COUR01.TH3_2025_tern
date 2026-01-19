@csrf

<div class="mb-4">
    <label class="block mb-1">Tên nhân viên</label>
    <input type="text" name="name"
        value="{{ old('name', $staff->name ?? '') }}"
        class="w-full px-4 py-2 rounded text-black" required>
</div>

<div class="mb-4">
    <label class="block mb-1">Email</label>
    <input type="email" name="email"
        value="{{ old('email', $staff->email ?? '') }}"
        class="w-full px-4 py-2 rounded text-black" required>
</div>

@if(!isset($staff))
<div class="mb-4">
    <label class="block mb-1">Mật khẩu</label>
    <input type="password" name="password"
        class="w-full px-4 py-2 rounded text-black" required>
</div>
@endif

<button class="bg-blue-600 px-6 py-2 rounded hover:bg-blue-700">
    Lưu
</button>
