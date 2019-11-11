<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Grade;
use App\Models\Presence;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getGender()
    {
        $male = Child::whereGender('m')->count();
        $female = Child::whereGender('f')->count();

        $result = [$male, $female];

        return response()->json($result);
    }

    public function getGrade()
    {
        $labels = Grade::orderBy('id')->pluck('name');
        $model = Grade::get('id');
        foreach($model as $m) {
            $child_total = Child::whereGradeId($m->id)->count();
            $series[] = $child_total ?? 0;
        }

        $result = [
            'labels' => $labels,
            'series' => $series
        ];

        return response()->json($result);
    }

    public function getTotalPresence(Request $req)
    {
        $grade = $req->grade ?? null;
        $year = $req->year ?? date('Y');

        $child_id = Child::select(['id']);

        if($grade && $grade != 'All') {
            $child_id = $child_id->whereGrade($grade);
        }

        $child_id = $child_id->pluck('id');

        for($w = 1; $w <= 5; $w++) {
            $week[$w] = [];
            for($i = 1; $i <= 12; $i++) {
                $total = 0;
                $presence = Presence::whereIn('child_id', $child_id)
                    ->whereRaw("FROM_UNIXTIME(check_in, '%H:%i:%s') <> '00:00:00'")
                    ->whereRaw("FLOOR((DayOfMonth(FROM_UNIXTIME(check_in, '%Y-%m-%d'))-1)/7)+1 = '$w'")
                    ->where('month', $i)
                    ->where('year', $year)
                    ->orderBy('check_in')
                    ->get()
                    ->toArray();

                $total += count($presence);
                array_push($week[$w], $total);
            }
        }

        $result = $week;

        return response()->json($result);
    }
}
