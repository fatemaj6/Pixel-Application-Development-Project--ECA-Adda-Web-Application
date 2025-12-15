<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eca;
use App\Models\EcaUser;
use App\Models\EcaEnrollment;
use Illuminate\Support\Facades\Auth;

class ECAController extends Controller
{
    // Show all ECAs
    public function index(Request $request)
{
    $query = Eca::query();

    // 🔍 Search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%")
              ->orWhere('instructor', 'like', "%{$search}%");
        });
    }

    // 🔃 Sort
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'az':
                $query->orderBy('title', 'asc');
                break;
            case 'level':
                $query->orderBy('level', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
    } else {
        $query->orderBy('created_at', 'desc'); // default
    }

    $ecas = $query->get();

    return view('eca.index', compact('ecas'));
}


    // Show full details
    public function show($id)
{
    $eca = Eca::findOrFail($id);

    $enrollment = null;

    if (Auth::check()) {
        $enrollment = EcaEnrollment::where('user_id', Auth::id())
            ->where('eca_id', $eca->id)
            ->first();
    }

    return view('eca.show', compact('eca', 'enrollment'));
}

    // Join ECA
public function join($id)
{
    EcaEnrollment::firstOrCreate(
        [
            'user_id' => Auth::id(),
            'eca_id'  => $id,
        ],
        [
            'status' => 'pending',
        ]
    );

    return redirect()->route('eca.my')
        ->with('success', 'Enrollment request sent. Awaiting admin approval.');
}

    // Show user's joined ECAs
    public function myEcas()
{
    $enrollments = EcaEnrollment::with('eca')
        ->where('user_id', Auth::id())
        ->get();

    return view('eca.my-ecas', compact('enrollments'));
}
}
?>