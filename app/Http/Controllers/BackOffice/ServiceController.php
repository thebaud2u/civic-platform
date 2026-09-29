<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
	/**
	 * Display a listing of all services
	 *
	 * @return view
	 */
	public function index()
	{
		return view('back-office.services.index');
	}
}
