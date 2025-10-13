<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Theater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * 📋 Hiển thị danh sách phòng chiếu
     */
    public function index()
    {
        // Chỉ admin mới được xem danh sách phòng
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $rooms = Room::with('theater')->latest()->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * ➕ Form thêm phòng chiếu mới
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền thêm phòng chiếu.');
        }

        $theaters = Theater::all();
        return view('admin.rooms.create', compact('theaters'));
    }

    /**
     * 💾 Lưu phòng chiếu mới vào CSDL
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền thêm phòng chiếu.');
        }

        $request->validate([
            'theater_id' => 'required|exists:theaters,id',
            'name'       => 'required|string|max:255',
            'capacity'   => 'required|integer|min:1',
        ]);

        Room::create([
            'theater_id' => $request->theater_id,
            'name'       => $request->name,
            'capacity'   => $request->capacity,
        ]);

        return redirect()->route('rooms.index')->with('success', '🎬 Thêm phòng chiếu thành công!');
    }

    /**
     * 👁️ Xem chi tiết phòng chiếu
     */
    public function show(Room $room)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xem chi tiết phòng chiếu.');
        }

        return view('admin.rooms.show', compact('room'));
    }

    /**
     * ✏️ Form chỉnh sửa phòng chiếu
     */
    public function edit(Room $room)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền chỉnh sửa phòng chiếu.');
        }

        $theaters = Theater::all();
        return view('admin.rooms.edit', compact('room', 'theaters'));
    }

    /**
     * 🔄 Cập nhật thông tin phòng chiếu
     */
    public function update(Request $request, Room $room)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền cập nhật phòng chiếu.');
        }

        $request->validate([
            'theater_id' => 'required|exists:theaters,id',
            'name'       => 'required|string|max:255',
            'capacity'   => 'required|integer|min:1',
        ]);

        $room->update([
            'theater_id' => $request->theater_id,
            'name'       => $request->name,
            'capacity'   => $request->capacity,
        ]);

        return redirect()->route('rooms.index')->with('success', '✅ Cập nhật phòng chiếu thành công!');
    }

    /**
     * 🗑️ Xóa phòng chiếu
     */
    public function destroy(Room $room)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xóa phòng chiếu.');
        }

        $room->delete();
        return redirect()->route('rooms.index')->with('success', '🗑️ Đã xóa phòng chiếu thành công!');
    }
}
