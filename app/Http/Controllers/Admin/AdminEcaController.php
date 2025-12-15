<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminEcaController extends Controller
{
    /**
     * Display a listing of ECAs.
     */
    public function index()
    {
        $ecas = Eca::latest()->paginate(10); // paginate for admin dashboard
        return view('admin.eca.index', compact('ecas'));
    }

    /**
     * Show the form for creating a new ECA.
     */
    public function create()
    {
        return view('admin.eca.create');
    }

    /**
     * Store a newly created ECA in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'category'          => 'required|string|max:255',
            'level'             => 'nullable|string|max:255',
            'short_description' => 'required|string',
            'full_description'  => 'required|string',
            'instructor'        => 'nullable|string|max:255',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = Storage::url($path);
        }

        Eca::create($data);

        return redirect()->route('admin.ecas.index')
            ->with('success', 'ECA created successfully.');
    }

    /**
     * Show the form for editing the specified ECA.
     */
    public function edit($id)
    {
        $eca = Eca::findOrFail($id);
        return view('admin.eca.edit', compact('eca'));
    }

    /**
     * Update the specified ECA in storage.
     */
    public function update(Request $request, $id)
    {
        $eca = Eca::findOrFail($id);

        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'category'          => 'required|string|max:255',
            'level'             => 'nullable|string|max:255',
            'short_description' => 'required|string',
            'full_description'  => 'required|string',
            'instructor'        => 'nullable|string|max:255',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            // delete old thumbnail if exists
            if ($eca->thumbnail) {
                $oldPath = str_replace('/storage/', '', $eca->thumbnail);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = Storage::url($path);
        }

        $eca->update($data);

        return redirect()->route('admin.ecas.index')
            ->with('success', 'ECA updated successfully.');
    }

    /**
     * Remove the specified ECA from storage.
     */
    public function destroy($id)
    {
        $eca = Eca::findOrFail($id);

        if ($eca->thumbnail) {
            $oldPath = str_replace('/storage/', '', $eca->thumbnail);
            Storage::disk('public')->delete($oldPath);
        }

        $eca->delete();

        return redirect()->route('admin.ecas.index')
            ->with('success', 'ECA deleted successfully.');
    }
}
