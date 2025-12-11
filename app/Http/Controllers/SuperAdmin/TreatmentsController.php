<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Treatments;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TreatmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('treatment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $treats = Treatments::orderBy('id', 'DESC')->get();

        return view('superAdmin.treatments.treatments', compact('treats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('treatment_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('superAdmin.treatments.create_treatments');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:treatments',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = (new CustomController)->imageUpload($request->image);
        } else {
            $data['image'] = 'prod_default.png';
        }
        $data['status'] = $request->has('status') ? 1 : 0;
        Treatments::create($data);

        return redirect('treatments')->withStatus(__('Treatment created successfully..!!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Treatments $treatments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Treatments  $treatments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('treatment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $treatment = Treatments::find($id);

        return view('superAdmin.treatments.edit_treatments', compact('treatment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Treatments  $treatments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required|unique:treatments,name,'.$id.',id',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        $treat = Treatments::find($id);
        $request->validate([
            'name' => 'required',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            (new CustomController)->deleteFile($treat->image);
            $data['image'] = (new CustomController)->imageUpload($request->image);
        }
        $treat->update($data);

        return redirect('treatments')->withStatus(__('Treatment updated successfully..!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Treatments  $treatments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('treatment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (Doctor::where('treatment_id', $id)->exists()) {
            return response(['success' => false, 'msg' => 'This treatment is being used by one or more doctors! ']);
        } else {
            $treat = Treatments::find($id);
            (new CustomController)->deleteFile($treat->image);
            $treat->delete();

            return response(['success' => true]);
        }
    }

    public function change_status(Request $reqeust)
    {
        $treat = Treatments::find($reqeust->id);
        $data['status'] = $treat->status == 1 ? 0 : 1;
        $treat->update($data);

        return response(['success' => true]);
    }
}
