<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    protected $blog;

    public function __construct(
        Blog $blog
    ) {
        $this->blog = $blog;
        // $this->middleware('permission:bloglist', ['only' => ['index']]);
        // $this->middleware('permission:addblog', ['only' => ['create','store']]);
        // $this->middleware('permission:updateblog', ['only' => ['edit','update']]);
        // $this->middleware('permission:deleteblog', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $blogs = $this->blog->paginate(10);
            return view("admin.blog.list", compact("blogs"));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description'   => 'required',
            'image'          => 'required | image ',
            'title'         => 'required'
        ]);
        try {
            $params = [
                'title'         => $request->title,
                'description'         => $request->description,
                'image'         => Helper::uploadsFile($request->image, 'Upload-Image'),
                'slug'          => Str::slug($request->title)
            ];
            $blog = Blog::create($params);
            if ($blog) {
                return redirect()->route('allblogs')->with('message', 'Blog Added Successfully');
            } else {
                return redirect()->back()->withInput();
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'         => 'required',
            'description'   => 'required',
        ]);
        $blog = Blog::find($id);
        try {
            if (!empty($request->image)) {
                $imagePath = public_path('/storage/' . $blog->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $params = [
                    'title'         => $request->title,
                    'description'         => $request->description,
                    'image'         => Helper::uploadsFile($request->image, 'Upload-Image'),
                    'slug'          => Str::slug($request->title)
                ];
            } else {
                $params = [
                    'title'         => $request->title,
                    'description'   => $request->description,
                    'slug'          => Str::slug($request->title)
                ];
            }
            $blog->update($params);
            return redirect()->route('allblogs')->with('message', 'Blog Updated Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $blog = Blog::find($id);
            $imagePath = public_path('/storage/' . $blog->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $blog->delete();
            return redirect()->route('allblogs')->with('message', 'Blog deleted Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
}
