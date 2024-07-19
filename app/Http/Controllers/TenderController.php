<?php

namespace App\Http\Controllers;

use App\Http\Resources\CashRequestResource;
use App\Http\Resources\TenderResource;
use Inertia\Inertia;
use App\Models\Tender;
use App\Models\CashRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenders = Tender::where('stored_by', auth()->user()->id)->orderByDesc('created_at')->get();
        return Inertia::render('Tenders/Index', compact('tenders'));
    }
    public function new_tenders()
    {
        $tenders = Tender::where('status', 'new')->orderByDesc('created_at')->get();
        return Inertia::render('Tenders/NewTenders', compact('tenders'));
    }
    public function tenders()
    {
        $tenders = Tender::with('user')->orderByDesc('created_at')->get();
        return Inertia::render('Tenders/Tenders', compact('tenders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('Tenders/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tender_name' => 'required',
            'bid_security' => 'required|numeric',
            'tender_fees' => 'required|numeric',
            'description' => 'required',
            'opening_date' => 'required',
            'submitted_date' => 'required',
            'bid_documents.*' => 'nullable|file|mimes:pdf,jpg,png,jpeg,xlsx,xls,doc,docx,ppt,pptx|max:5120',
        ]);
        $documents = [];
        if ($request->hasFile('bid_documents')) {
            foreach ($request->file('bid_documents') as $key => $file) {
                $documents[$key] = $file->store('tenderDocuments', 'public');
            }
        }

        try {

            $request->merge(['stored_by' => auth()->user()->id, 'documents' => $documents]);
            Tender::create($request->all());
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }

        return to_route('tenders.index')->with('message', 'Tender created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tender = new TenderResource(Tender::where('id', $id)->first());
        $cashrequests =  CashRequestResource::collection(CashRequest::with('tender')->where('tender_id', $id)->orderByDesc('created_at')->get());
        return Inertia::render('Tenders/Show', compact('tender', 'cashrequests'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tender = Tender::where('id', $id)->first();
        return Inertia::render('Tenders/Edit', compact('tender'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tender_name' => 'required',
            'bid_security' => 'required|numeric',
            'tender_fees' => 'required|numeric',
            'description' => 'required',
            'opening_date' => 'required',
            'submitted_date' => 'required',
            'bid_documents.*' => 'nullable|file|mimes:pdf,jpg,png,jpeg,xlsx,xls,doc,docx,ppt,pptx|max:5120',
        ]);

        $tender = Tender::findOrFail($id);
        $documents = $tender->documents;

        if ($request->hasFile('bid_documents')) {
            foreach ($request->file('bid_documents') as $key => $file) {
                $documents[$key] = $file->store('tenderDocuments', 'public');
            }
        }

        try {
            $tender->update([
                'tender_name' => $request->tender_name,
                'bid_security' => $request->bid_security,
                'tender_fees' => $request->tender_fees,
                'description' => $request->description,
                'opening_date' => $request->opening_date,
                'submitted_date' => $request->submitted_date,
                'documents' => $documents,
            ]);
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }



        return to_route('tenders.index')->with('message', 'Tender updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //code...
            $tender = Tender::where('id', $id)->first();
            $tender->delete();
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getCode() == 23000 ? 'Tender can\'t deleted due to is in used' : 'Something went wrong , ask administrator');
        }
        return Redirect::back()->with('message', 'Tender deleted successfully.');
    }
    public function approve(string $id)
    {
        $tender = Tender::where('id', $id)->first();
        $tender->update(['status' => 'in_progress', 'approved_by' => auth()->user()->id]);
        return Redirect::back()->with('message', 'Tender approved successfully.');
    }
    public function closing(Request $request, string $id)
    {
        $request->validate([
            'sold_amount' => 'required|numeric',
            'sales_amount' => 'required|numeric',
            'description' => 'nullable|max:255',
        ]);
        $request->merge([
            'status' => 'complete',
            'closed_by' => auth()->user()->id,
        ]);
        $tender = Tender::where('id', $id)->first();
        $tender->update($request->all());
        return Redirect::back()->with('message', 'Tender closed successfully.');
    }

    public function cashRequest(Request $request, string $tenderId)
    {
        $request->validate([
            'request_amount' => 'required|numeric',
            'request_for' => 'required',
            'description' => 'nullable',
            'purchase_order' => 'required|max:100000',
            'estimated_badge' => 'required|max:100000',
        ]);
        $lastRequest = CashRequest::where('tender_id', $tenderId)->where('status', 'requested')->first();
        if ($lastRequest) {
            return Redirect::back()->with('warning', 'You can\'t reqeuest more than one cash  at time');
        }
        if ($request->hasFile('purchase_order')) {
            $purchase_order = $request->file('purchase_order')->store('upload_files', 'public');
            $request->merge(['purchase_order_file' => $purchase_order]);
        }
        if ($request->hasFile('estimated_badge')) {
            $estimated_badge = $request->file('estimated_badge')->store('upload_files', 'public');
            $request->merge(['estimated_badge_file' => $estimated_badge]);
        }

        $request->merge(['stored_by' => auth()->user()->id, 'tender_id' => $tenderId]);
        try {
            CashRequest::create($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            return Redirect::back()->with('warning', $th->getMessage());
        }
        return Redirect::back()->with('message', 'Cash requested successfully');
    }
    public function cashRequestUpdate(Request $request, string $id)
    {
        $request->validate([
            'request_amount' => 'required|numeric',
            'request_for' => 'required',
            'description' => 'nullable',
            'purchase_order' => 'nullable|file|max:100000',
            'estimated_badge' => 'nullable|file|max:100000',
        ]);

        $cashRequest = CashRequest::findOrFail($id);

        if ($request->hasFile('purchase_order')) {
            Storage::delete($cashRequest->purchase_order_file);
            $purchase_order = $request->file('purchase_order')->store('upload_files', 'public');
            $request->merge(['purchase_order_file' => $purchase_order]);
        }

        if ($request->hasFile('estimated_badge')) {
            Storage::delete($cashRequest->estimated_badge_file);
            $estimated_badge = $request->file('estimated_badge')->store('upload_files', 'public');
            $request->merge(['estimated_badge_file' => $estimated_badge]);
        }

        try {
            $cashRequest->update($request->all());
        } catch (\Throwable $th) {
            return Redirect::back()->with('warning', $th->getMessage());
        }

        return Redirect::back()->with('message', 'Cash request updated successfully');
    }
    public function cashRequestDelete(string $id)
    {
        try {
            $cashRequest = CashRequest::findOrFail($id);
            Storage::delete($cashRequest->purchase_order_file);
            Storage::delete($cashRequest->estimated_badge_file);
            $cashRequest->delete();
        } catch (\Throwable $th) {
            return Redirect::back()->with('warning', $th->getMessage());
        }

        return Redirect::back()->with('message', 'Cash request deleted successfully');
    }
}
