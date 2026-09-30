<?php

namespace Database\Seeders;

use App\Models\{ContractType, Time, Service, User, WorkSchedule};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TimesSeeder extends Seeder
{
	public function run(): void
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
			'password' => Hash::make('test1234'),
			'contract_type_id' => $contractType->id,
			'work_schedule_id' => $workSchedule->id,
			'service_id' => $service->id,
		]);

		$user->assignRole('agent');

		$startOfWeek = now()->startOfWeek();

		/*
		 * Lundi :
		 * 08:00 IN
		 * 12:00 OUT
		 * 13:00 IN
		 *
		 * Le OUT de l'après-midi est oublié.
		 */
		$monday = $startOfWeek->copy();

		$this->createTime($user, $monday->copy()->setTime(8, 5), 'in');
		$this->createTime($user, $monday->copy()->setTime(12, 2), 'out');
		$this->createTime($user, $monday->copy()->setTime(13, 1), 'in');

		/*
		 * Mardi :
		 * 08:00 OUT
		 *
		 * La badgeuse considère ce badge comme un OUT,
		 * puisqu'elle était restée en état IN depuis lundi.
		 *
		 * Puis la journée reprend normalement.
		 */
		$tuesday = $startOfWeek->copy()->addDay();

		$this->createTime($user, $tuesday->copy()->setTime(8, 0), 'out');
		$this->createTime($user, $tuesday->copy()->setTime(9, 0), 'in');
		$this->createTime($user, $tuesday->copy()->setTime(12, 5), 'out');
		$this->createTime($user, $tuesday->copy()->setTime(13, 2), 'in');
		$this->createTime($user, $tuesday->copy()->setTime(17, 0), 'out');

		/*
		 * Mercredi :
		 * Plusieurs périodes dans la journée.
		 */
		$wednesday = $startOfWeek->copy()->addDays(2);

		$this->createTime($user, $wednesday->copy()->setTime(8, 10), 'in');
		$this->createTime($user, $wednesday->copy()->setTime(10, 15), 'out');
		$this->createTime($user, $wednesday->copy()->setTime(10, 30), 'in');
		$this->createTime($user, $wednesday->copy()->setTime(12, 0), 'out');
		$this->createTime($user, $wednesday->copy()->setTime(13, 0), 'in');
		$this->createTime($user, $wednesday->copy()->setTime(17, 0), 'out');

		/*
		 * Jeudi :
		 * Journée normale.
		 */
		$thursday = $startOfWeek->copy()->addDays(3);

		$this->createTime($user, $thursday->copy()->setTime(8, 0), 'in');
		$this->createTime($user, $thursday->copy()->setTime(12, 0), 'out');
		$this->createTime($user, $thursday->copy()->setTime(13, 0), 'in');
		$this->createTime($user, $thursday->copy()->setTime(17, 30), 'out');

		/*
		 * Vendredi :
		 * Journée normale.
		 */
		$friday = $startOfWeek->copy()->addDays(4);

		$this->createTime($user, $friday->copy()->setTime(8, 15), 'in');
		$this->createTime($user, $friday->copy()->setTime(12, 0), 'out');
		$this->createTime($user, $friday->copy()->setTime(13, 0), 'in');
		$this->createTime($user, $friday->copy()->setTime(16, 40), 'out');
	}

	private function createTime(User $user, $date, string $way): void
	{
		Time::create([
			'user_id' => $user->id,
			'way' => $way,
			'created_at' => $date,
			'updated_at' => $date,
		]);
	}
}