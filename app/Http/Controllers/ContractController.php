<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Contract;
use App\Models\CashRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\CashRequestResource;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::orderByDesc('created_at')->get();
        return Inertia::render('Contracts/Index', compact('contracts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contract_number' => 'required',
            'value' => 'required|numeric',
            'description' => 'required',
            'signed_date' => 'required',
            'status' => 'required',
            'type' => 'required',
        ]);
        try {
            $request->merge(['stored_by' => auth()->user()->id]);
            Contract::create($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            return Redirect::back()->with('warning', 'Somethings went wrong , contact support');
        }

        return Redirect::back()->with('message', 'Contract Registered successfully');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'contract_number' => 'required',
            'value' => 'required|numeric',
            'description' => 'required',
            'signed_date' => 'required',
            'status' => 'required',
            'type' => 'required',
        ]);
        Contract::findorfail($id)->update($request->all());
        return Redirect::back()->with('message', 'Contract Updated successfully');
    }

    public function destroy($id)
    {
        $contract = Contract::where('id', $id)->first();
        $contract->delete();
        return Redirect::back()->with('message', 'Contract deleted successfully.');
    }

    public function activeContracts()
    {
        $contracts = Contract::where('status','active')->orderByDesc('created_at')->get();
        return Inertia::render('Contracts/Active', compact('contracts'));
    }
    public function show(String $id)
    {
        $contract = Contract::with('user')->findOrFail($id);
        $cashrequests =  CashRequestResource::collection(CashRequest::where('contract_id', $id)->orderByDesc('created_at')->get());
        return Inertia::render('Contracts/Show', compact('contract','cashrequests'));
    }

}
