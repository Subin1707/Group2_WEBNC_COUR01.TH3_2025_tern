<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    /**
     * 📋 Hiển thị danh sách phim
     */
    public function index()
    {
        // Nếu chưa đăng nhập → chuyển về login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        // Lấy danh sách phim cho cả admin & user
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

        return view('movies.create');
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
            'description' => 'nullable|string',
            'poster'      => 'nullable|image|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        $posterPath = $request->hasFile('poster')
            ? $request->file('poster')->store('movies', 'public')
            : null;

        Movie::create([
            'title'       => $request->title,
            'description' => $request->description,
            'poster'      => $posterPath,
            'status'      => $request->status,
        ]);

        return redirect()->route('movies.index')->with('success', '🎬 Thêm phim thành công!');
    }

    /**
     * 👁️ Xem chi tiết phim (ai cũng xem được)
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
            'description' => 'nullable|string',
            'poster'      => 'nullable|image|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('poster')) {
            $movie->poster = $request->file('poster')->store('movies', 'public');
        }

        $movie->update([
            'title'       => $request->title,
            'description' => $request->description,
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

        $movie->delete();

        return redirect()->route('movies.index')->with('success', '🗑️ Đã xóa phim thành công!');
    }
}
