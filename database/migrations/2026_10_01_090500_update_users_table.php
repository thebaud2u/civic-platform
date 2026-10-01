<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->foreign('contract_type_id')->references('id')->on('contract_types')->nullOnDelete();
			$table->foreign('work_schedule_id')->references('id')->on('work_schedules')->nullOnDelete();
			$table->foreign('work_schedule_type_id')->references('id')->on('work_schedule_types')->nullOnDelete();
			$table->foreign('service_id')->references('id')->on('services')->nullOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropForeign(['service_id', 'work_schedule_id', 'work_schedule_type_id', 'contract_types']);
		});
	}
};
