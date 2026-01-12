<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $path = $request->file('thumbnail')?->store('blogs', 'public');

        Blog::create([
            'title' => $request->title,
            'excerpt' => Str::limit(strip_tags($request->content), 150),
            'content' => $request->content,
            'thumbnail' => $path,
            'author_id' => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog posted!');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $path = $request->file('thumbnail')?->store('blogs', 'public');

        $updateData = [
            'title' => $request->title,
            'excerpt' => Str::limit(strip_tags($request->content), 150),
            'content' => $request->content,
        ];

        if ($path) {
            $updateData['thumbnail'] = $path;
        }

        $blog->update($updateData);
        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated!');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return back()->with('success', 'Blog deleted!');
    }
}
