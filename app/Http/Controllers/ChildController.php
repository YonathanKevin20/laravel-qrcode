<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Exports\ChildrenExport;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    public function index()
    {
        $model = Child::all();

        return response()->json($model); 
    }

    public function store(Request $req)
    {
        Child::create([
            'name' => $req->name,
            'gender' => $req->gender,
            'grade' => $req->grade,
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $req, $id)
    {
        $model = Child::findOrFail($id);
        $model->update([
            'name' => $req->name,
            'gender' => $req->gender,
            'grade' => $req->grade,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $model = Child::findOrFail($id);
        $model->delete();
    
        return response()->json(['success' => true]);
    }

    public function exportTemplatePoint()
    {
        return (new ChildrenExport)->download('template_import_point.xlsx');
    }
}
