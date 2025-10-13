<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    /**
     * 📋 Hiển thị danh sách phim (Admin)
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $movies = Movie::latest()->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    /**
     * ➕ Form thêm phim mới
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền thêm phim.');
        }

        return view('admin.movies.create');
    }

    /**
     * 💾 Lưu phim mới vào CSDL
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền thêm phim.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster'      => 'nullable|image|max:2048', // poster optional
            'status'      => 'required|in:active,inactive',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('movies', 'public');
        }

        Movie::create([
            'title'       => $request->title,
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
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xem chi tiết phim.');
        }

        return view('admin.movies.show', compact('movie'));
    }

    /**
     * ✏️ Form chỉnh sửa phim
     */
    public function edit(Movie $movie)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền chỉnh sửa phim.');
        }

        return view('admin.movies.edit', compact('movie'));
    }

    /**
     * 🔄 Cập nhật thông tin phim
     */
    public function update(Request $request, Movie $movie)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền cập nhật phim.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster'      => 'nullable|image|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('movies', 'public');
            $movie->poster = $posterPath;
        }

        $movie->title       = $request->title;
        $movie->description = $request->description;
        $movie->status      = $request->status;
        $movie->save();

        return redirect()->route('movies.index')->with('success', '✅ Cập nhật phim thành công!');
    }

    /**
     * 🗑️ Xóa phim
     */
    public function destroy(Movie $movie)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xóa phim.');
        }

        $movie->delete();
        return redirect()->route('movies.index')->with('success', '🗑️ Đã xóa phim thành công!');
    }
}
