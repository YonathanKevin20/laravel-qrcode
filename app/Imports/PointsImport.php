<?php

namespace App\Imports;

use App\Models\Child;
use App\Models\InfoPoint;
use App\Models\Point;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PointsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function model(array $row)
    {
        $name = strtolower($row['name']);
        $child = Child::whereRaw('LOWER(name) LIKE (?)', ["%{$name}%"])->first(['id']);
        $info_point = InfoPoint::whereRaw('LOWER(name) LIKE (?)', ["%import%"])->first(['id']);

        if($child) {
            return new Point([
                'child_id' => $child->id,
                'qty' => $row['qty'],
                'info_point_id' => $info_point->id,
                'time' => time()
            ]);
        }
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
