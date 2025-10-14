<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    // 📋 Hiển thị danh sách phim (client + admin)
    public function index()
    {
        $movies = Movie::latest()->paginate(10);
        return view('movies.index', compact('movies'));
    }

    // 👁️ Xem chi tiết phim
    public function show(Movie $movie)
    {
        return view('movies.show', compact('movie'));
    }

    // ➕ Form thêm phim mới (chỉ admin)
    public function create()
    {
        $this->authorizeAdmin();
        $movie = new Movie();
        return view('movies.create', compact('movie'));
    }

    // 💾 Lưu phim mới (chỉ admin)
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'genre'       => 'nullable|string|max:255',
            'duration'    => 'required|integer|min:1',
            'description' => 'nullable|string',
            'poster'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('movies', 'public');
        }

        Movie::create($data);

        return redirect()->route('admin.movies.index')->with('success', '🎬 Thêm phim thành công!');
    }

    // ✏️ Form chỉnh sửa phim (chỉ admin)
    public function edit(Movie $movie)
    {
        $this->authorizeAdmin();
        return view('movies.edit', compact('movie'));
    }

    // 🔄 Cập nhật phim (chỉ admin)
    public function update(Request $request, Movie $movie)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'genre'       => 'nullable|string|max:255',
            'duration'    => 'required|integer|min:1',
            'description' => 'nullable|string',
            'poster'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('poster')) {
            if ($movie->poster && Storage::disk('public')->exists($movie->poster)) {
                Storage::disk('public')->delete($movie->poster);
            }
            $data['poster'] = $request->file('poster')->store('movies', 'public');
        }

        $movie->update($data);

        return redirect()->route('admin.movies.index')->with('success', '✅ Cập nhật phim thành công!');
    }

    // 🗑️ Xóa phim (chỉ admin)
    public function destroy(Movie $movie)
    {
        $this->authorizeAdmin();

        if ($movie->poster && Storage::disk('public')->exists($movie->poster)) {
            Storage::disk('public')->delete($movie->poster);
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', '🗑️ Đã xóa phim thành công!');
    }

    // 🔒 Kiểm tra quyền admin
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }
}
