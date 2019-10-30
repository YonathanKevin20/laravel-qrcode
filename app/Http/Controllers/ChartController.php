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
}
