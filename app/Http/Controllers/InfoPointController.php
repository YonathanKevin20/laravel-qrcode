<?php

namespace App\Http\Controllers;

use App\Models\InfoPoint;
use Illuminate\Http\Request;

class InfoPointController extends Controller
{
    public function index()
    {
        $model = InfoPoint::orderBy('name')->get();

        return response()->json($model);
    }

    public function store(Request $req)
    {
        InfoPoint::create([
            'name' => $req->name
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $req, $id)
    {
        $model = InfoPoint::findOrFail($id);
        $model->update([
            'name' => $req->name
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $model = InfoPoint::findOrFail($id)->delete();

        return response()->json($model);
    }
}
