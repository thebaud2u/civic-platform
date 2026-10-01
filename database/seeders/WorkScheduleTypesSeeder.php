<?php

namespace Database\Seeders;

use App\Models\WorkScheduleType;
use Illuminate\Database\Seeder;

class WorkScheduleTypesSeeder extends Seeder
{
	public function run(): void
	{
		$data = [
			0 => [
				'name' => 'Fixe',
				'description' => 'Les horaires sont définis précisément et doivent être respectés sans décalage.'
			],
			1 => [
				'name' => 'Variable',
				'description' => 'Les horaires peuvent varier légèrement et permettent une certaine souplesse dans les heures d\'arrivée et de départ.'
			]
		];

		foreach($data as $workScheduleType) {
			$newWorkScheduleType = new WorkScheduleType;
			$newWorkScheduleType->name = $workScheduleType['name'];
			$newWorkScheduleType->description = $workScheduleType['description'];
			$newWorkScheduleType->save();
		}
	}
}
