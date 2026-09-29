<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;

class AdminsSeeder extends Seeder
{
	public function run(): void
	{
		$newAdmin = new Admin;
		$newAdmin->first_name = 'Jean-Clement';
		$newAdmin->last_name = 'Thebaud';
		$newAdmin->email = 'thebaud.clement@gmail.com';
		$newAdmin->password = Hash::make('KsL8aAffI4n0brGYEYZw');
		$newAdmin->save();

		$newAdmin->assignRole('super admin');
	}
}
