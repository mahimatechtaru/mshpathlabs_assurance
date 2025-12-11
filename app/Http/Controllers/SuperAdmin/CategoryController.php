<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\Treatments;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::with('treatment')->orderBy('id', 'DESC')->get();

        return view('superAdmin.category.category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('category_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $treats = Treatments::whereStatus(1)->orderBy('id', 'DESC')->get();

        return view('superAdmin.category.create_category', compact('treats'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:category',
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
        Category::create($data);

        return redirect('category')->withStatus(__('Category created successfully..!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $treats = Treatments::whereStatus(1)->orderBy('id', 'DESC')->get();
        $category = Category::find($id);

        return view('superAdmin.category.edit_category', compact('category', 'treats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required|unique:category,name,'.$id.',id',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        $data = $request->all();
        $category = Category::find($id);
        if ($request->hasFile('image')) {
            (new CustomController)->deleteFile($category->image);
            $data['image'] = (new CustomController)->imageUpload($request->image);
        }
        $category->update($data);

        return redirect('category')->withStatus(__('Category updated successfully..!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (Doctor::where('category_id', $id)->exists()) {
            return response(['success' => false, 'msg' => 'This category is being used by one or more doctors!']);
        }
        $category = Category::find($id);
        $category->delete();

        return response(['success' => true]);
    }

    public function change_status(Request $reqeust)
    {
        $category = Category::find($reqeust->id);
        $data['status'] = $category->status == 1 ? 0 : 1;
        $category->update($data);

        return response(['success' => true]);
    }
}
