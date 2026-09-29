<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Service;

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
