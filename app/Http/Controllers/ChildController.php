<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Exports\ChildrenExport;
use Illuminate\Http\Request;
use QrCode;

class ChildController extends Controller
{
    public function index()
    {
        $model = Child::orderBy('grade')->get();

        return response()->json($model);
    }

    public function store(Request $req)
    {
        Child::create([
            'name' => $req->name,
            'gender' => $req->gender,
            'place_of_birth' => $req->place_of_birth,
            'date_of_birth' => $req->date_of_birth,
            'grade' => $req->grade,
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
            'grade' => $req->grade,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $model = Child::findOrFail($id);
        $model->delete();
    
        return response()->json(['success' => true]);
    }

    public function generateQrCode($id)
    {
        $model = Child::findOrFail($id);
        $qrcode = base64_encode(QrCode::format('png')->size(300)->margin(3)->generate(url('api/child/'.$model->id)));

        return response()->json($qrcode);
    }

    public function downloadQrCode($id)
    {
        $model = Child::findOrFail($id);
        $filename = 'qrcode_'.$model->id.'.png';
        $qrcode = base64_encode(QrCode::format('png')->size(300)->margin(3)->generate(url($model->id), public_path('storage/qrcodes/'.$filename)));

        return response()->download(public_path('storage/qrcodes/'.$filename), $filename);
    }

    public function exportTemplatePoint()
    {
        return (new ChildrenExport)->download('template_import_point.xlsx');
    }
}
