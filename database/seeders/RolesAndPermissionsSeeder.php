<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
	public function run(): void
	{
		Role::create(['name' => 'agent', 'guard_name' => 'web']);
		Role::create(['name' => 'manager', 'guard_name' => 'web']);
		Role::create(['name' => 'admin', 'guard_name' => 'admin']);

		Permission::create(['name' => 'dayOff.read']);
		Permission::create(['name' => 'dayOff.create']);
		Permission::create(['name' => 'dayOff.update']);
		Permission::create(['name' => 'dayOff.delete']);

		$agent = Role::findByName('agent');
		$manager = Role::findByName('manager');

		$agent->givePermissionTo([
			'dayOff.read',
			'dayOff.create',
			'dayOff.update',
			'dayOff.delete',
		]);

		$manager->givePermissionTo([
			'dayOff.read',
			'dayOff.create',
			'dayOff.update',
			'dayOff.delete',
		]);
	}
}