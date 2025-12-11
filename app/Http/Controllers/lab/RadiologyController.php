<?php

namespace App\Http\Controllers\lab;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use App\Models\Radiology;
use App\Models\RadiologyCategory;
use App\Models\Report;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RadiologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('radiology_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (auth()->user()->hasRole('laboratory')) {
            $lab = Lab::where('user_id', auth()->user()->id)->first();
            $radiologies = Radiology::with('radiology_category')->where('lab_id', $lab->id)->orderBy('id', 'DESC')->get();
        } else {
            $lab = Lab::whereStatus(1)->get();
            $radiologies = Radiology::with('radiology_category')->orderBy('id', 'DESC')->get();
        }
        $currency = Setting::first()->currency_symbol;

        return view('lab.radiology.radiology', compact('radiologies', 'currency', 'lab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('radiology_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = RadiologyCategory::whereStatus(1)->get();
        if (auth()->user()->hasRole('laboratory')) {
            $labs = Lab::where('user_id', auth()->user()->id)->first();
        } else {
            $labs = Lab::whereStatus(1)->get();
        }

        return view('lab.radiology.create_radiology', compact('categories', 'labs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('radiology_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (! auth()->user()->hasRole('laboratory')) {
            $request->validate([
                'lab_id' => 'bail|required',
            ]);
        }
        $request->validate([
            'radiology_category_id' => 'bail|required',
            'charge' => 'bail|required|numeric',
            'report_days' => 'bail|required|numeric',
        ]);
        $data = $request->all();
        $data['status'] = 1;
        Radiology::create($data);

        return redirect('/radiology')->withStatus(__('Radiology Created Successfully.!'));
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
        abort_if(Gate::denies('radiology_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = RadiologyCategory::whereStatus(1)->get();
        $radiology = Radiology::find($id);
        if (! auth()->user()->hasRole('laboratory')) {
            $labs = Lab::whereStatus(1)->get();
        } else {
            $labs = Lab::where('user_id', auth()->user()->id)->first();
        }

        return view('lab.radiology.edit_radiology', compact('categories', 'radiology', 'labs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('radiology_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (! auth()->user()->hasRole('laboratory')) {
            $request->validate([
                'lab_id' => 'bail|required',
            ]);
        }
        $request->validate([
            'radiology_category_id' => 'bail|required',
            'charge' => 'bail|required|numeric',
            'report_days' => 'bail|required|numeric',
        ]);
        Radiology::find($id)->update($request->all());

        return redirect('/radiology')->withStatus(__('Radiology Updated Successfully.!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('radiology_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $radiology = Radiology::find($id);
        $reports = Report::where('lab_id', $radiology->lab_id)->get();
        foreach ($reports as $report) {
            $rs = explode(',', $report->radiology_id);
            if (in_array($id, $rs)) {
                $report->delete();
            }
        }
        $radiology->delete();

        return ['success' => true];
    }

    public function change_status(Request $reqeust)
    {
        abort_if(Gate::denies('radiology_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $radiology = Radiology::find($reqeust->id);
        $data['status'] = $radiology->status == 1 ? 0 : 1;
        $radiology->update($data);

        return response(['success' => true]);
    }
}
