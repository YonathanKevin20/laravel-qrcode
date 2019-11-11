<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $model = Grade::orderBy('name')->get();

        return response()->json($model);
    }

    public function store(Request $req)
    {
        Grade::create([
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
        $model = Grade::findOrFail($id);
        $model->update([
            'name' => $req->name
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $model = Grade::findOrFail($id)->delete();

        return response()->json($model);
    }
}
