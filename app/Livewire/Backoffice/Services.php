<?php

namespace App\Livewire\Backoffice;

use App\Models\{Service, User};
use Livewire\Component;
use Livewire\WithPagination;

class Services extends Component
{
	use WithPagination;

	public Service $service;

	// Properties
	public $name;
	public $description;
	public $managerSelected;

	// Criterias
	public $manager;
	public $keyword;

	protected function rules() {
		return [
			'name' => []
		];
	}

	public function getService($slug, $modal)
	{
		$service = Service::findBySlug($slug);

		if($service) {
			$this->service = $service;
			$this->name = $this->service->name;
			$this->description = $this->service->description;
			$this->managerSelected = $this->service->manager?->slug;

			$this->dispatch('open-modal', $modal);
		}
	}

	public function serviceForm()
	{
	   $rules = [
			'name' => ['required', 'max:255', 'unique:'.Service::class],
			'description' => ['nullable', 'string'],
			'managerSelected' => ['nullable', 'string', 'exists:users,slug'],
		];

		$messages = [
			'name.required' => 'Le libellé du service est obligatoire',
			'name.unique' => 'Un service existe déjà avec ce libellé',
			'name.max' => 'Le libellé du service ne doit pas dépasser 255 caractères',
			'managerSelected.exists' => 'Le chef de service sélectionné est invalide',
		];

		$this->validate($rules, $messages);

		// Create
		if(!$this->service->exists) {
			$service = Service::create([
				'name' => $this->name,
				'description' => $this->description,
				'manager_id' => $this->managerSelected
					? User::findBySlug($this->managerSelected)?->id
					: null,
			]);
		}
		// Update
		else {
			$this->service->name = $this->name;
			$this->service->description = $this->description;
			$this->service->manager_id = $this->managerSelected
				? User::findBySlug($this->managerSelected)?->id
				: null;
			$this->service->save();
		}

		$this->dispatch('service-form-complete');
		$this->fresh();
	}

	public function fresh()
	{
		$this->service = new Service;
		$this->reset([
			'name',
			'description',
			'managerSelected',
		]);
		$this->dispatch('service-reset');
	}

	public function mount()
	{
		$this->fresh();
	}

	public function render()
	{
		$services = Service::when($this->keyword, function($when) {
				$when->where('name', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('email', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('id', 'LIKE', '%'.$this->keyword.'%')
					->orWhere('slug', 'LIKE', '%'.$this->keyword.'%');
			})
			->when($this->manager, function($when) {
				$when->whereHas('manager', function($whereHas) {
					$whereHas->where('slug', $this->manager);
				});
			})
			->orderBy('name')
			->paginate(10);

		$managers = User::role('chef de service')
			->orderBy('last_name')
			->orderBy('first_name')
			->get();

		return view('livewire.back_office.services', [
			'services' => $services,
			'managers' => $managers
		]);
	}
}
