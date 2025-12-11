<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Setting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('hospital_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $hospitals = Hospital::orderBy('id', 'DESC')->get();
        $center_coords = Setting::select('lat', 'lang')->first();

        return view('superAdmin.hospital.hospital', compact('hospitals', 'center_coords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('hospital_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $setting = Setting::first();

        return view('superAdmin.hospital.create_hospital', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:hospital|max:255',
            'phone' => 'bail|required|digits_between:6,12',
            'facility' => 'bail|required',
        ]);
        $data = $request->all();
        $data['status'] = 1;
        Hospital::create($data);

        return redirect('hospital')->withStatus(__('Hospital created successfully..!!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Hospital $hospital)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('hospital_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $hospital = Hospital::find($id);

        return view('superAdmin.hospital.edit_hospital', compact('hospital'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:hospital,name,'.$id.',id',
            'phone' => 'bail|required|digits_between:6,12',
            'facility' => 'bail|required',
            'address' => 'required',
        ]);
        $data = $request->all();
        $id = Hospital::find($id);
        $id->update($data);

        return redirect('hospital')->withStatus(__('Hospital updated successfully..!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctors = Doctor::get();
        foreach ($doctors as $value) {
            $hospital_id = explode(',', $value['hospital_id']);
            if (($key = array_search($id, $hospital_id)) !== false) {
                return response(['success' => false, 'data' => 'This hospital connected with Doctor.']);
            }
        }
        $id = Hospital::find($id);
        (new CustomController)->deleteFile($id->image);
        $id->delete();

        return response(['success' => true]);
    }

    public function change_status(Request $reqeust)
    {
        $hospital = Hospital::find($reqeust->id);
        $data['status'] = $hospital->status == 1 ? 0 : 1;
        $hospital->update($data);

        return response(['success' => true]);
    }
}
