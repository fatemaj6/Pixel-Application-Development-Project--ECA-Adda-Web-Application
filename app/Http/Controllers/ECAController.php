<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eca;
use App\Models\EcaUser;
use Illuminate\Support\Facades\Auth;

class ECAController extends Controller
{
    // Show all ECAs
    public function index()
    {
        $ecas = Eca::all();
        return view('eca.index', compact('ecas'));
    }

    // Show full details
    public function show($id)
    {
        $eca = Eca::findOrFail($id);
        $joined = false;

        if (Auth::check()) {
            $joined = Auth::user()->ecas->contains($eca->id);
        }

        return view('eca.show', compact('eca', 'joined'));
    }

    // Join ECA
    public function join($id)
    {
        EcaUser::firstOrCreate([
            'user_id' => Auth::id(),
            'eca_id'  => $id,
        ]);

        return redirect()->back()->with('success', 'Successfully joined ECA!');
    }

    // Show user's joined ECAs
    public function myEcas()
    {
        $ecas = Auth::user()->ecas;
        return view('eca.my-ecas', compact('ecas'));
    }
}
?>