<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\BulkDeleteRoleRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\HandlesBulkDeletion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class RoleController extends Controller
{
    use HandlesBulkDeletion;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.roles.index', [
            'roles' => Role::query()->withCount('permissions')->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permissions = Permission::options()->get();
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            return Str::before($permission->name, '.');
        });

        return view('admin.roles.form', [
            'role' => new Role,
            'rolePermissions' => [],
            'groupedPermissions' => $groupedPermissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $role = Role::query()->create($data);

            if (! empty($data['permissions'])) {
                $permissions = \App\Models\Permission::query()->whereIn('id', $data['permissions'])->pluck('name')->toArray();
                $role->syncPermissions($permissions);
            }

            return to_route('admin.roles.index')->with('success', __('role.messages.create_success'));
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return to_route('admin.roles.index')->with('error', __('role.messages.create_fail'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        $permissions = Permission::options()->get();
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            return Str::before($permission->name, '.');
        });
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.form', [
            'role' => $role,
            'rolePermissions' => $rolePermissions,
            'groupedPermissions' => $groupedPermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        try {
            $data = $request->validated();
            $role->update($data);

            if (! empty($data['permissions'])) {
                $permissions = \App\Models\Permission::query()->whereIn('id', $data['permissions'])->pluck('name')->toArray();
                $role->syncPermissions($permissions);
            } else {
                $role->syncPermissions([]);
            }

            return to_route('admin.roles.index')->with('success', __('role.messages.update_success'));
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return back()->with('error', __('role.messages.update_fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        try {
            $role->delete();

            return to_route('admin.roles.index')->with('success', __('role.messages.delete_success'));
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return back()->with('error', __('role.messages.delete_fail'));
        }
    }

    /**
     * Remove multiple the specified resource from storage.
     */
    public function bulkDelete(BulkDeleteRoleRequest $request): RedirectResponse
    {
        return $this->performBulkDeletion($request, Role::class);
    }
}
