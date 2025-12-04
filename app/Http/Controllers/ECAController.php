<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eca;
use App\Models\EcaUser;
use Illuminate\Support\Facades\Auth;

class ECAController extends Controller
{
    /**
     * Show all ECAs (with search + filters)
     */
    public function index(Request $request)
    {
        $query = Eca::query();

        // Search
        if ($request->search) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->category) {
            $query->where('category', $request->category);
        }

        // Filter by level
        if ($request->level) {
            $query->where('level', $request->level);
        }

        // Dropdown values
        $categories = Eca::select('category')->distinct()->pluck('category');
        $levels = Eca::select('level')->distinct()->pluck('level');

        // Results
        $ecas = $query->latest()->get();

        return view('eca.index', compact('ecas', 'categories', 'levels'));
    }

    // Show full details
    public function show($id)
    {
        $eca = Eca::findOrFail($id);
        $joined = false;

       if (Auth::check()) {
            $joined = EcaUser::where('user_id', Auth::id())
                             ->where('eca_id', $id)
                             ->exists();
        }

        return view('eca.show', compact('eca', 'joined'));
    }

    /**
     * Student enrolls in an ECA
     */
    public function enroll($id)
    {
        $userId = Auth::id();

        // Prevent duplicate join
        $exists = EcaUser::where('user_id', $userId)
                         ->where('eca_id', $id)
                         ->exists();

        if ($exists) {
            return back()->with('error', 'You already joined this ECA.');
        }

        EcaUser::create([
            'user_id' => $userId,
            'eca_id'  => $id
        ]);

        return redirect()->route('eca.my')->with('success', 'Successfully joined this ECA!');
    }

    // Show user's joined ECAs
    public function myEcas()
    {
        $ecas = Auth::user()->ecas;
        return view('eca.my-ecas', compact('ecas'));
    }
}
?>
