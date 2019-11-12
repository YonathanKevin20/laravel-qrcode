<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Exports\ChildrenExport;
use Illuminate\Http\Request;
use QrCode;

class ChildController extends Controller
{
    public function index(Request $req)
    {
        $grade = $req->grade ?? null;

        $model = Child::with(['grade']);

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
        Child::create([
            'name' => $req->name,
            'gender' => $req->gender,
            'place_of_birth' => $req->place_of_birth,
            'date_of_birth' => $req->date_of_birth,
            'address' => $req->address,
            'telephone' => $req->telephone,
            'father' => $req->father,
            'mother' => $req->mother,
            'school' => $req->school,
            'school_class' => $req->school_class,
            'grade_id' => $req->grade_id
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $model = Child::findOrFail($id);

        return response()->json($model);
    }

    public function update(Request $req, $id)
    {
        $model = Child::findOrFail($id);
        $model->update([
            'name' => $req->name,
            'gender' => $req->gender,
            'place_of_birth' => $req->place_of_birth,
            'date_of_birth' => $req->date_of_birth,
            'address' => $req->address,
            'telephone' => $req->telephone,
            'father' => $req->father,
            'mother' => $req->mother,
            'school' => $req->school,
            'school_class' => $req->school_class,
            'grade_id' => $req->grade_id
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $model = Child::findOrFail($id)->delete();
    
        return response()->json($model);
    }

    public function generateQrCode($id)
    {
        $model = Child::findOrFail($id);
        $data = url('api/child/'.$model->id);
        $qrcode = base64_encode(QrCode::format('png')->size(300)->margin(3)->generate($data));

        return response()->json($qrcode);
    }

    public function downloadQrCode($id)
    {
        $model = Child::findOrFail($id);
        $data = url('api/child/'.$model->id);
        $filename = 'qrcode_'.$model->id.'_'.$model->name.'.png';
        $qrcode = base64_encode(QrCode::format('png')->size(300)->margin(3)->generate($data, public_path('storage/qrcodes/'.$filename)));

        return response()->download(public_path('storage/qrcodes/'.$filename), $filename);
    }

    public function exportTemplatePoint()
    {
        return (new ChildrenExport)->download('template_import_point.xlsx');
    }
}
