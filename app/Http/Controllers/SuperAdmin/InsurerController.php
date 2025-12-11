<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Insurer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InsurerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('insurer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $insurers = Insurer::orderBy('id', 'DESC')->get();

        return view('superAdmin.insurers.insurers', compact('insurers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('insurer_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('superAdmin.insurers.create_insurers');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:insurers',
        ]);

        $data = $request->all();
        $data = $request->except('_token');
        $data['status'] = $request->has('status') ? 1 : 0;
        Insurer::create($data);

        return redirect('insurers')->withStatus(__('Insurer created successfully..!!'));
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
        abort_if(Gate::denies('insurer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $insurer = Insurer::find($id);

        return view('superAdmin.insurers.edit_insurers', compact('insurer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $insurer = Insurer::find($id);
        $request->validate([
            'name' => 'required',
        ]);
        $data = $request->all();
        $insurer->update($data);

        return redirect('insurers')->withStatus(__('Insurer updated successfully..!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('insurer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $insurer = Insurer::find($id);
        $insurer->delete();

        return response(['success' => true]);
    }

    public function change_status(Request $reqeust)
    {
        $insurer = Insurer::find($reqeust->id);
        $data['status'] = $insurer->status == 1 ? 0 : 1;
        $insurer->update($data);

        return response(['success' => true]);
    }

    public function insurer_all_delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $insurer = Insurer::find($id);
            $insurer->delete();
        }

        return response(['success' => true]);
    }
}
