<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::with('permissions')->get();

        return view('superAdmin.role.role', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('role_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = Permission::get();

        return view('superAdmin.role.create_role', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('role_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name' => 'bail|required|unique:roles',
            'permissions' => 'bail|required',
        ]);

        $role = Role::create(['name' => $request->name]);
        $per = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($per);

        Artisan::call('permission:cache-reset');

        return redirect('role')->withStatus(__('Role Created Successfully..'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->user();
        abort_if(Gate::denies('role_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role = Role::with('permissions')->find($id);
        $permissions = Permission::get();

        return view('superAdmin.role.edit_role', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'permissions' => 'bail|required',
        ]);
        $role = Role::find($id);
        $per = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($per);

        Artisan::call('permission:cache-reset');

        return redirect('role')->withStatus(__('Role updated Successfully..'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role = Role::find($id);
        $role->delete();

        Artisan::call('permission:cache-reset');

        return response(['success' => true]);
    }
}
