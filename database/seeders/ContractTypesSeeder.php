<?php

namespace Database\Seeders;

use App\Models\ContractType;
use Illuminate\Database\Seeder;

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
