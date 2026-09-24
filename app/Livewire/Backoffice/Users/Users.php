<?php

namespace App\Livewire\Backoffice\Users;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Users extends Component
{
	use WithPagination;

	public User $user;

	// Criterias
	public $role;
	public $keyword;

	public $switchState = '';

	protected function rules() {
		return [
			'email' => []
		];
	}

	public function toggleUser()
	{
		if($this->user->exists) {
			if($this->user->trashed()) $this->user->restore();
			else $this->user->delete();

			$this->dispatch('account-toggled');
			$this->fresh();
		}
	}

	public function resetPassword()
	{
		if($this->user->exists) {
			$token = Password::createToken($this->user);
			$this->user->sendPasswordResetNotification($token);

			$this->dispatch('password-changed');
			$this->fresh();
		}
	}

	public function getUser($id, $modal)
	{
		$user = User::withTrashed()->find($id);

		if($user) {
			$this->user = $user;

			if($modal == 'toggle-account') {
				if($this->user->trashed()) $this->switchState = 'Activer le compte';
				else $this->switchState = 'Désactiver le compte';
			}

			$this->dispatch('open-modal', $modal);
		}
	}

	public function fresh()
	{
		$this->user = new User;
		$this->switchState = '';
		$this->dispatch('user-reset');
	}

	public function mount()
	{
		$this->fresh();
	}

	public function render()
	{
		$users = User::distinct('users.id')
			->when($this->keyword, function($when) {
				$when->where('name', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('email', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('id', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('slug', 'LIKE', '%'.$this->keyword.'%');
			})
			->when($this->role, function($when) {
				$when->whereHas('roles', function($whereHas) {
					$whereHas->where('id', $this->role);
				});
			})
			->orderByDesc('last_logon')
			->withTrashed()
			->paginate(10);

		$roles = Role::where('guard_name', 'web')
			->get();

		return view('livewire.back_office.users.users', [
			'users' => $users,
			'roles' => $roles
		]);
	}
}
