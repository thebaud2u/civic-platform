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
		$weeklyTimeSummary = $user->weeklyTimeSummary();

		return view('dashboard', compact(
			'user',
			'weeklyTimeSummary'
		));
	}
}
