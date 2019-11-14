<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $model = Configuration::get();

        return response()->json($model);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $req, $id)
    {
        $model = Configuration::findOrFail($id);
        $model->update([
            'value' => $req->value
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        //
    }
}
