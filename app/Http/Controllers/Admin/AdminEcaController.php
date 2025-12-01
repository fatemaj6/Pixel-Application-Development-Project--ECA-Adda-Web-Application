<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eca;
use Illuminate\Http\Request;

class AdminEcaController extends Controller
{
    // List
    public function index()
    {
        $ecas = Eca::latest()->get();
        return view('admin.eca.index', compact('ecas'));
    }

    // Create form
    public function create()
    {
        return view('admin.eca.create');
    }

    // Store
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'level' => 'nullable',
            'short_description' => 'required',
            'full_description' => 'required',
            'instructor' => 'nullable',
            'thumbnail' => 'image|mimes:jpg,jpeg,png'
        ]);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $path = $file->store('thumbnails', 'public');
            $data['thumbnail'] = "/storage/" . $path;
        }

        Eca::create($data);

        return redirect()->route('eca.index')->with('success', 'ECA created successfully');
    }

    // Edit form
    public function edit($id)
    {
        $eca = Eca::findOrFail($id);
        return view('admin.eca.edit', compact('eca'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $eca = Eca::findOrFail($id);

        $data = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'level' => 'nullable',
            'short_description' => 'required',
            'full_description' => 'required',
            'instructor' => 'nullable',
            'thumbnail' => 'image|mimes:jpg,jpeg,png'
        ]);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $path = $file->store('thumbnails', 'public');
            $data['thumbnail'] = "/storage/" . $path;
        }

        $eca->update($data);

        return redirect()->route('eca.index')->with('success', 'ECA updated successfully');
    }

    // Delete
    public function destroy($id)
    {
        $eca = Eca::findOrFail($id);
        $eca->delete();

        return redirect()->route('eca.index')->with('success', 'ECA deleted successfully');
    }
}
?>