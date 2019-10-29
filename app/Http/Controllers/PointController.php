<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Point;
use App\Imports\PointsImport;
use Illuminate\Http\Request;
use DB;

class PointController extends Controller
{
    public function index()
    {
        $model = Child::selectRaw('children.id as child_id, name, grade, IFNULL(SUM(qty), 0) as qty')
            ->leftJoin('points', 'children.id', '=', 'points.child_id')
            ->groupBy([
                'children.id',
                'name',
                'grade',
            ])
            ->get();

        return response()->json($model);
    }

    public function store(Request $req)
    {
        Point::create([
            'child_id' => $req->child_id,
            'qty' => $req->qty,
            'info' => $req->info,
            'time' => time(),
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        //
    }

    public function showChild(Request $req, $child_id)
    {
        $model = Point::where('child_id', $child_id)->orderBy('time', 'desc')->get();
        $child = Child::findorFail($child_id);

        $result = [
            'model' => $model,
            'child' => $child
        ];

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
        $model = Point::findOrFail($id);
        $model->delete();
    
        return response()->json(['success' => true]);
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
