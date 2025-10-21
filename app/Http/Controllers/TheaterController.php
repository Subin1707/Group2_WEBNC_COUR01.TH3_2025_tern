<?php

namespace App\Http\Controllers;

use App\Models\Theater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TheaterController extends Controller
{
    // 📋 Danh sách rạp (Client và Admin)
    public function index(Request $request)
{
    // Lấy từ khóa tìm kiếm (nếu có)
    $search = $request->input('search');

    // Query cơ bản
    $query = Theater::query();

    // Nếu có từ khóa → lọc theo tên hoặc địa chỉ
    if (!empty($search)) {
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%");
        });
    }

    // Phân trang + giữ từ khóa khi chuyển trang
    $theaters = $query->latest()->paginate(10)->appends(['search' => $search]);

    // Trả về view (chung cho admin và user)
    return view('theaters.index', compact('theaters', 'search'));
}


    // 👁️ Chi tiết rạp
    public function show(Theater $theater)
    {
        return view('theaters.show', compact('theater'));
    }

    // ➕ Form thêm rạp (Admin)
    public function create()
    {
        $this->authorizeAdmin();
        return view('theaters.create');
    }

    // 💾 Lưu rạp mới (Admin)
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'total_rooms' => 'nullable|integer|min:0',
        ]);

        Theater::create([
            'name' => $request->name,
            'address' => $request->address,     // ✅ Giữ nguyên
            'total_rooms' => $request->total_rooms ?? 0,  // ✅ Nếu null → gán 0
        ]);

        return redirect()->route('admin.theaters.index')
                         ->with('success', '🎬 Thêm rạp thành công!');
    }

    // ✏️ Form sửa rạp (Admin)
    public function edit(Theater $theater)
    {
        $this->authorizeAdmin();
        return view('theaters.edit', compact('theater'));
    }

    // 🔄 Cập nhật (Admin)
    public function update(Request $request, Theater $theater)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'total_rooms' => 'nullable|integer|min:0',
        ]);

        $theater->update([
            'name' => $request->name,
            'address' => $request->address,     // ✅ Chính xác
            'total_rooms' => $request->total_rooms ?? 0, // ✅ Nếu trống → giữ 0
        ]);

        return redirect()->route('admin.theaters.index')
                         ->with('success', '✅ Cập nhật rạp thành công!');
    }

    // 🗑️ Xóa (Admin)
    public function destroy(Theater $theater)
    {
        $this->authorizeAdmin();

        $theater->delete();
        return redirect()->route('admin.theaters.index')
                         ->with('success', '🗑️ Xóa rạp thành công!');
    }

    // 🔒 Kiểm tra quyền admin
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }
    }
}
