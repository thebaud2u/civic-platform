<?php

namespace App\Livewire;

use App\Enums\{AbsencePeriod, AbsenceType};
use App\Models\{Absence, User};
use App\Support\FrenchHolidays;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Absences extends Component
{
	public User $user;

	// Properties
	public $typeSelected;
	public $start;
	public $startPeriodSelected;
	public $end;
	public $endPeriodSelected;

	// Lists
	public $users;

	// Misc
	public string $filterUserSelected = '';
	public int $weekNumber;
	public int $year;
	public $balance;

	private function absenceMinutes(): int
	{
		$start = Carbon::parse($this->start);
		$end = Carbon::parse($this->end);

		$isWorked = fn (Carbon $day) => $day->isWeekday() && !FrenchHolidays::isHoliday($day);

		$days = collect($start->daysUntil($end))->filter($isWorked)->count();

		if ($isWorked($start) && $this->startPeriodSelected === AbsencePeriod::Afternoon->value) {
			$days -= 0.5;
		}
		if ($isWorked($end) && $this->endPeriodSelected === AbsencePeriod::Morning->value) {
			$days -= 0.5;
		}

		$schedule = $this->user->workSchedule;

		if (!$schedule) {
			return 0;
		}

		return (int) round($days * $schedule->dailyMinutes());
	}

	public function updatedTypeSelected()
	{
		$type = AbsenceType::tryFrom($this->typeSelected ?? '');

		$this->balance = match ($type) {
			AbsenceType::DayOff => $this->user->dayOffBalance,
			AbsenceType::Recovery => $this->user->recoveryBalance,
			default => null,
		};

		$this->resetErrorBag('balance');
	}

	public function absenceForm()
	{
		$rules = [
			'typeSelected' => ['required', Rule::enum(AbsenceType::class)],
			'start' => ['required', 'date', 'lte:end'],
			'startPeriodSelected' => ['required', Rule::enum(AbsencePeriod::class)],
			'end' => ['required', 'date', 'gte:start'],
			'endPeriodSelected' => ['required', Rule::enum(AbsencePeriod::class),
				function (string $attribute, mixed $value, \Closure $fail) {
					if (
						$this->start === $this->end
						&& $this->startPeriodSelected === AbsencePeriod::Afternoon->value
						&& $value === AbsencePeriod::Morning->value
					) {
						$fail('Le matin de fin ne peut pas suivre un début l\'après-midi le même jour.');
					}
				}
			],
		];

		$messages = [
			'typeSelected.required' => 'Le type de demande est obligatoire.',
			'typeSelected.enum' => 'Le type de demande sélectionné est invalide.',
			'start.required' => 'La date de début est obligatoire.',
			'start.date' => 'La date de début n\'est pas une date valide.',
			'start.lte' => 'La date de début doit être antérieure ou égale à la date de fin.',
			'startPeriodSelected.required' => 'La période de début est obligatoire.',
			'startPeriodSelected.enum' => 'La période de début sélectionnée est invalide.',
			'end.required' => 'La date de fin est obligatoire.',
			'end.date' => 'La date de fin n\'est pas une date valide.',
			'end.gte' => 'La date de fin doit être postérieure ou égale à la date de début.',
			'endPeriodSelected.required' => 'La période de fin est obligatoire.',
			'endPeriodSelected.enum' => 'La période de fin sélectionnée est invalide.',
		];

		$this->validate($rules, $messages);

		$minutes = $this->absenceMinutes();

		if ($minutes <= 0) {
			$this->addError('balance', 'La période choisie ne contient aucun jour travaillé.');
			return;
		}

		if (!$this->balance || $minutes > $this->balance->minutes) {
			$this->addError('balance', 'Votre compteur n\'est pas suffisant pour votre demande.');
			return;
		}

		$absence = Absence::create([
			'type' => $this->typeSelected,
			'user_id' => $this->user->id,
			'start' => $this->start,
			'start_period' => $this->startPeriodSelected,
			'end' => $this->end,
			'end_period' => $this->endPeriodSelected,
		]);

		$this->balance->decrement('minutes', $minutes);

		$this->balance->transactions()->create([
			'absence_id' => $absence->id,
			'type' => $this->typeSelected,
			'minutes' => abs($minutes),
			'way' => 'minus',
		]);

		$this->dispatch('absence-form-complete');
	}

	public function previousMonth()
	{
		$date = Carbon::now();

		$date->setISODate($this->year, $this->weekNumber);
		$date->subMonth();

		$this->weekNumber = $date->isoWeek();
		$this->year = $date->isoWeekYear();
	}

	public function nextMonth()
	{
		$date = Carbon::now();

		$date->setISODate($this->year, $this->weekNumber);
		$date->addMonth();

		$this->weekNumber = $date->isoWeek();
		$this->year = $date->isoWeekYear();
	}

	public function fresh()
	{
		$this->reset([
			'typeSelected',
			'start',
			'startPeriodSelected',
			'end',
			'endPeriodSelected',
		]);
		$this->resetValidation();
		$this->resetErrorBag('balance');

		$this->startPeriodSelected = AbsencePeriod::Morning->value;
		$this->endPeriodSelected = AbsencePeriod::Afternoon->value;

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
		if ($this->filterUserSelected) $this->user = User::findBySlug($this->filterUserSelected);
		else $this->user = Auth::user();

		$weeklyTimeSummary = $this->user->weeklyTimeSummary($this->weekNumber, $this->year);

		return view('livewire.absences', [
			'user' => $this->user
		]);
	}
}
