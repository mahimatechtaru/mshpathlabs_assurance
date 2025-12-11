<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PathologyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PathologyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('pathology_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $pathologyCategories = PathologyCategory::orderBy('id', 'DESC')->get();

        return view('superAdmin.pathology_category.pathology_category', compact('pathologyCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('pathology_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('superAdmin.pathology_category.create_pathology_category');
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
        PathologyCategory::create($data);

        return redirect('/pathology_category')->withStatus(__('Pathology Category Created Successfully.!'));
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
        abort_if(Gate::denies('pathology_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $pathology_category = PathologyCategory::find($id);

        return view('superAdmin.pathology_category.edit_pathology_category', compact('pathology_category'));
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
        PathologyCategory::find($id)->update($request->all());

        return redirect('/pathology_category')->withStatus(__('Pathology Category Updated Successfully.!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PathologyCategory::find($id)->delete();

        return ['success' => true];
    }

    public function change_status(Request $reqeust)
    {
        $pathology_category = PathologyCategory::find($reqeust->id);
        $data['status'] = $pathology_category->status == 1 ? 0 : 1;
        $pathology_category->update($data);

        return response(['success' => true]);
    }
}
