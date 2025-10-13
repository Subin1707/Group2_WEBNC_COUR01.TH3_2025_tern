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
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        $theaters = Theater::latest()->paginate(10);
        return view('admin.theaters.index', compact('theaters'));
    }

    // ➕ Form thêm rạp mới (Admin)
    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        return view('admin.theaters.create');
    }

    // 💾 Lưu rạp mới vào CSDL (Admin)
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
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
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        return view('admin.theaters.show', compact('theater'));
    }

    // ✏️ Form chỉnh sửa rạp (Admin)
    public function edit(Theater $theater)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        return view('admin.theaters.edit', compact('theater'));
    }

    // 🔄 Cập nhật rạp (Admin)
    public function update(Request $request, Theater $theater)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
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
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập bằng tài khoản quản trị.');
        }

        $theater->delete();
        return redirect()->route('theaters.index')->with('success', '🗑️ Xóa rạp thành công!');
    }
}
