<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Presence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function index(Request $req)
    {
        $grade = $req->grade ?? null;
        $model = Child::select(['id', 'name']);

        if($grade && $grade != 'All') {
            $model = $model->where('grade', $grade);
        }

        $model = $model->get();

        foreach($model as $m) {
            $presence = Presence::where('child_id', $m->id)->pluck('check_in');
            $m->week1 = $presence[0] ?? null;
            $m->week2 = $presence[1] ?? null;
            $m->week3 = $presence[2] ?? null;
            $m->week4 = $presence[3] ?? null;
            $m->week5 = $presence[4] ?? null;
        }

        return response()->json($model);
    }

    public function store(Request $req)
    {
        //
    }

    public function show(Presence $presence)
    {
        //
    }

    public function edit(Presence $presence)
    {
        //
    }

    public function update(Request $req, Presence $presence)
    {
        //
    }

    public function destroy(Presence $presence)
    {
        //
    }
}
