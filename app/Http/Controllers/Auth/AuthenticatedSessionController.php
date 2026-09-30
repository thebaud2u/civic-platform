<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
	private function redirectByAccess(): RedirectResponse
	{
		return Auth::user()->can('backoffice.access')
			? redirect()->route('back-office.dashboard')
			: redirect()->route('dashboard');
	}

	/**
	 * Display the login view.
	 */
	public function create(): View|RedirectResponse
	{
		if (Auth::check()) {
			return $this->redirectByAccess();
		}

		return view('auth.login');
	}

	/**
	 * Handle an incoming authentication request.
	 */
	public function store(LoginRequest $request): RedirectResponse
	{
		$request->authenticate();

		$request->session()->regenerate();

		if(Auth::user()->hasRole('admin')) return redirect()->route('back-office.dashboard');
		else return redirect()->route('dashboard');
	}

	/**
	 * Destroy an authenticated session.
	 */
	public function destroy(Request $request): RedirectResponse
	{
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return redirect('/');
	}
}
