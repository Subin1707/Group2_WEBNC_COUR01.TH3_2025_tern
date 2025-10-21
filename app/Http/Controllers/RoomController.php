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
        $rooms = Room::with('theater')->latest()->paginate(10);
        $user = Auth::user(); // lấy thông tin user để phân quyền trong view

        
        return view('rooms.index', compact('rooms', 'user'));
    }

    /**
     * ➕ Form thêm phòng chiếu mới (Admin only)
     */
    public function create()
    {
        $this->authorizeAdmin();

        $theaters = Theater::all();
        return view('rooms.create', compact('theaters'));
    }

    /**
     * 💾 Lưu phòng chiếu mới (Admin only)
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'theater_id' => 'required|exists:theaters,id',
            'name'       => 'required|string|max:255',
            'capacity'   => 'required|integer|min:1',
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms.index')->with('success', '🎬 Thêm phòng chiếu thành công!');
    }

    /**
     * 👁️ Xem chi tiết phòng chiếu
     */
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    /**
     * ✏️ Form chỉnh sửa phòng chiếu (Admin only)
     */
    public function edit(Room $room)
    {
        $this->authorizeAdmin();
        $theaters = Theater::all();
        return view('rooms.edit', compact('room', 'theaters'));
    }

    /**
     * 🔄 Cập nhật phòng chiếu (Admin only)
     */
    public function update(Request $request, Room $room)
    {
        $this->authorizeAdmin();

        $request->validate([
            'theater_id' => 'required|exists:theaters,id',
            'name'       => 'required|string|max:255',
            'capacity'   => 'required|integer|min:1',
        ]);

        $room->update($request->all());

        return redirect()->route('admin.rooms.index')->with('success', '✅ Cập nhật thành công!');
    }

    /**
     * 🗑️ Xóa phòng chiếu (Admin only)
     */
    public function destroy(Room $room)
    {
        $this->authorizeAdmin();
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', '🗑️ Xóa thành công!');
    }

    /**
     * 🛡️ Kiểm tra quyền admin
     */
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, '🚫 Bạn không có quyền thực hiện thao tác này.');
        }
    }
}
