<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Tender;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $counts = [
            'employees' => User::count(),
            'contract' => Contract::count(),
            'tender' => Tender::count(),
        ];
        $tenders = Tender::latest()->limit(5)->get();


        return Inertia::render('Admin/Dashboard',compact('counts','tenders'));
    }
}
