<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
	/**
	 * Display the user's dashboard.
	 */
	public function index(): View
	{
		return view('dashboard');
	}
}
