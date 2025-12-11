<?php

namespace App\Http\Controllers\lab;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use App\Models\Pathology;
use App\Models\PathologyCategory;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PathologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('pathology_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (auth()->user()->hasRole('laboratory')) {
            $lab = Lab::where('user_id', auth()->user()->id)->first();
            $pathologies = Pathology::with('pathology_category')->where('lab_id', $lab->id)->orderBy('id', 'DESC')->get();
        } else {
            $lab = Lab::whereStatus(1)->get();
            $pathologies = Pathology::with(['pathology_category', 'lab'])->orderBy('id', 'DESC')->get();
        }

        return view('lab.pathology.pathology', compact('pathologies', 'lab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('pathology_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = PathologyCategory::whereStatus(1)->get();
        if (auth()->user()->hasRole('laboratory')) {
            $labs = Lab::where('user_id', auth()->user()->id)->first();
        } else {
            $labs = Lab::whereStatus(1)->get();
        }

        return view('lab.pathology.create_pathology', compact('categories', 'labs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('pathology_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (! auth()->user()->hasRole('laboratory')) {
            $request->validate([
                'lab_id' => 'bail|required',
            ]);
        }
        $request->validate([
            'report_days' => 'bail|required|numeric',
            'charge' => 'bail|required|numeric',
            'test_name' => 'bail|required',
            'method' => 'bail|required',
        ]);
        $data = $request->all();
        $data['status'] = 1;
        Pathology::create($data);

        return redirect('/pathology')->withStatus(__('Pathology Created Successfully.!'));
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
        abort_if(Gate::denies('pathology_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $pathology = Pathology::find($id);
        $categories = PathologyCategory::whereStatus(1)->get();
        if (auth()->user()->hasRole('laboratory')) {
            $labs = Lab::where('user_id', auth()->user()->id)->first();
        } else {
            $labs = Lab::whereStatus(1)->get();
        }

        return view('lab.pathology.edit_pathology', compact('pathology', 'labs', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('pathology_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (! auth()->user()->hasRole('laboratory')) {
            $request->validate([
                'lab_id' => 'bail|required',
            ]);
        }
        $request->validate([
            'report_days' => 'bail|required|numeric',
            'charge' => 'bail|required|numeric',
            'test_name' => 'bail|required',
            'method' => 'bail|required',
        ]);
        Pathology::find($id)->update($request->all());

        return redirect('/pathology')->withStatus(__('Pathology Updated Successfully.!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('pathology_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $pathology = Pathology::find($id);
        $reports = Report::where('lab_id', $pathology->lab_id)->get();
        foreach ($reports as $report) {
            $rs = explode(',', $report->pathology_id);
            if (in_array($id, $rs)) {
                $report->delete();
            }
        }
        $pathology->delete();

        return ['success' => true];
    }

    public function change_status(Request $reqeust)
    {
        abort_if(Gate::denies('pathology_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $pathology = Pathology::find($reqeust->id);
        $data['status'] = $pathology->status == 1 ? 0 : 1;
        $pathology->update($data);

        return response(['success' => true]);
    }
}
