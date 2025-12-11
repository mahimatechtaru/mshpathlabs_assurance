<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Artisan;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('admin_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::with('roles')->where('id', '!=', 1)->whereHas('roles', function ($query) {
            $query->whereNotIn('name', ['doctor', 'pharmacy', 'laboratory']);
        })->get();

        return view('superAdmin.admin_user.admin_user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('admin_user_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::whereNotIn('name', ['doctor', 'pharmacy', 'laboratory'])->get();
        $countries = Country::get();

        return view('superAdmin.admin_user.create_admin_user', compact('roles', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'phone_code' => 'bail|required',
            'phone' => 'bail|required|digits_between:6,12',
            'roles' => 'bail|required|array|max:1',
        ]);
        $data = $request->all();
        $data['image'] = 'defaultUser.png';
        $data['password'] = Hash::make($request->password);
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['verify'] = 1;
        $user = User::create($data);
        $user->assignRole($data['roles']);

        Artisan::call('permission:cache-reset');

        return redirect('admin_users')->withStatus(__('Users created successfully..!!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('admin_user_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::whereNotIn('name', ['doctor', 'pharmacy', 'laboratory'])->get();
        $countries = Country::get();
        $user = User::with('roles')->find($id);

        return view('superAdmin.admin_user.edit_admin_user', compact('roles', 'countries', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required',
            'phone_code' => 'bail|required',
            'phone' => 'bail|required|digits_between:6,12',
            'roles' => 'sometimes|array|max:1',
        ]);
        $data = $request->all();
        $data['image'] = 'defaultUser.png';
        $data['status'] = $request->has('status') ? 1 : 0;
        $user = User::find($id);
        $user->update($data);
        $user->syncRoles($data['roles']);

        Artisan::call('permission:cache-reset');

        return redirect('admin_users')->withStatus(__('Users created successfully..!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->syncRoles([]);
        (new CustomController)->deleteFile($user->image);
        $user->delete();

        return response(['success' => true]);
    }

    public function change_status(Request $reqeust)
    {
        $user = User::find($reqeust->id);
        $data['status'] = $user->status == 1 ? 0 : 1;
        $user->update($data);

        return response(['success' => true]);
    }
}
