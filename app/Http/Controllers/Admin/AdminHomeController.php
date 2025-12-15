<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EcaEnrollment;
use App\Models\Eca;
use App\Models\UserQuery;

class AdminHomeController extends Controller
{
    public function index()
    {
        $pendingRegistrations = User::where('registration_status','pending')->count();
        $pendingEnrollments = EcaEnrollment::where('status','pending')->count();
        $totalEcas = Eca::count();
        $openQueries = UserQuery::where('status','open')->count();

        return view('admin.dashboard', compact('pendingRegistrations','pendingEnrollments','totalEcas','openQueries'));
    }
}
?>