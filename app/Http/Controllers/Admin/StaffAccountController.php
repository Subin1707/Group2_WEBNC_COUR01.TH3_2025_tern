<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffAccountController extends Controller
{
    public function index()
    {
        $staffs = User::where('role', 'staff')->paginate(10);
        return view('staffs.index', compact('staffs'));
    }

    public function create()
    {
        return view('staffs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        return redirect()->route('staffs.index')
            ->with('success', 'Tạo tài khoản nhân viên thành công');
    }

    public function edit(User $staff)
    {
        abort_if($staff->role !== 'staff', 404);
        return view('staffs.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        abort_if($staff->role !== 'staff', 404);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $staff->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('staffs.index')
            ->with('success', 'Cập nhật tài khoản thành công');
    }

    public function destroy(User $staff)
    {
        abort_if($staff->role !== 'staff', 404);

        if (Auth::id() === $staff->id) {
            return back()->withErrors('Không thể xoá chính bạn');
        }

        $staff->delete();

        return redirect()->route('staffs.index')
            ->with('success', 'Xoá nhân viên thành công');
    }
}
