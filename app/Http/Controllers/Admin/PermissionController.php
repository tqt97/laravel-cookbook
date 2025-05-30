<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Throwable;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view(
            'admin.permissions.index',
            [
                'permissions' => Permission::query()->withCount('roles')->latest()->paginate(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.permissions.form', ['permission' => new Permission]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        try {
            Permission::query()->create($request->validated());

            return to_route('admin.permissions.index')->with('success', __('permission.messages.create_success'));
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return back()->withInput()->with('error', __('permission.messages.create_fail'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.form', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        try {
            $permission->update($request->validated());

            return to_route('admin.permissions.index')->with('success', __('permission.messages.update_success'));
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return back()->withInput()->with('error', __('permission.messages.update_fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();

            return to_route('admin.permissions.index')->with('success', __('permission.messages.delete_success'));
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return back()->with('error', __('permission.messages.delete_fail'));
        }
    }
}
