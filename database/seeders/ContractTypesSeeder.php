<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ContractType;

class ContractTypesSeeder extends Seeder
{
	public function run(): void
	{
		$data = ['CDI', 'CDD', 'Titulaire', 'Contractuel'];

		foreach($data as $contractType) {
			$newContractType = new ContractType;
			$newContractType->name = $contractType;
			$newContractType->save();
		}
	}
}
