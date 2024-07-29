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
        $employees = User::count();
        $contracts = Contract::count();
        $tenderCounts = Tender::count();


        $tenders = Tender::latest()->limit(5)->get();


        return Inertia::render('Admin/Dashboard', compact('employees', 'contracts', 'tenderCounts', 'tenders'));
    }
}
