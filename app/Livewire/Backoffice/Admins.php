<?php

namespace App\Livewire\BackOffice;

use App\Models\Admin;
use App\Notifications\AdminWelcome;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Admins extends Component
{
	use WithPagination;

	public Admin $admin;

	// Properties
	public $gender = 'mr';
	public $firstName;
	public $lastName;
	public $email;

    public $switchState = '';

	// Criterias
	public $keyword;

	public function toggleAdmin()
	{
		if($this->admin->exists) {
			if($this->admin->trashed()) $this->admin->restore();
			else $this->admin->delete();

			$this->dispatch('account-toggled');
			$this->fresh();
		}
	}

	public function resetPassword()
	{
		if($this->admin->exists) {
			$token = Password::createToken($this->admin);
			$this->admin->sendPasswordResetNotification($token);

			$this->dispatch('password-changed');
			$this->fresh();
		}
	}

	public function getAdmin($slug, $modal)
	{
		$admin = Admin::findBySlug($slug, ['*'], fn ($query) => $query->withTrashed());

		if($admin) {
			$this->admin = $admin;

			if($modal == 'toggle-account') {
				if($this->admin->trashed()) $this->switchState = 'Activer le compte';
				else $this->switchState = 'Désactiver le compte';
			}
			elseif($modal == 'admin-form') {
				$this->resetValidation();

				$this->gender = $this->admin->gender;
				$this->email = $this->admin->email;
				$this->firstName = $this->admin->first_name;
				$this->lastName = $this->admin->last_name;
			}

			$this->dispatch('open-modal', $modal);
		}
	}

	public function adminForm()
	{
	   	$rules = [
			'firstName' => ['required', 'string', 'max:255'],
			'lastName' => ['required', 'string', 'max:255'],
			'email' => [
				'required',
				'string',
				'lowercase',
				'email',
				'max:255',
				Rule::unique(Admin::class)->ignore($this->admin?->id),
			],
		];

		$messages = [
			'firstName.required' => 'Le prénom est obligatoire',
			'firstName.max' => 'Le prénom ne doit pas dépasser 255 caractères',
			'lastName.required' => 'Le nom est obligatoire',
			'lastName.max' => 'Le nom ne doit pas dépasser 255 caractères',
			'email.required' => 'L\'adresse email est obligatoire',
			'email.email' => 'L\'adresse email n\'est pas valide',
			'email.max' => 'L\'adresse email ne doit pas dépasser 255 caractères',
			'email.unique' => 'Un utilisateur existe déjà avec cette adresse email',
		];

		$this->validate($rules, $messages);

		// Create
		if(!$this->admin->exists) {
			$admin = Admin::create([
				'first_name' => $this->firstName,
				'last_name' => $this->lastName,
				'email' => $this->email,
				'password' => Hash::make(Str::password(12)),
			]);

			$admin->assignRole('admin');

			$token = Password::broker('admins')->createToken($admin);
			$admin->notify(new AdminWelcome($token));
		}
		// Update
		else {
			$this->admin->first_name = $this->firstName;
			$this->admin->last_name = $this->lastName;
			$this->admin->email = $this->email;
			$this->admin->save();
		}

		$this->dispatch('admin-form-complete');
		$this->fresh();
	}

	public function fresh()
	{
		$this->admin = new Admin;
		$this->reset([
			'firstName',
			'lastName',
			'email'
		]);
		$this->resetValidation();
        $this->switchState = '';
		$this->dispatch('admin-reset');
	}

	public function mount()
	{
		$this->fresh();
	}

	public function render()
	{
		$admins = Admin::when($this->keyword, function($when) {
				$when->where('first_name', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('last_name', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('email', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('id', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('slug', 'LIKE', '%'.$this->keyword.'%');
			})
			->whereHas('roles', function($whereHas) {
				$whereHas->where('name', 'admin');
			})
			->orderBy('last_name')
			->orderBy('first_name')
			->withTrashed()
			->paginate(10);

		return view('livewire.back-office.admins', [
			'admins' => $admins,
		]);
	}
}
