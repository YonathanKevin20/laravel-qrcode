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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Grade $grade)
    {
        //
    }

    public function edit(Grade $grade)
    {
        //
    }

    public function update(Request $request, Grade $grade)
    {
        //
    }

    public function destroy(Grade $grade)
    {
        //
    }
}
