<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Configuration;
use App\Models\InfoPoint;
use App\Models\Point;
use App\Models\Presence;
use Illuminate\Http\Request;
use DB;

class PresenceController extends Controller
{
    public function index(Request $req)
    {
        $grade = $req->grade ?? null;
        $month = $req->month ?? date('n');
        $year = $req->year ?? date('Y');

        $model = Child::select(['id', 'name']);

        if($grade && $grade != 'All') {
            $model = $model->whereHas('grade', function($q) use($grade) {
                $q->whereId($grade);
            });
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
        $child_id = $req->child_id;
        $start_time = Configuration::getValue('start_time');
        $on_time_point = Configuration::getValue('on_time_point');
        $late_point = Configuration::getValue('late_point');
        $check_in = $req->check_in ?? time();
        $date = date('Y-m-d', $check_in);
        $day = date('w', $check_in);
        $late = InfoPoint::whereRaw('LOWER(name) LIKE (?)', ["%late%"])->first(['id']);
        $on_time = InfoPoint::whereRaw('LOWER(name) LIKE (?)', ["%on time%"])->first(['id']);

        if($day != 0) {
            return response()->json(['message' => 'Input allowed only Sunday']);
        }

        if(!$child_id) {
            return response()->json(['message' => "Column 'child_id' cannot be NULL"], 203);
        }

        $model = Presence::where(function($q) use($date, $child_id) {
            $q->whereRaw("FROM_UNIXTIME(check_in, '%Y-%m-%d') = '$date'");
            $q->where('child_id', $child_id);
        })->count();
        if($model > 0) {
            return response()->json(['message' => 'Data already exists']);
        }
        else {
            DB::beginTransaction();
            try {
                Presence::create([
                    'child_id' => $child_id,
                    'check_in' => $check_in,
                    'month' => date('n'),
                    'year' => date('Y')
                ]);

                if(date('H:i:s', $check_in) <= $start_time) {
                    Point::create([
                        'child_id' => $child_id,
                        'qty' => $on_time_point,
                        'info_point_id' => $on_time->id,
                        'time' => $check_in
                    ]);
                }
                else {
                    Point::create([
                        'child_id' => $child_id,
                        'qty' => $late_point,
                        'info_point_id' => $late->id,
                        'time' => $check_in
                    ]);
                }

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                return response()->json([
                    'message' => 'Terjadi kesalahan pada database',
                    'console' => $ex->getMessage(),
                ]);
            }

            return response()->json(['success' => true]);
        }
    }

    public function show($id)
    {
        //
    }

    public function showChild(Request $req, $child_id)
    {
        $year = $req->year ?? date('Y');

        $model = Child::select(['id', 'name', 'grade_id'])->with(['grade'])->where('id', $child_id)->first();

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
        $epoch = $epoch != 0 ? $epoch : strtotime($date.' 00:00:00');

        $model = Presence::where('id', $id)->orWhere(function($q) use($date, $child_id) {
            $q->whereRaw("FROM_UNIXTIME(check_in, '%Y-%m-%d') = '$date'");
            $q->where('child_id', $child_id);
        })->first();
        if($model) {
            $model->update([
                'child_id' => $child_id,
                'check_in' => $epoch,
                'month' => date('n'),
                'year' => date('Y')
            ]);
        }
        else {
            Presence::create([
                'child_id' => $child_id,
                'check_in' => $epoch,
                'month' => date('n'),
                'year' => date('Y')
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Presence $presence)
    {
        //
    }
}
