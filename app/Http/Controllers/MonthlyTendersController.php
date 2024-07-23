<?php

namespace App\Http\Controllers;

use App\Http\Resources\MonthlyTenderResource;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\MonthlyTender;
use Illuminate\Support\Facades\Redirect;

class MonthlyTendersController extends Controller
{
    public function index()
    {
        $monthlyTenders = MonthlyTenderResource::collection(MonthlyTender::orderByDesc('month')->get());
        return Inertia::render('Tenders/Index', compact('monthlyTenders'));
    }
    // store
    public function store(Request $request)
    {
        try {
            $month = $request->choice == 'currentMonth' ? now()->startOfMonth()->toDateString() : now()->addMonth()->startOfMonth()->toDateString();
            $chech = MonthlyTender::where('month', $month)->first();
            if ($chech) {
                return back()->with('warning', 'Arlead this month registered');
            }
            MonthlyTender::create(['month' => $month, 'user_id' => auth()->id()]);
            return back()->with('message', 'Congz, please add all tenders');
        } catch (\Throwable $th) {
            //throw $th;
            return Redirect::back()->with('warning', $th->getMessage());
        }
    }
    public function update(Request $request, String $id)
    {
        try {
            $month = $request->choice == 'currentMonth' ? now()->startOfMonth()->toDateString() : now()->addMonth()->startOfMonth()->toDateString();
            $chech = MonthlyTender::where('month', $month)->first();
            if ($chech) {
                return back()->with('warning', 'Arlead this month registered');
            }
            MonthlyTender::findOrFail($id)->update(['month' => $month, 'user_id' => auth()->id()]);
            return back()->with('message', 'Update successfully, please add all tenders');
        } catch (\Throwable $th) {
            //throw $th;
            return Redirect::back()->with('warning', $th->getMessage());
        }
    }
    public function destroy(String $id)
    {
        try {
            MonthlyTender::findOrFail($id)->delete();
            return back()->with('message', 'Successfully removed');
        } catch (\Throwable $th) {
            //throw $th;
            return Redirect::back()->with('warning', $th->getMessage());
        }
    }
}
