<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $roles = Role::with('permissionModels')->get();
        $permissions = Permission::all();

        return Inertia::render('Settings/Roles', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'required|string|max:191|unique:roles,slug',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'permissions' => json_encode([]),
        ]);

        if (!empty($data['permissions'])) {
            $role->permissionModels()->sync($data['permissions']);
        }

        return redirect()->back();
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:191',
            'slug' => 'sometimes|required|string|max:191|unique:roles,slug,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $role->update(array_intersect_key($data, array_flip(['name','slug'])));

        if (array_key_exists('permissions', $data)) {
            $role->permissionModels()->sync($data['permissions'] ?? []);
        }

        return redirect()->back();
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back();
    }
}
