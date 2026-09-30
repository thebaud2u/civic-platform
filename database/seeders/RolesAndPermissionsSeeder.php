<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
	public function run(): void
	{
		Role::create(['name' => 'agent']);
		Role::create(['name' => 'chef de service']);
		Role::create(['name' => 'admin']);

		Permission::create(['name' => 'dayoff.read']);
		Permission::create(['name' => 'dayoff.create']);
		Permission::create(['name' => 'dayoff.update']);
		Permission::create(['name' => 'dayoff.delete']);

		Permission::create(['name' => 'backoffice.access']);

		$agent = Role::findByName('agent');
		$manager = Role::findByName('chef de service');
		$admin = Role::findByName('admin');

		$agent->givePermissionTo([
			'dayoff.read',
			'dayoff.create',
			'dayoff.update',
			'dayoff.delete',
		]);

		$manager->givePermissionTo([
			'dayoff.read',
			'dayoff.create',
			'dayoff.update',
			'dayoff.delete',
		]);

		$admin->givePermissionTo('backoffice.access');
	}
}