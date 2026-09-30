<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$this->call([
			RolesAndPermissionsSeeder::class,
			ContractTypesSeeder::class,
			WorkSchedulesSeeder::class,
			ServicesSeeder::class,
			UsersSeeder::class,
			TimesSeeder::class,
		]);
	}
}
