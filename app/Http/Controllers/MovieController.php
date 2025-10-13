<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        // Hiển thị danh sách phim
        return view('admin.movies.index');
    }

    public function create()
    {
        // Form tạo phim mới
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        // Xử lý lưu phim mới
        // Movie::create($request->all());
        return redirect()->route('movies.index')->with('success', 'Thêm phim thành công!');
    }

    public function show($id)
    {
        // Hiển thị chi tiết phim
        return view('admin.movies.show', compact('id'));
    }

    public function edit($id)
    {
        // Form sửa phim
        return view('admin.movies.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Cập nhật thông tin phim
        // Movie::findOrFail($id)->update($request->all());
        return redirect()->route('movies.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        // Xóa phim
        // Movie::destroy($id);
        return redirect()->route('movies.index')->with('success', 'Xóa phim thành công!');
    }

    public function home()
    {
        // Trang chủ người dùng
        return view('client.home');
    }
}
