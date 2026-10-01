<?php

namespace App\Livewire\BackOffice;

use App\Models\{ContractType, Service, User, WorkSchedule};
use App\Notifications\UserWelcome;
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
	public string $firstName = '';
	public string $lastName = '';
	public $email;
	public $birthday;
	public string $phone = '';
	public string $mobile = '';
	public string $serviceSelected = '';
	public string $managerSelected = '';
	public int $roleSelected = 0;
	public int $contractTypeSelected = 0;
	public int $workScheduleSelected = 0;

	public $isUserManagerOfAService = false;
	public $accountState = '';
	public $backOfficeAccessState = '';

	// Criterias
	public int $role = 0;
	public string $service = '';
	public string $manager = '';
	public int $contractType = 0;
	public int $workSchedule = 0;
	public string $keyword = '';

	public function toggleUser()
	{
		if($this->user->exists) {
			if($this->user->trashed()) $this->user->restore();
			else $this->user->delete();

			$this->dispatch('account-toggled');
			$this->fresh();
		}
	}

	public function toggleBackOfficeAccess()
	{
		if($this->user->exists) {
			if($this->user->can('backoffice.access')) $this->user->revokePermissionTo('backoffice.access');
			else $this->user->givePermissionTo('backoffice.access');

			$this->dispatch('back-office-access-toggled');
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

			if($modal == 'toggle-account' || $modal == 'toggle-back-office-access') {
				if($modal == 'toggle-account') {
					if($this->user->trashed()) $this->accountState = 'Activer le compte';
					else $this->accountState = 'Désactiver le compte';
				}
				elseif($modal == 'toggle-back-office-access') {
					if($this->user->can('backoffice.access')) $this->backOfficeAccessState = 'Révoquer l\'accès au back-office';
					else $this->backOfficeAccessState = 'Donner l\'accès au back-office';
				}
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
				$this->contractTypeSelected = $this->user->contractType?->id;
				$this->workScheduleSelected = $this->user->workSchedule?->id;

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
			'contractTypeSelected' => ['required', 'integer', 'exists:contract_types,id'],
			'workScheduleSelected' => ['required', 'integer', 'exists:work_schedules,id'],
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
			'contractTypeSelected.required' => 'Le type de contrat est obligatoire',
			'contractTypeSelected.exists' => 'Le type de contrat sélectionné est invalide',
			'workScheduleSelected.required' => 'Le régime de travail est obligatoire',
			'workScheduleSelected.exists' => 'Le régime de travail sélectionné est invalide',
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
				'contract_type_id' => ContractType::find($this->contractTypeSelected)?->id,
				'work_schedule_id' => WorkSchedule::find($this->workScheduleSelected)?->id,
				'password' => Hash::make(Str::password(12)),
				'values' => collect([])
			]);

			$user->assignRole($this->roleSelected);

			$token = Password::createToken($user);
			$user->notify(new UserWelcome($token));
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
			$this->user->contract_type_id = ContractType::find($this->contractTypeSelected)?->id;
			$this->user->work_schedule_id = WorkSchedule::find($this->workScheduleSelected)?->id;
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
			'serviceSelected',
			'contractTypeSelected',
			'workScheduleSelected',
		]);
		$this->resetValidation();
		$this->accountState = '';
		$this->isUserManagerOfAService = false;
		$this->dispatch('user-reset');
	}

	public function mount()
	{
		$this->fresh();
	}

	public function render()
	{
		$users = User::when($this->keyword, function($when) {
				$when->where('first_name', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('last_name', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('email', 'LIKE', '%'.$this->keyword.'%')
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
			}, function($default) {
				$default->role(['agent', 'chef de service']);
			})
			->when($this->contractType, function($when) {
				$when->whereHas('contractType', function($whereHas) {
					$whereHas->where('id', $this->contractType);
				});
			})
			->when($this->workSchedule, function($when) {
				$when->whereHas('workSchedule', function($whereHas) {
					$whereHas->where('id', $this->workSchedule);
				});
			})
			->orderBy('last_name')
			->orderBy('first_name')
			->withTrashed()
			->paginate(10);

		$roles = Role::whereIn('name', ['agent', 'chef de service'])
			->get();

		$services = Service::orderBy('name')
			->get();

		$managers = User::role('chef de service')
			->orderBy('last_name')
			->orderBy('first_name')
			->get();

		$contractTypes = ContractType::orderBy('name')
			->get();

		$workSchedules = WorkSchedule::orderBy('name')
			->get();

		return view('livewire.back-office.users', [
			'users' => $users,
			'roles' => $roles,
			'services' => $services,
			'managers' => $managers,
			'contractTypes' => $contractTypes,
			'workSchedules' => $workSchedules,
		]);
	}
}
