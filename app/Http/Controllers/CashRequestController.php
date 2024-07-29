<?php

namespace App\Http\Controllers;

use App\Http\Resources\CashRequestResource;
use App\Models\CashRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CashRequestController extends Controller
{
    //
    public function fieldRequests()
    {
        $cashrequests = CashRequestResource::collection(CashRequest::where('stored_by', auth()->id())->orderByDesc('created_at')->get());
        return Inertia::render('CashRequest/Field', compact('cashrequests'));
    }
    public function managerRequests()
    {
        $cashrequests = CashRequestResource::collection(CashRequest::orderByDesc('created_at')->paginate(10));
        return Inertia::render('CashRequest/Manager', compact('cashrequests'));
    }
    public function financeRequests()
    {
        $cashrequests = CashRequestResource::collection(CashRequest::orderByDesc('created_at')->paginate(10));
        return Inertia::render('CashRequest/Finance', compact('cashrequests'));
    }
    public function cashRequest(Request $request, string $contract)
    {
        $request->validate([
            'request_amount' => 'required|numeric',
            'request_for' => 'required',
            'purchase_order' => 'required|max:100000',
            'estimated_badge' => 'required|max:100000',
        ]);
        $lastRequest = CashRequest::where('contract_id', $contract)->where('status', 'requested')->first();
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

        $request->merge(['stored_by' => auth()->id(), 'contract_id' => $contract]);
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

    public function approve(Request $request, string $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);
        CashRequest::findOrFail($id)->update(['status' => 'approved',
            'approvedOrRejected_by' => auth()->id(),
            'approveOrRejectDate' => now(),
            'comment' => $request->comment,
        ]);
        return Redirect::back()->with('message', 'Cash Request approved.');
    }

    public function reject(Request $request, string $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);
        CashRequest::findOrFail($id)->update(['status' => 'rejected',
            'approvedOrRejected_by' => auth()->id(),
            'approveOrRejectDate' => now(),
            'comment' => $request->comment,
        ]);
        return Redirect::back()->with('message', 'Cash Request rejected.');
    }
    // public function closing(Request $request, string $id)
    // {
    //     $request->validate([
    //         'sold_amount' => 'required|numeric',
    //         'sales_amount' => 'required|numeric',
    //         'description' => 'nullable|max:255',
    //     ]);
    //     $request->merge([
    //         'status' => 'complete',
    //         'closed_by' => auth()->user()->id,
    //     ]);
    //     $tender = Tender::where('id', $id)->first();
    //     $tender->update($request->all());
    //     return Redirect::back()->with('message', 'Tender closed successfully.');
    // }

    public function financeApprove(string $id)
    {
        CashRequest::findOrFail($id)->update(['isMoneyRecieved' => true,
            'moneySentby' => auth()->id(),
            'moneyRecievedDate' => now(),
        ]);
        return Redirect::back()->with('message', 'Approved that money sent.');
    }
}
