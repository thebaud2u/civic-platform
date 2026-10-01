<?php

namespace App\Livewire;

use App\Models\{User, Time};
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Times extends Component
{
	public User $user;

	// Properties
	public $date;
	public $way;
	public string $userSelected;

	// Lists
	public $users;

	// Misc
	public string $filterUserSelected = '';
	public int $weekNumber;
	public int $year;

	public function anomalyForm()
	{
		$rules = [
			'date' => ['required', 'date_format:Y-m-d\TH:i'],
			'way' => ['required', 'string', Rule::in(['in', 'out'])],
			'userSelected' => ['required', 'string',  'exists:users,slug']
		];

		$messages = [
			'date.required' => 'La date est obligatoire',
			'date.date_format' => 'Le format de la date est invalide',
			'way.required' => 'Le type est obligatoire',
			'way.in' => 'Le type sélectionné est invalide',
			'userSelected.required' => 'L\'agent sélectionné est obligatoire',
			'userSelected.exists' => 'L\'agent sélectionné est invalide',
		];

		$this->validate($rules, $messages);

		$user = Time::create([
			'date' => $this->date,
			'way' => $this->way,
			'user_id' => $this->userSelected
				? User::findBySlug($this->userSelected)?->id
				: null,
			'manager_id' => $this->user->id
		]);

		$this->dispatch('anomaly-form-complete');
	}

	public function previousWeek()
	{
		$date = Carbon::now();

		$date->setISODate($this->year, $this->weekNumber);
		$date->subWeek();

		$this->weekNumber = $date->isoWeek();
		$this->year = $date->isoWeekYear();
	}

	public function nextWeek()
	{
		$date = Carbon::now();

		$date->setISODate($this->year, $this->weekNumber);
		$date->addWeek();

		$this->weekNumber = $date->isoWeek();
		$this->year = $date->isoWeekYear();
	}

	public function fresh()
	{
		$this->reset([
			'date',
			'way',
			'userSelected'
		]);
		$this->resetValidation();

		$this->date = Carbon::now()->format('Y-m-d\TH:i');

		$this->dispatch('reset');
	}

	public function mount()
	{
		$this->user = Auth::user();
		$date = Carbon::now();

		$this->weekNumber = $date->isoWeek();
		$this->year = $date->isoWeekYear();
		$this->users = $this->user->users;
		$this->fresh();
	}

	public function render()
	{
		if($this->filterUserSelected) $this->user = User::findBySlug($this->filterUserSelected);
		else $this->user = Auth::user();

		$weeklyTimeSummary = $this->user->weeklyTimeSummary($this->weekNumber, $this->year);

		return view('livewire.times', [
			'user' => $this->user,
			'weeklyTimeSummary' => $weeklyTimeSummary
		]);
	}
}
