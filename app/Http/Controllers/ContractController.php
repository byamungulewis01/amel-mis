<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

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

}
