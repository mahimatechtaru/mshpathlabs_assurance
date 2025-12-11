<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\Expertise;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('expertise_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $expertises = Expertise::with('category')->orderBy('id', 'DESC')->get();

        return view('superAdmin.expertise.expertise', compact('expertises'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('expertise_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::whereStatus(1)->orderBy('id', 'DESC')->get();

        return view('superAdmin.expertise.create_expertise', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:expertise',
            'category_id' => 'bail|required',
        ]);
        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;
        Expertise::create($data);

        return redirect('expertise')->withStatus(__('Expertise created successfully...!!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Expertise $expertise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('expertise_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $expertise = Expertise::find($id);
        $categories = Category::whereStatus(1)->orderBy('id', 'DESC')->get();

        return view('superAdmin.expertise.edit_expertise', compact('categories', 'expertise'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required|unique:expertise,name,'.$id.',id',
            'category_id' => 'bail|required',
        ]);
        $data = $request->all();
        $id = Expertise::find($id);
        $id->update($data);

        return redirect('expertise')->withStatus(__('Expertise updated successfully...!!'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('expertise_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (Doctor::where('expertise_id', $id)->exists()) {
            return response(['success' => false, 'msg' => 'This expertise is being used by one or more doctors! ']);
        }
        Expertise::find($id)->delete();

        return response(['success' => true]);
    }

    public function change_status(Request $reqeust)
    {
        $treat = Expertise::find($reqeust->id);
        $data['status'] = $treat->status == 1 ? 0 : 1;
        $treat->update($data);

        return response(['success' => true]);
    }
}
