<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TheaterController extends Controller
{
    public function index()
    {
        return view('admin.theaters.index');
    }

    public function create()
    {
        return view('admin.theaters.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('theaters.index')->with('success', 'Thêm rạp thành công!');
    }

    public function show($id)
    {
        return view('admin.theaters.show', compact('id'));
    }

    public function edit($id)
    {
        return view('admin.theaters.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('theaters.index')->with('success', 'Cập nhật rạp thành công!');
    }

    public function destroy($id)
    {
        return redirect()->route('theaters.index')->with('success', 'Xóa rạp thành công!');
    }
}
