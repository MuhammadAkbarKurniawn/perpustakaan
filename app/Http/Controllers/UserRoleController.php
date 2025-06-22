<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::all();
        $permissions = Permission::all();

        // Diperbaiki path view-nya
        return view('admin.user_role.index', compact('users', 'roles', 'permissions'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role'    => 'nullable|string|exists:roles,name',
            'permission' => 'nullable|string|exists:permissions,name',
        ]);

        $user = User::findOrFail($request->user_id);

        if ($request->role) {
            $user->syncRoles([$request->role]);
        }

        if ($request->permission) {
            $user->givePermissionTo($request->permission);
        }

        return redirect()->route('admin.user_role.index')->with('success', 'Peran dan izin berhasil diperbarui.');
    }
}
