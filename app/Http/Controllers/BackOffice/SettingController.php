<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
	/**
	 * Display a listing of all settings
	 *
	 * @return view
	 */
	public function index()
	{
		return view('back-office.settings.index');
	}
}
