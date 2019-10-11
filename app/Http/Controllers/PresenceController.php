<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Presence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function index(Request $req)
    {
        // dd(strtotime('2019-09-01'));
        $grade = $req->grade ?? null;
        $month = $req->month ?? null;

        $model = Child::select(['id', 'name']);

        if($grade && $grade != 'All') {
            $model = $model->where('grade', $grade);
        }

        $model = $model->get();

        foreach($model as $m) {
            $presence = Presence::where('child_id', $m->id);

            if($month) {
                $presence = $presence->where('month', $month);
            }

            $presence = $presence->orderBy('check_in')->pluck('check_in');

            $m->week1 = $presence[0] ?? 'x';
            $m->week2 = $presence[1] ?? 'x';
            $m->week3 = $presence[2] ?? 'x';
            $m->week4 = $presence[3] ?? 'x';
            $m->week5 = $presence[4] ?? 'x';
        }

        return response()->json($model);
    }

    public function store(Request $req)
    {
        Presence::create([
            'child_id' => $req->child_id,
            'check_in' => time(),
            'month' => date('n'),
        ]);

        return response()->json(['success' => true]);
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
