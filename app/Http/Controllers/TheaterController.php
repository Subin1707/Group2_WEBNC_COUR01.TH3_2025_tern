<?php

namespace App\Http\Controllers;

use App\Models\Theater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TheaterController extends Controller
{
    // 📋 Danh sách rạp (Client và Admin)
    public function index()
    {
        $theaters = Theater::latest()->paginate(10);

        // Nếu là admin → hiển thị view quản trị
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('theaters.index', compact('theaters'));
        }

        // Nếu là khách hoặc người dùng → vẫn dùng cùng view, nhưng ẩn nút CRUD
        return view('theaters.index', compact('theaters'));
    }

    // 👁️ Chi tiết rạp (Client + Admin)
    public function show(Theater $theater)
    {
        return view('theaters.show', compact('theater'));
    }

    // ➕ Form thêm rạp (chỉ Admin)
    public function create()
    {
        $this->authorizeAdmin();
        return view('theaters.create');
    }

    // 💾 Lưu rạp mới (chỉ Admin)
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:500',
            'total_rooms' => 'nullable|integer|min:0',
        ]);

        Theater::create($request->only('name', 'location', 'total_rooms'));

        return redirect()->route('admin.theaters.index')->with('success', '🎬 Thêm rạp thành công!');
    }

    // ✏️ Form sửa rạp (chỉ Admin)
    public function edit(Theater $theater)
    {
        $this->authorizeAdmin();
        return view('theaters.edit', compact('theater'));
    }

    // 🔄 Cập nhật (chỉ Admin)
    public function update(Request $request, Theater $theater)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:500',
            'total_rooms' => 'nullable|integer|min:0',
        ]);

        $theater->update($request->only('name', 'location', 'total_rooms'));

        return redirect()->route('admin.theaters.index')->with('success', '✅ Cập nhật rạp thành công!');
    }

    // 🗑️ Xóa (chỉ Admin)
    public function destroy(Theater $theater)
    {
        $this->authorizeAdmin();

        $theater->delete();
        return redirect()->route('admin.theaters.index')->with('success', '🗑️ Xóa rạp thành công!');
    }

    // 🔒 Kiểm tra quyền admin
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }
    }
}
