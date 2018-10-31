<?php

namespace App\Http\Controllers;

use App\Exports\ThreadsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
	public function threads_xlsx()
	{
		return Excel::download(new ThreadsExport(), 'threads.xlsx');
	}

	public function users_xlsx()
	{
		return Excel::download(new ThreadsExport(), 'users.xlsx');
	}
}
