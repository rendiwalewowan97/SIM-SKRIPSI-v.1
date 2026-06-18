<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $items = User::query()
            ->when($request->role, fn($q, $v) => $q->where('role', $v))
            ->when($request->position, fn($q, $v) => $q->where('position', $v))
            ->when($request->q, fn($q, $v) => $q->where(function ($qq) use ($v) {
                $qq->where('name', 'like', "%$v%")
                    ->orWhere('email', 'like', "%$v%")
                    ->orWhere('identifier', 'like', "%$v%");
            }))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('items'));
    }

    public function create()
    {
        return view('users.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'role'       => 'required|in:mahasiswa,dosen,jurusan',
            'position'    => 'nullable|in:ketua_jurusan',
            'identifier' => 'nullable|string|max:50',
            'phone'      => 'nullable|string|max:30',
            'password'   => 'required|min:6',
        ]);

        if ($data['role'] !== 'dosen') {
            $data['position'] = null;
        }

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'role'       => 'required|in:mahasiswa,dosen,jurusan',
            'position'    => 'nullable|in:ketua_jurusan',
            'identifier' => 'nullable|string|max:50',
            'phone'      => 'nullable|string|max:30',
            'password'   => 'nullable|min:6',
        ]);

        if ($data['role'] !== 'dosen') {
            $data['position'] = null;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_if($user->id === auth()->id(), 422, 'Tidak bisa menghapus akun sendiri.');
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
