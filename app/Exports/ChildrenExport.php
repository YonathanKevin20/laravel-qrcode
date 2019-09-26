<?php

namespace App\Exports;

use App\Models\Child;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ChildrenExport implements FromCollection, WithHeadings, WithMapping
{
	use Exportable;

	public function headings(): array
	{
		return [
			'#',
			'NAMA',
			'QTY',
		];
	}

	public function map($model): array
    {
        return [
            $model->index,
            $model->name,
        ];
    }

	public function collection()
	{
		$model = Child::orderBy('name')->get(['name']);

		$i = 1;
		foreach($model as $m) {
			$m->index = $i++;
		}

		return $model;
	}
}
