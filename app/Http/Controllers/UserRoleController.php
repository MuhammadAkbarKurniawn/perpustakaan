<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserRoleController extends Controller
{
    // Menampilkan daftar pengguna dengan peran dan izin
    public function index()
    {
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.user_role.index', compact('users', 'roles', 'permissions'));
    }

    // Menampilkan form ubah peran dan izin
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.user_role.edit', compact('user', 'roles', 'permissions'));
    }

    // Menyimpan perubahan peran dan izin
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        // Update roles dan permissions
        $user->syncRoles($request->input('roles', []));
        $user->syncPermissions($request->input('permissions', []));

        return redirect()->route('admin.user_role.index')->with('success', 'Peran dan izin berhasil diperbarui.');
    }

    // (Opsional) Untuk form satu tombol assign role/izin (bukan form edit)
    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|string|exists:roles,name',
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
