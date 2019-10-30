<?php

namespace App\Http\Controllers;

use App\Models\Child;
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
        $labels = Child::groupBy('grade')->pluck('grade')->toArray();
        $series = Child::selectRaw('COUNT(*) as total')
            ->groupBy(['grade'])
            ->pluck('total');
        $labels = array_map(function($value) { return 'Grade '.$value; }, $labels);

        $result = [
            'labels' => $labels,
            'series' => $series
        ];

        return response()->json($result);
    }
}
