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
        $search = request('search');
        if ($search) {
            $movies = Movie::where('title', 'like', '%' . $search . '%')
                           ->orWhere('genre', 'like', '%' . $search . '%')
                           ->latest()
                           ->paginate(10);
        } else {
            $movies = Movie::latest()->paginate(16);
        }
        return view('movies.index', compact('movies'));
    }

    // 👁️ Xem chi tiết phim
    public function show(Movie $movie)
    {
        $movie = Movie::with('comments.author')->findOrFail($movie->id);
        $comments = $movie->comments()->with('author')->latest()->paginate(10);
        return view('movies.show', compact('movie', 'comments'));
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

    // 🔹 Nếu có upload ảnh
    if ($request->hasFile('poster')) {
        $file = $request->file('poster');

        // Tạo tên file duy nhất
        $filename = time() . '_' . $file->getClientOriginalName();

        // Lưu file vào thư mục public/img
        $file->move(public_path('img'), $filename);

        // Lưu đường dẫn vào database
        $data['poster'] = 'img/' . $filename;
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

        // Nếu có upload ảnh mới
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img'), $filename);

            // Xóa ảnh cũ nếu có
            if ($movie->poster && file_exists(public_path($movie->poster))) {
                unlink(public_path($movie->poster));
            }

            // Lưu đường dẫn ảnh mới vào DB
            $data['poster'] = 'img/' . $filename;
        }

        // Cập nhật phim
        $movie->update($data);

        return redirect()->route('admin.movies.index')->with('success', '✅ Cập nhật phim thành công!');
    }

    public function destroy(Movie $movie)
    {
        $this->authorizeAdmin();

        // Xóa ảnh trong thư mục public/img (nếu có)
        if ($movie->poster && file_exists(public_path($movie->poster))) {
            unlink(public_path($movie->poster));
        }

        // Xóa phim khỏi database
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
    public function comments(Movie $movie)
    {
        $comments = $movie->comments()->with('author')->latest()->paginate(10);
        return view('movies.comments', compact('movie', 'comments'));
    }
}
