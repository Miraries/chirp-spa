<?php
namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
	public function collection()
	{
		return User::all();
	}

	public function headings(): array
	{
		return [
			'#',
			'Name',
			'Email',
			'Registered Date',
			'Updated Date',
		];
	}

	public function map($row): array
	{
		return [
			$row->id,
			$row->name,
			$row->email,
			Date::dateTimeToExcel($row->created_at),
			Date::dateTimeToExcel($row->updated_at)
		];
	}
}