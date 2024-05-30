<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenders = Tender::where('stored_by',auth()->user()->id)->orderByDesc('created_at')->get();
        return Inertia::render('Tenders/Index', array('tenders' => $tenders));
    }
    public function tenders()
    {
        $tenders = Tender::with('user')->orderByDesc('created_at')->get();
        return Inertia::render('Tenders/Tenders', array('tenders' => $tenders));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tender_name' => 'required',
            'request_amount' => 'required|numeric',
            'request_for' => 'required',
            'purchase_order' => 'required|max:100000',
            'estimated_badge' => 'required|max:100000',
        ]);
        if ($request->hasFile('purchase_order')) {
            $purchase_order = $request->file('purchase_order')->store('upload_files');
            $request->merge(['purchase_order_file' => $purchase_order]);
        }
        if ($request->hasFile('estimated_badge')) {
            $estimated_badge = $request->file('estimated_badge')->store('upload_files');
            $request->merge(['estimated_badge_file' => $estimated_badge]);
        }

        $request->merge(['stored_by' => auth()->user()->id]);
        Tender::create($request->all());
        return Redirect::back()->with('message', 'Tender created successfully');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tender = Tender::where('id', $id)->first();
        $request->validate([
            'tender_name' => 'required',
            'request_amount' => 'required|numeric',
            'request_for' => 'required',
            'purchase_order' => 'nullable|max:100000',
            'estimated_badge' => 'nullable|max:100000',
        ]);
        if ($request->hasFile('purchase_order')) {
            Storage::delete($tender->purchase_order);
            $purchase_order = $request->file('purchase_order')->store('upload_files');
            $request->merge(['purchase_order_file' => $purchase_order]);
        }
        if ($request->hasFile('estimated_badge')) {
            Storage::delete($tender->estimated_badge);
            $estimated_badge = $request->file('estimated_badge')->store('upload_files');
            $request->merge(['estimated_badge_file' => $estimated_badge]);
        }

        $tender->update($request->all());
        return Redirect::back()->with('message', 'Tender updared successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tender = Tender::where('id', $id)->first();
        $tender->delete();
        return Redirect::back()->with('message', 'Tender deleted successfully.');
    }
    public function approve(string $id)
    {
        $tender = Tender::where('id', $id)->first();
        $tender->update(['status' => 'in_progress','approved_by' => auth()->user()->id]);
        return Redirect::back()->with('message', 'Tender approved successfully.');
    }
    public function closing(Request $request,string $id)
    {
        $request->validate([
            'sold_amount' => 'required|numeric',
            'sales_amount' => 'required|numeric',
            'description' => 'nullable|max:255',
        ]);
        $request->merge([
            'status' => 'complete',
            'closed_by' => auth()->user()->id
        ]);
        $tender = Tender::where('id', $id)->first();
        $tender->update($request->all());
        return Redirect::back()->with('message', 'Tender closed successfully.');
    }
}
