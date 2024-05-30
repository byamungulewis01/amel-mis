<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\WeeklyReport;
use Illuminate\Http\Request;
use App\Models\WeeklyReportDetail;
use Illuminate\Support\Facades\Redirect;

class WeeklyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = WeeklyReport::where('stored_by', auth()->user()->id)->orderByDesc('created_at')->get();
        return Inertia::render('Reports/Index',compact('reports'));
    }
    public function reports_list()
    {
        $reports = WeeklyReport::with('user')->orderByDesc('created_at')->get();
        return Inertia::render('Reports/List',compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $monday = now()->startOfWeek(Carbon::MONDAY);
        $tuesday = now()->startOfWeek(Carbon::MONDAY)->addDays(1);
        $wednesday = now()->startOfWeek(Carbon::MONDAY)->addDays(2);
        $thursday = now()->startOfWeek(Carbon::MONDAY)->addDays(3);
        $friday = now()->startOfWeek(Carbon::MONDAY)->addDays(4);

        $weekly = array(
            1 => array(
                'date' =>  $monday->format('Y-m-d'),
                'name' => 'Monday'
            ),
            2 => array(
                'date' =>  $tuesday->format('Y-m-d'),
                'name' => 'Tuesday'
            ),
            3 => array(
                'date' =>  $wednesday->format('Y-m-d'),
                'name' => 'Wednesday'
            ),
            4 => array(
                'date' =>  $thursday->format('Y-m-d'),
                'name' => 'Thursday'
            ),
            5 => array(
                'date' =>  $friday->format('Y-m-d'),
                'name' => 'Friday'
            ),

        );

        return Inertia::render('Reports/Create', array('week_dates' => $weekly));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $weekOfMonth = (int) ceil(now()->day / 7);
        $startOfWeek = now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = now()->startOfWeek(Carbon::MONDAY)->addDays(4);
        try {
            $checking = WeeklyReport::where('week_number', $weekOfMonth)->where('stored_by', auth()->user()->id)->whereDate('date_from', $startOfWeek)->first();
            if ($checking) {
                return back()->with('warning1', 'Week ' . $weekOfMonth . ' Report arleady submited wait for next week');
            }

            $weekly = WeeklyReport::create([
                'stored_by' => auth()->user()->id,
                'week_number' => $weekOfMonth,
                'date_from' => $startOfWeek,
                'date_to' => $endOfWeek,
                'tender' => $request->tender,
                'used_money' => $request->used_money,
                'transport' => $request->transport,
                'accommodation' => $request->accommodation,
            ]);

            if ($weekly) {
                for ($i = 0; $i < count($request->date); $i++) {
                    WeeklyReportDetail::create([
                        'weekly_report_id' => $weekly->id,
                        'date' => $request->date[$i],
                        'activities' => $request->activities[$i],
                        'comment' => $request->comment[$i],
                        'hours' => $request->hours[$i],
                    ]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            return back()->with('error', 'Some error occurred while processing');
        }

        return to_route('weekly-reports.index')->with('message', 'Create Succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $report = WeeklyReport::where('id', $id)->with('details')->first();
        return Inertia::render('Reports/Edit', array('report' => $report));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        WeeklyReport::where('id', $id)->delete();
        return to_route('weekly-reports.index')->with('message', 'deleted Succesfully');

    }
    public function approve(string $id)
    {
        $report = WeeklyReport::where('id', $id)->first();
        $report->update(['status' => 'approved','approved_by' => auth()->user()->id]);
        return Redirect::back()->with('message', 'Approved successfully.');
    }
}
