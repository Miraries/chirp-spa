<?php
namespace App\Exports;

use App\Thread;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ThreadsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
	public function collection()
	{
		return Thread::all();
	}

	public function headings(): array
	{
		return [
			'#',
			'Author',
			'Title',
			'Body',
			'Date',
		];
	}

	public function map($row): array
	{
		return [
			$row->id,
			$row->author->name,
			$row->title,
			$row->body,
			Date::dateTimeToExcel($row->created_at)
		];
	}
}