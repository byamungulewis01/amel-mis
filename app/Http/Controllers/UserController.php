<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    //index
    public function index()
    {
        $users = User::whereNot('department','admin')->orderByDesc('created_at')->get();
        return Inertia::render('Admin/Users', array('users' => $users));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'department' => 'required'
        ]);

        $request->merge(['password' => 'password']);
        User::create($request->all());
        return Redirect::route('user.index')->with('message', 'User created successfully');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric|digits:10|unique:users,phone,' . $id,
            'department' => 'required'

        ]);
        User::findorfail($id)->update($request->all());
        return Redirect::route('user.index')->with('message', 'User Updated successfully');
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        return Redirect::back()->with('message', 'User deleted successfully.');
    }

}
