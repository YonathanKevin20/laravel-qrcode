<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $model = User::all();

        return response()->json($model);
    }

    public function store(Request $req)
    {
        User::create([
            'username' => $req->username,
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password),
            'role' => $req->role,
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $req, $id)
    {
        $model = User::findOrFail($id);
        $model->update([
            'username' => $req->username,
            'name' => $req->name,
            'email' => $req->email,
            'role' => $req->role,
        ]);

        return response()->json(['success' => true]);
    }

    public function updatePassword(Request $req, $id)
    {
        $model = User::findOrFail($id);
        $model->update([
            'password' => bcrypt($req->password),
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $model = User::findOrFail($id);
        $model->delete();
    
        return response()->json(['success' => true]);
    }
}
