<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\WorkSchedule;

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
