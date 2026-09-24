<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Admin;
use App\Models\User;

class AuthController extends Controller
{
	public function index(): View|RedirectResponse
	{
		if(!Auth::guard('admin')->check()) return view('back_office.index');
		else return redirect()->intended(route('back-office.dashboard'));
	}

	public function store(Request $request): RedirectResponse
	{
		$rules = [
			'email' => 'required',
			'password' => 'required'
		];

		$messages = [
			'email.required' => 'Votre adresse email est obligatoire',
			'password.required' => 'Votre mot de passe est obligatoire'
		];

		$credentials = $request->validate($rules, $messages);

		$remember = $request->filled('remember');

		if(Auth::guard('admin')->attempt($credentials, $remember)) {
			$request->session()->regenerate();

			return redirect()->intended(route('back-office.dashboard'));
		}

		return redirect(route('back-office.index'))->withErrors(['email' => 'Les informations fournies ne correspondent pas.']);
	}

	public function logAsUser(User $user)
	{
		Auth::guard('web')->login($user);

		return redirect()->route('dashboard');
	}

	public function signOutAsUser()
	{
		Auth::guard('web')->logout();

		return redirect()->route('back-office.dashboard');
	}

	/**
	 * Logout
	 * ('admin' web guard)
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logout(Request $request)
	{
		Auth::guard('admin')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return redirect()->route('home');
	}
}
