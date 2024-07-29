<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Tender;
use App\Models\CashRequest;
use Illuminate\Http\Request;
use App\Models\MonthlyTender;
use App\Http\Resources\TenderResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\CashRequestResource;
use App\Http\Resources\MonthlyTenderResource;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenders = TenderResource::collection(Tender::where('monthly_tender_id', request('id'))->orderByDesc('created_at')->paginate(10));
        $tender = new MonthlyTenderResource(MonthlyTender::findOrFail(request('id')));

        return Inertia::render('Tenders/List', compact('tenders', 'tender'));
    }
    public function new_tenders()
    {
        $tenders = Tender::where('status', 'new')->orderByDesc('created_at')->get();
        return Inertia::render('Tenders/NewTenders', compact('tenders'));
    }
    public function tenders()
    {
        $tenders = Tender::with('user')->orderByDesc('created_at')->get();
        // dd($tenders);
        return Inertia::render('Tenders/Tenders', compact('tenders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tender_id = request('id');
        return Inertia::render('Tenders/Create', compact('tender_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tender_name' => 'required',
            'bid_security' => 'required|numeric',
            'tender_fees' => 'required|numeric',
            'other_fees' => 'required|numeric',
            'description' => 'required',
            'organisation_name' => 'required',
            'opening_date' => 'required',
            'closing_date' => 'nullable',
            'bid_documents' => 'required|array',
            'bid_documents.*.name' => 'required|string',
            'bid_documents.*.filePath' => 'required|mimes:pdf,jpg,png,jpeg,xlsx,xls,doc,docx,ppt,pptx|max:5120',
        ]);

        $documents = [];
        foreach ($request->bid_documents as $document) {
            $documents[] = [
                'name' => $document['name'],
                'filePath' => $document['filePath']->store('tenderDocuments', 'public')
            ];
        }
        try {
            $request->merge(['stored_by' => auth()->user()->id, 'monthly_tender_id' => $request->tender_id, 'documents' => $documents]);
            Tender::create($request->all());
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }

        return to_route('tenders.index', ['id' => $request->tender_id])->with('message', 'Tender created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tender = new TenderResource(Tender::where('id', $id)->first());
        return Inertia::render('Tenders/Show', compact('tender'));
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
            'organisation_name' => 'required',
            'description' => 'required',
            'opening_date' => 'required',
            'closing_date' => 'nullable',
            'bid_documents.*' => 'nullable|file|mimes:pdf,jpg,png,jpeg,xlsx,xls,doc,docx,ppt,pptx|max:5120',
        ]);

        $tender = Tender::findOrFail($id);
        $documents = $tender->documents;

        if ($request->hasFile('bid_documents')) {
            foreach ($request->file('bid_documents') as $key => $file) {
                Storage::delete($documents[$key]);
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
            foreach ($tender->documents as $document) {
                Storage::delete($document);
            }
            $tender->delete();
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getCode() == 23000 ? 'Tender can\'t deleted due to is in used' : 'Something went wrong , ask administrator');
        }
        return Redirect::back()->with('message', 'Tender deleted successfully.');
    }


}
