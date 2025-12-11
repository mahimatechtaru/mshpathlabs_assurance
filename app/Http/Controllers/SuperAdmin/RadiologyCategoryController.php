<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\RadiologyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RadiologyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('radiology_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $radiologyCategories = RadiologyCategory::orderBy('id', 'DESC')->get();

        return view('superAdmin.radiology_category.radiology_category', compact('radiologyCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('radiology_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('superAdmin.radiology_category.create_radiology_category');
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
        ]);
        $data = $request->all();
        $data['status'] = 1;
        RadiologyCategory::create($data);

        return redirect('/radiology_category')->withStatus(__('Radiology Category Created Successfully.!'));
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
        abort_if(Gate::denies('radiology_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $radiology_category = RadiologyCategory::find($id);

        return view('superAdmin.radiology_category.edit_radiology_category', compact('radiology_category'));
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
        ]);
        RadiologyCategory::find($id)->update($request->all());

        return redirect('/radiology_category')->withStatus(__('Radiology Category updated Successfully.!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RadiologyCategory::find($id)->delete();

        return ['success' => true];
    }

    public function change_status(Request $reqeust)
    {
        $radiology_category = RadiologyCategory::find($reqeust->id);
        $data['status'] = $radiology_category->status == 1 ? 0 : 1;
        $radiology_category->update($data);

        return response(['success' => true]);
    }
}
