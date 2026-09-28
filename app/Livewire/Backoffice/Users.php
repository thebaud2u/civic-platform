<?php

namespace App\Livewire\Backoffice;

use App\Models\{Service, User};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Users extends Component
{
	use WithPagination;

	public User $user;

	// Properties
	public $gender = 'mr';
	public $firstName;
	public $lastName;
	public $email;
	public $birthday;
	public $phone;
	public $mobile;
	public $serviceSelected;
	public $managerSelected;
	public $roleSelected;

	public $isUserManagerOfAService = false;

	// Criterias
	public $role;
	public $service;
	public $manager;
	public $keyword;

	public $switchState = '';

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

	public function getUser($slug, $modal)
	{
		$user = User::findBySlug($slug, ['*'], fn ($query) => $query->withTrashed());

		if($user) {
			$this->user = $user;

			if($modal == 'toggle-account') {
				if($this->user->trashed()) $this->switchState = 'Activer le compte';
				else $this->switchState = 'Désactiver le compte';
			}
			elseif($modal == 'user-form') {
				$this->resetValidation();

				$this->gender = $this->user->gender;
				$this->email = $this->user->email;
				$this->firstName = $this->user->first_name;
				$this->lastName = $this->user->last_name;
				$this->birthday = $this->user->birthday?->format('Y-m-d');
				$this->phone = $this->user->phone;
				$this->mobile = $this->user->mobile;
				$this->roleSelected = $this->user->getRoleNames()->first();
				$this->serviceSelected = $this->user->managedService?->slug;
				$this->managerSelected = $this->user->manager?->slug;

				$this->isUserManagerOfAService = $this->user->managedService()->exists();
			}

			$this->dispatch('open-modal', $modal);
		}
	}

	public function userForm()
	{
		$rolesAllowed = Role::where('guard_name', 'web')
			->pluck('name')
			->toArray();

	   	$rules = [
			'gender' => ['required', 'string', Rule::in(['mr', 'mme', 'autre'])],
			'firstName' => ['required', 'string', 'max:255'],
			'lastName' => ['required', 'string', 'max:255'],
			'email' => [
				'required',
				'string',
				'lowercase',
				'email',
				'max:255',
				Rule::unique(User::class)->ignore($this->user?->id),
			],
			'birthday' => ['nullable', 'date', 'before:today'],
			'phone' => ['nullable', 'string', 'max:20'],
			'mobile' => ['nullable', 'string', 'max:20'],
			'roleSelected' => ['required', Rule::in($rolesAllowed)],
			'serviceSelected' => ['nullable', 'string', 'exists:services,slug'],
			'managerSelected' => ['nullable', 'string', 'exists:users,slug'],
		];

		$messages = [
			'gender.required' => 'La civilité est obligatoire',
			'gender.in' => 'La civilité sélectionnée est invalide',
			'firstName.required' => 'Le prénom est obligatoire',
			'firstName.max' => 'Le prénom ne doit pas dépasser 255 caractères',
			'lastName.required' => 'Le nom est obligatoire',
			'lastName.max' => 'Le nom ne doit pas dépasser 255 caractères',
			'email.required' => 'L\'adresse email est obligatoire',
			'email.email' => 'L\'adresse email n\'est pas valide',
			'email.max' => 'L\'adresse email ne doit pas dépasser 255 caractères',
			'email.unique' => 'Un utilisateur existe déjà avec cette adresse email',
			'birthday.date' => 'La date de naissance n\'est pas valide',
			'birthday.before' => 'La date de naissance doit être antérieure à aujourd\'hui',
			'phone.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères',
			'mobile.max' => 'Le numéro de mobile ne doit pas dépasser 20 caractères',
			'roleSelected.required' => 'Le rôle est obligatoire pour l\'utilisateur',
			'roleSelected.in' => 'Le rôle sélectionné est invalide',
			'serviceSelected.exists' => 'Le service sélectionné est invalide',
			'managerSelected.exists' => 'Le chef de service sélectionné est invalide',
		];

		$this->validate($rules, $messages);

		// Create
		if(!$this->user->exists) {
			$user = User::create([
				'gender' => $this->gender,
				'first_name' => $this->firstName,
				'last_name' => $this->lastName,
				'email' => $this->email,
				'birthday' => $this->birthday,
				'phone' => $this->phone,
				'mobile' => $this->mobile,
				'service_id' => $this->serviceSelected
					? Service::findBySlug($this->serviceSelected)?->id
					: null,
				'manager_id' => $this->managerSelected
					? User::findBySlug($this->managerSelected)?->id
					: null,
				'password' => Hash::make(Str::password(12)),
				'values' => collect([])
			]);

			$user->assignRole($this->roleSelected);

			$token = Password::createToken($user);
			$user->sendPasswordResetNotification($token);
		}
		// Update
		else {
			$this->user->gender = $this->gender;
			$this->user->first_name = $this->firstName;
			$this->user->last_name = $this->lastName;
			$this->user->email = $this->email;
			$this->user->birthday = $this->birthday;
			$this->user->phone = $this->phone;
			$this->user->mobile = $this->mobile;
			$this->user->service_id = $this->serviceSelected
				? Service::findBySlug($this->serviceSelected)?->id
				: null;
			$this->user->manager_id = $this->managerSelected
				? User::findBySlug($this->managerSelected)?->id
				: null;
			$this->user->save();

			$this->user->syncRoles($this->roleSelected);

			if($this->roleSelected !== 'chef de service') {
				$this->user->managedService()->update(['manager_id' => null]);
			}
		}

		$this->dispatch('user-form-complete');
		$this->fresh();
	}

	public function fresh()
	{
		$this->user = new User;
		$this->reset([
			'gender',
			'firstName',
			'lastName',
			'email',
			'birthday',
			'phone',
			'mobile',
			'roleSelected',
			'managerSelected',
			'serviceSelected'
		]);
		$this->resetValidation();
		$this->switchState = '';
		$this->isUserManagerOfAService = false;
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
				$when->where('first_name', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('last_name', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('email', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('id', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('slug', 'LIKE', '%'.$this->keyword.'%');
			})
			->when($this->role, function($when) {
				$when->whereHas('roles', function($whereHas) {
					$whereHas->where('id', $this->role);
				});
			})
			->when($this->service, function($when) {
				$when->whereHas('service', function($whereHas) {
					$whereHas->where('slug', $this->service);
				});
			})
			->when($this->manager, function($when) {
				$when->whereHas('manager', function($whereHas) {
					$whereHas->where('slug', $this->manager);
				});
			})
			->orderByDesc('last_logon')
			->withTrashed()
			->paginate(10);

		$roles = Role::where('guard_name', 'web')
			->get();

		$services = Service::orderBy('name')
			->get();

		$managers = User::role('chef de service')
			->orderBy('last_name')
			->orderBy('first_name')
			->get();

		return view('livewire.back_office.users', [
			'users' => $users,
			'roles' => $roles,
			'services' => $services,
			'managers' => $managers
		]);
	}
}
