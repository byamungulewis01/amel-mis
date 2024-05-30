<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::orderByDesc('created_at')->get();
        return Inertia::render('Admin/Contracts', array('contracts' => $contracts));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'item' => 'required',
            'quoting_price' => 'required|numeric',
            'market_price' => 'required|numeric'
        ]);

        $request->merge(['stored_by' => auth()->user()->id]);
        Contract::create($request->all());
        return Redirect::back()->with('message', 'Contract Registered successfully');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'item' => 'required',
            'quoting_price' => 'required|numeric',
            'market_price' => 'required|numeric',
            'status' => 'required'
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
