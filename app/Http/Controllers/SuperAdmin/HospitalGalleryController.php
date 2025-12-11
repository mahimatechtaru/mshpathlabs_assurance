<?php

namespace App\Http\Controllers\superAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SuperAdmin\CustomController;
use App\Models\Hospital;
use App\Models\HospitalGallery;
use Illuminate\Http\Request;

class HospitalGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($hospital_id)
    {
        $hospital = Hospital::find($hospital_id);
        $galleries = HospitalGallery::where('hospital_id', $hospital_id)->get();

        return view('superAdmin.hospital.hospital_gallery', compact('hospital', 'galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['hospital_id'] = $request->hospital_id;
        $file = $request->file('file');
        if ($request->hasFile('file')) {
            $data['image'] = (new CustomController)->imageUpload($request->file);
        }
        $hospital = HospitalGallery::create($data);

        return response()->json(['success' => $file->getClientOriginalName()]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = HospitalGallery::find($id);
        (new CustomController)->deleteFile($id->image);
        $id->delete();

        return response(['success' => true]);
    }
}
