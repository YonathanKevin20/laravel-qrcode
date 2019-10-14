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
        $month = $req->month ?? date('n');
        $year = $req->year ?? date('Y');

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
            if($year) {
                $presence = $presence->where('year', $year);
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
        // dd(strtotime('2019-09-01'));
        Presence::create([
            'child_id' => $req->child_id,
            'check_in' => time(),
            'month' => date('n'),
            'year' => date('Y')
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        //
    }

    public function showChild(Request $req, $child_id)
    {
        $year = $req->year ?? date('Y');

        $model = Child::select(['id', 'name', 'grade'])->where('id', $child_id)->first();

        $month = array();
        for($i = 1; $i <= 12; $i++) {
            $presence = Presence::where('child_id', $child_id)
                ->where('month', $i)
                ->where('year', $year)
                ->orderBy('check_in')
                ->pluck('check_in');

            $month[$i]['week1'] = $presence[0] ?? 'x';
            $month[$i]['week2'] = $presence[1] ?? 'x';
            $month[$i]['week3'] = $presence[2] ?? 'x';
            $month[$i]['week4'] = $presence[3] ?? 'x';
            $month[$i]['week5'] = $presence[4] ?? 'x';
        }

        $result = [
            'model' => $model,
            'month' => $month
        ];

        return response()->json($result);
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
