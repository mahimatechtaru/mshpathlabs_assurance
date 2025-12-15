<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Package;
use App\Models\Setting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('package_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $packages = Package::orderBy('id', 'DESC')->get();
        return view('superAdmin.package.package', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('package_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $setting = Setting::first();

        return view('superAdmin.package.create_package', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:packages'
        ]);
        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;
        Package::create($data);

        return redirect('package')->withStatus(__('package created successfully..!!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('package_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $package = Package::find($id);

        return view('superAdmin.package.edit_package', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:packages,name,' . $id . ',id',
        ]);
        $data = $request->all();
        $id = Package::find($id);
        $id->update($data);

        return redirect('package')->withStatus(__('package updated successfully..!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Package::find($id);
        $id->delete();

        return response(['success' => true]);
    }

    public function change_status(Request $reqeust)
    {
        $package = Package::find($reqeust->id);
        $data['status'] = $package->status == 1 ? 0 : 1;
        $package->update($data);

        return response(['success' => true]);
    }

    public function package_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $insurer = Package::find($id);
            $insurer->delete();
        }

        return response(['success' => true]);
    }
}
