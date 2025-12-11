<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\MedicineCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MedicineCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('medicine_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $medicineCategories = MedicineCategory::orderBy('id', 'DESC')->get();

        return view('superAdmin.medicine_category.medicine_category', compact('medicineCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('medicine_category_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('superAdmin.medicine_category.create_medicine_category');
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
        $data['status'] = $request->has('status') ? 1 : 0;
        MedicineCategory::create($data);

        return redirect('medicineCategory')->with(__('Menu category Created Successfully...!!'));
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
        abort_if(Gate::denies('medicine_category_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $medicineCategory = MedicineCategory::find($id);

        return view('superAdmin.medicine_category.edit_medicine_category', compact('medicineCategory'));
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
        $data = $request->all();
        MedicineCategory::find($id)->update($data);

        return redirect('medicineCategory')->with(__('Menu category updated Successfully...!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medicineCategory = MedicineCategory::find($id);
        $medicineCategory->delete();

        return response(['success' => true]);

    }

    public function change_status(Request $reqeust)
    {
        $medicineCategory = MedicineCategory::find($reqeust->id);
        $data['status'] = $medicineCategory->status == 1 ? 0 : 1;
        $medicineCategory->update($data);

        return response(['success' => true]);
    }
}
