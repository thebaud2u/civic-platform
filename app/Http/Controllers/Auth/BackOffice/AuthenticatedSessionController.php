<?php

namespace App\Http\Controllers\Auth\BackOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\BackOffice\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
	/**
	 * Display the login view.
	 */
	public function create(): View
	{
		return view('auth.back-office.login');
	}

	/**
	 * Handle an incoming authentication request.
	 */
	public function store(LoginRequest $request): RedirectResponse
	{
		$request->authenticate();

		$request->session()->regenerate();

		return redirect()->intended(route('back-office.dashboard', absolute: false));
	}

	/**
	 * Destroy an authenticated session.
	 */
	public function destroy(Request $request): RedirectResponse
	{
		Auth::guard('admin')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return redirect('/');
	}
}
