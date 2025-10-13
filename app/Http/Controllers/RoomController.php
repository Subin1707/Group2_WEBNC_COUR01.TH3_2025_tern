<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Theater;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // 📋 Danh sách phòng chiếu
    public function index()
    {
        $rooms = Room::with('theater')->latest()->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    // ➕ Form thêm
    public function create()
    {
        $theaters = Theater::all();
        return view('admin.rooms.create', compact('theaters'));
    }

    // 💾 Lưu phòng mới
    public function store(Request $request)
    {
        $request->validate([
            'theater_id'  => 'required|exists:theaters,id',
            'name'        => 'required|string|max:255',
            'seats_count' => 'required|integer|min:1',
        ]);

        Room::create($request->all());
        return redirect()->route('rooms.index')->with('success', '🎬 Thêm phòng chiếu thành công!');
    }

    // 👁️ Xem chi tiết
    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    // ✏️ Form sửa
    public function edit(Room $room)
    {
        $theaters = Theater::all();
        return view('admin.rooms.edit', compact('room', 'theaters'));
    }

    // 🔄 Cập nhật
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'theater_id'  => 'required|exists:theaters,id',
            'name'        => 'required|string|max:255',
            'seats_count' => 'required|integer|min:1',
        ]);

        $room->update($request->all());
        return redirect()->route('rooms.index')->with('success', '✅ Cập nhật phòng chiếu thành công!');
    }

    // 🗑️ Xóa
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', '🗑️ Xóa phòng chiếu thành công!');
    }
}
