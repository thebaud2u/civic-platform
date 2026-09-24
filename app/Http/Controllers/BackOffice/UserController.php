<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
	/**
	 * Display a listing of all users
	 *
	 * @return view
	 */
	public function index()
	{
		return view('back_office.users.index');
	}
}
