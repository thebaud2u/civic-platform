<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
	/**
	 * Display the user's account form.
	 */
	public function edit(): View
	{
		return view('account.edit', [
			'user' => Auth::guard('web')->user()
		]);
	}
}
