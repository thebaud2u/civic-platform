<?php

namespace Database\Seeders;

use App\Models\{ContractType, Service, User, WorkSchedule, WorkScheduleType};
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

	private function chefsDeService(): void
	{
		$contractType = ContractType::where('name', 'CDI')
			->first();

		$workSchedule = WorkSchedule::where('name', 'Au forfait')
			->first();

		$workScheduleType = WorkScheduleType::where('name', 'Variable')
			->first();

		$service = Service::findBySlug('communication');

		$user = User::create([
			'gender' => 'mme',
			'first_name' => 'Malika',
			'last_name' => 'THIROLOIX',
			'email' => 'mthiroloix@mairie-marange-silvange.fr',
			'password' => Hash::make('test'),
			'contract_type_id' => $contractType->id,
			'work_schedule_id' => $workSchedule->id,
			'work_schedule_type_id' => $workScheduleType->id,
			'service_id' => $service->id,
		]);

		$user->assignRole('chef de service');
		$user->givePermissionTo('backoffice.access');
	}

	private function agents(): void
	{
		$contractType = ContractType::where('name', 'Contractuel')
			->first();

		$workSchedule = WorkSchedule::where('weekly_hours', 35)
			->first();

		$workScheduleType = WorkScheduleType::where('name', 'Variable')
			->first();

		$service = Service::findBySlug('communication');

		$manager = User::role('chef de service')
			->first();

		$user = User::create([
			'gender' => 'mme',
			'first_name' => 'Manon',
			'last_name' => 'Burus',
			'email' => 'mburus@mairie-marange-silvange.fr',
			'password' => Hash::make('test'),
			'contract_type_id' => $contractType->id,
			'work_schedule_id' => $workSchedule->id,
			'work_schedule_type_id' => $workScheduleType->id,
			'service_id' => $service->id,
			'manager_id' => $manager->id
		]);

		$user->assignRole('agent');
	}

	public function run(): void
	{
		$this->superAdmin();
		$this->chefsDeService();
		$this->agents();
	}
}
