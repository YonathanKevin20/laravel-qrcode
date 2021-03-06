<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Point;
use App\Imports\PointsImport;
use Illuminate\Http\Request;
use DB;

class PointController extends Controller
{
    public function index(Request $req)
    {
        $grade = $req->grade ?? null;

        $model = Child::selectRaw('children.id as child_id, name, grade_id, IFNULL(SUM(qty), 0) as qty')
            ->with(['grade'])
            ->leftJoin('points', 'children.id', '=', 'points.child_id')
            ->groupBy([
                'children.id',
                'name',
                'grade_id',
            ]);

        if($grade && $grade != 'All') {
            $model = $model->whereHas('grade', function($q) use($grade) {
                $q->whereId($grade);
            });
        }

        $model = $model->orderBy('name')->get();

        return response()->json($model);
    }

    public function store(Request $req)
    {
        Point::create([
            'child_id' => $req->child_id,
            'qty' => $req->qty,
            'info_point_id' => $req->info_point_id,
            'time' => time(),
        ]);

        return response()->json(['success' => true]);
    }

    public function showChild(Request $req, $child_id)
    {
        $model = Point::with(['infoPoint'])
            ->where('child_id', $child_id)
            ->orderBy('time', 'desc')
            ->get();
        $child = Child::select(['id', 'name', 'grade_id'])->with(['grade'])->where('id', $child_id)->first();

        $result = [
            'model' => $model,
            'child' => $child
        ];

        return response()->json($result);
    }

    public function slidePoint(Request $req)
    {
        $model = Child::selectRaw('children.id as child_id, name, grade_id, IFNULL(SUM(qty), 0) as qty')
            ->with(['grade'])
            ->leftJoin('points', 'children.id', '=', 'points.child_id')
            ->groupBy([
                'children.id',
                'name',
                'grade_id',
            ])
            ->orderBy('qty', 'DESC')
            ->get()
            ->toArray();

        $result = array_chunk($model, 4);

        return response()->json($result);
    }

    public function edit(Point $point)
    {
        //
    }

    public function update(Request $req, Point $point)
    {
        //
    }

    public function destroy($id)
    {
        $model = Point::findOrFail($id)->delete();
    
        return response()->json($model);
    }

    public function import(Request $req)
    {
        if($req->import_file) {
            DB::beginTransaction();
            $data = new PointsImport();
            try {
                $data->import($req->import_file);
                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                return response()->json([
                    'message' => 'Terjadi kesalahan pada database',
                    'console' => $ex->getMessage(),
                ]);
            }
        }
        else {
            return back();
        }
    }
}
