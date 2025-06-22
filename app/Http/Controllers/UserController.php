<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Menampilkan daftar semua user
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    // Menampilkan form tambah user
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // Menyimpan user baru
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!empty($validated['role'])) {
            $user->assignRole($validated['role']);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Menampilkan form edit user
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRole = $user->roles->pluck('name')->first();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    // Update user
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if (!empty($validated['role'])) {
            $user->syncRoles([$validated['role']]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
    
    // app/Http/Controllers/UserController.php
    public function borrowings($userId)
    {
        $user = \App\Models\User::with('lendings.book')->findOrFail($userId);
        return view('users.borrowings', compact('user'));
    }

}
