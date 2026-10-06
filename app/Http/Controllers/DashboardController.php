<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
	/**
	 * Display the user's dashboard.
	 */
	public function index(): View
	{
		$user = Auth::guard('web')->user();

		return view('dashboard', compact(
			'user'
		));
	}

	/**
	 * Display the user's requests.
	 */
	public function requests(): View
	{
		$user = Auth::guard('web')->user();

		return view('requests', compact(
			'user'
		));
	}
}
