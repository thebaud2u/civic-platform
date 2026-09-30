<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
	public function run(): void
	{
        $data = ['Communication', 'RH'];

		foreach($data as $service) {
			$newService = new Service;
			$newService->name = $service;
			$newService->save();
		}
	}
}
