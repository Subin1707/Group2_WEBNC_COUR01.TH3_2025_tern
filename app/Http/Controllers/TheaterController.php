<?php

namespace App\Http\Controllers;

use App\Models\Theater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TheaterController extends Controller
{
    // 📋 Hiển thị danh sách rạp (Admin)
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $theaters = Theater::latest()->paginate(10);
        return view('admin.theaters.index', compact('theaters'));
    }

    // ➕ Form thêm rạp mới (Admin)
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền thêm rạp.');
        }

        return view('admin.theaters.create');
    }

    // 💾 Lưu rạp mới vào CSDL (Admin)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền thêm rạp.');
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        Theater::create([
            'name'    => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('theaters.index')->with('success', '🎬 Thêm rạp thành công!');
    }

    // 👁️ Xem chi tiết rạp (Admin)
    public function show(Theater $theater)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xem chi tiết rạp.');
        }

        return view('admin.theaters.show', compact('theater'));
    }

    // ✏️ Form chỉnh sửa rạp (Admin)
    public function edit(Theater $theater)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền chỉnh sửa rạp.');
        }

        return view('admin.theaters.edit', compact('theater'));
    }

    // 🔄 Cập nhật rạp (Admin)
    public function update(Request $request, Theater $theater)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền cập nhật rạp.');
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $theater->update([
            'name'    => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('theaters.index')->with('success', '✅ Cập nhật rạp thành công!');
    }

    // 🗑️ Xóa rạp (Admin)
    public function destroy(Theater $theater)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xóa rạp.');
        }

        $theater->delete();
        return redirect()->route('theaters.index')->with('success', '🗑️ Xóa rạp thành công!');
    }
}
