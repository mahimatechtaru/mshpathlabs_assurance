<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('language_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $languages = Language::orderBy('id', 'DESC')->get();

        return view('superAdmin.language.language', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('language_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('superAdmin.language.create_language');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'direction' => 'required',
            'json_file' => 'required',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        if ($file = $request->hasfile('image')) {
            $file = $request->file('image');
            $fileName = $request->name;
            $path = public_path('/images/upload/');
            $file->move($path, $fileName.'.png');
            $data['image'] = $fileName.'.png';
        } else {
            $data['image'] = 'defaultUser.png';
        }
        if ($file = $request->hasfile('json_file')) {
            $file = $request->file('json_file');
            $fileName = $request->name;
            $path = resource_path('/lang');
            $file->move($path, $fileName.'.json');
            $data['json_file'] = $fileName.'.json';
        }
        $data['status'] = 1;
        Language::create($data);

        return redirect('/language');
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
        abort_if(Gate::denies('language_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $language = Language::find($id);

        return view('superAdmin.language.edit_language', compact('language'));
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
            'direction' => 'required',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        $data = $request->all();
        $language = Language::find($id);
        if ($file = $request->hasfile('image')) {
            $file = $request->file('image');
            $fileName = $request->name;
            $path = public_path('/images/upload/');
            $file->move($path, $fileName.'.png');
            $data['image'] = $fileName.'.png';
        }
        if ($file = $request->hasfile('json_file')) {
            if (File::exists(resource_path('lang'.'/'.$language->json_file))) {
                File::delete(resource_path('lang'.'/'.$language->json_file));
            }
            $file = $request->file('json_file');
            $fileName = $request->name;
            $path = resource_path('/lang');
            $file->move($path, $fileName.'.json');
            $data['json_file'] = $fileName.'.json';
        }
        $language->update($data);

        return redirect('/language');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $language = Language::find($id);
        if ($language['name'] == 'English') {
            return response(['success' => false, 'data' => 'This data can not be delete.']);
        }
        if (File::exists(resource_path('lang'.'/'.$language->json_file))) {
            File::delete(resource_path('lang'.'/'.$language->json_file));
        }

        if ($language->image != 'prod_default.png' && $language->image != 'defaultUser.png') {
            if (File::exists(public_path('images/upload/'.$language->image))) {
                File::delete(public_path('images/upload/'.$language->image));
            }
        }
        $language->delete();

        return response(['success' => true]);
    }

    public function change_status(Request $reqeust)
    {
        $language = Language::find($reqeust->id);
        $data['status'] = $language->status == 1 ? 0 : 1;
        $language->update($data);

        return response(['success' => true]);
    }

    public function downloadFile()
    {
        $pathToFile = resource_path().'/lang/English.json';
        $name = 'English.json';
        $headers = ['Content-Type: application/json'];

        return response()->download($pathToFile, $name, $headers);
    }
}
