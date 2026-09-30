<?php

namespace Database\Seeders;

use App\Models\WorkSchedule;
use Illuminate\Database\Seeder;

class WorkSchedulesSeeder extends Seeder
{
	public function run(): void
	{
		$data = [
			0 => [
				'name' => 'Temps complet 35h',
				'weekly_hours' => 35
			],
			1 => [
				'name' => 'Temps complet 39h',
				'weekly_hours' => 39
			],
			2 => [
				'name' => 'Au forfait',
				'weekly_hours' => null
			]
		];

		foreach($data as $workSchedule) {
			$newContractType = new WorkSchedule;
			$newContractType->name = $workSchedule['name'];
			$newContractType->weekly_hours = $workSchedule['weekly_hours'];
			$newContractType->save();
		}
	}
}
