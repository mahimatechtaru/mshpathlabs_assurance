<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('blog_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $blogs = Blog::where('release_now', 1)->orderBy('id', 'DESC')->get();

        return view('superAdmin.blog.blog', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('blog_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('superAdmin.blog.create_blog');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('blog_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->all();
        $request->validate([
            'title' => 'bail|required',
            'blog_ref' => 'bail|required',
            'desc' => 'bail|required',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        if ($request->hasFile('image')) {
            $data['image'] = (new CustomController)->imageUpload($request->image);
        } else {
            $data['image'] = 'prod_default.png';
        }
        Blog::create($data);

        return redirect('blog')->withStatus(__('Blog created successfully..!!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('blog_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $blog = Blog::find($id);

        return view('superAdmin.blog.edit_blog', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('blog_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->all();
        $request->validate([
            'title' => 'bail|required',
            'blog_ref' => 'bail|required',
            'desc' => 'bail|required',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        $blog = Blog::find($id);
        if ($request->hasFile('image')) {
            (new CustomController)->deleteFile($blog->image);
            $data['image'] = (new CustomController)->imageUpload($request->image);
        }
        $blog->update($data);

        return redirect('blog')->withStatus(__('Blog updated successfully..!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('blog_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $blog = Blog::find($id);
        (new CustomController)->deleteFile($blog->image);
        $blog->delete();

        return response(['success' => true]);
    }

    public function pending_blog()
    {
        $blogs = Blog::where('release_now', 0)->orderBy('id', 'DESC')->get();

        return view('superAdmin.blog.pending_blog', compact('blogs'));
    }
}
