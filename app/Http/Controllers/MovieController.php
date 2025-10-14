<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * 📋 Hiển thị danh sách phim
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $movies = Movie::latest()->paginate(10);
        return view('movies.index', compact('movies'));
    }

    /**
     * ➕ Form thêm phim mới (chỉ admin)
     */
    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('movies.index')->with('error', 'Bạn không có quyền truy cập.');
        }

        // ✅ Thêm dòng này để tránh lỗi "biến chưa xác định $movie" trong _form.blade.php
        $movie = new Movie();

        return view('movies.create', compact('movie'));
    }

    /**
     * 💾 Lưu phim mới (chỉ admin)
     */
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('movies.index')->with('error', 'Bạn không có quyền thêm phim.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'genre'       => 'nullable|string|max:255',
            'duration'    => 'required|integer|min:1',
            'description' => 'nullable|string',
            'poster'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        $posterPath = $request->hasFile('poster')
            ? $request->file('poster')->store('movies', 'public')
            : null;

        Movie::create([
            'title'       => $request->title,
            'genre'       => $request->genre,
            'duration'    => $request->duration,
            'description' => $request->description,
            'poster'      => $posterPath,
            'status'      => $request->status,
        ]);

        return redirect()->route('movies.index')->with('success', '🎬 Thêm phim thành công!');
    }

    /**
     * 👁️ Xem chi tiết phim
     */
    public function show(Movie $movie)
    {
        return view('movies.show', compact('movie'));
    }

    /**
     * ✏️ Form chỉnh sửa phim (chỉ admin)
     */
    public function edit(Movie $movie)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('movies.index')->with('error', 'Bạn không có quyền chỉnh sửa.');
        }

        return view('movies.edit', compact('movie'));
    }

    /**
     * 🔄 Cập nhật phim (chỉ admin)
     */
    public function update(Request $request, Movie $movie)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('movies.index')->with('error', 'Bạn không có quyền cập nhật.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'genre'       => 'nullable|string|max:255',
            'duration'    => 'required|integer|min:1',
            'description' => 'nullable|string',
            'poster'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        $posterPath = $movie->poster;

        // ✅ Xóa ảnh cũ nếu có ảnh mới
        if ($request->hasFile('poster')) {
            if ($posterPath && Storage::disk('public')->exists($posterPath)) {
                Storage::disk('public')->delete($posterPath);
            }
            $posterPath = $request->file('poster')->store('movies', 'public');
        }

        $movie->update([
            'title'       => $request->title,
            'genre'       => $request->genre,
            'duration'    => $request->duration,
            'description' => $request->description,
            'poster'      => $posterPath,
            'status'      => $request->status,
        ]);

        return redirect()->route('movies.index')->with('success', '✅ Cập nhật phim thành công!');
    }

    /**
     * 🗑️ Xóa phim (chỉ admin)
     */
    public function destroy(Movie $movie)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('movies.index')->with('error', 'Bạn không có quyền xóa phim.');
        }

        // ✅ Xóa poster cũ nếu có
        if ($movie->poster && Storage::disk('public')->exists($movie->poster)) {
            Storage::disk('public')->delete($movie->poster);
        }

        $movie->delete();

        return redirect()->route('movies.index')->with('success', '🗑️ Đã xóa phim thành công!');
    }
}
