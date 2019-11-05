<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Point;
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
            $model = $model->whereGrade($grade);
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

            $presence = $presence->orderBy('check_in')->get()->toArray();

            $w = 1;
            for($x = 0; $x < 5; $x++) { 
                $m['week'.$w++] = $presence[$x]['datetime'] ?? 'x';
            }
        }

        return response()->json($model);
    }

    public function store(Request $req)
    {
        $check_in = time();
        Presence::create([
            'child_id' => $req->child_id,
            'check_in' => $check_in,
            'month' => date('n'),
            'year' => date('Y')
        ]);

        if(date('H:i:s', $check_in) <= '09:00:00') {
            Point::create([
                'child_id' => $req->child_id,
                'qty' => 2,
                'info' => 'tidak telat',
                'time' => $check_in
            ]);
        }
        else {
            Point::create([
                'child_id' => $req->child_id,
                'qty' => 1,
                'info' => 'telat',
                'time' => $check_in
            ]);
        }

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

        for($i = 1; $i <= 12; $i++) {
            $presence = Presence::where('child_id', $child_id)
                ->where('month', $i)
                ->where('year', $year)
                ->orderBy('check_in')
                ->get()
                ->toArray();

            $w = 1;
            for($x = 0; $x < 5; $x++) {
                $month[$i]['week'.$w++] = [
                    'id' => $presence[$x]['id'] ?? null,
                    'check_in' => $presence[$x]['check_in'] ?? 0,
                    'datetime' => $presence[$x]['datetime'] ?? 'x'
                ];
            }
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

    public function update(Request $req, $child_id)
    {
        $id = $req->id ?? null;
        $date = $req->date ?? null;
        $time = $req->time ?? null;
        $epoch = strtotime($date.' '.$time);
        $month = date('n', $epoch);
        $year = date('Y', $epoch);

        $model = Presence::where('id', $id)->orWhere(function($q) use($date, $child_id) {
            $q->whereRaw("FROM_UNIXTIME(check_in, '%Y-%m-%d') = '$date'");
            $q->where('child_id', $child_id);
        })->first();
        if($model) {
            $model->update([
                'child_id' => $child_id,
                'check_in' => $epoch,
                'month' => $month,
                'year' => $year
            ]);
        }
        else {
            Presence::create([
                'child_id' => $child_id,
                'check_in' => $epoch,
                'month' => $month,
                'year' => $year
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Presence $presence)
    {
        //
    }
}
