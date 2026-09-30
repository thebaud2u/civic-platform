<?php

namespace Database\Seeders;

use App\Models\{ContractType, Service, User, WorkSchedule};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
	private function superAdmin(): void
	{
		$user = User::create([
			'gender' => 'mr',
			'first_name' => 'Jean-Clement',
			'last_name' => 'Thébaud',
			'email' => 'thebaud.clement@gmail.com',
			'password' => Hash::make('test'),
		]);

		$user->assignRole('admin');
	}

	private function agents(): void
	{
		$contractType = ContractType::where('name', 'Contractuel')
			->first();

		$workSchedule = WorkSchedule::where('weekly_hours', 35)
			->first();

		$service = Service::findBySlug('communication');

		$user = User::create([
			'gender' => 'mme',
			'first_name' => 'Manon',
			'last_name' => 'Burus',
			'email' => 'manonburus@live.fr',
			'password' => Hash::make('test'),
			'contract_type_id' => $contractType->id,
			'work_schedule_id' => $workSchedule->id,
			'service_id' => $service->id,
		]);

		$user->assignRole('agent');
		$user->givePermissionTo('backoffice.access');
	}

	public function run(): void
	{
		$this->superAdmin();
		$this->agents();
	}
}
