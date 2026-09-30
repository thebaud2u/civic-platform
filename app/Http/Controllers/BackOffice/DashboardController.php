<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
	/**
	 * Admin dashboard
	 */
	public function index()
	{
		$countUsers = User::role(['agent', 'chef de service'])->count();

		return view('back-office.dashboard', [
			'countUsers' => $countUsers,
		]);
	}
}
