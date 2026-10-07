<?php

use App\Enums\{AbsencePeriod, AbsenceStatus, AbsenceType};
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
		Schema::create('absences', function (Blueprint $table) {
			$table->id();
			$table->string('type')->default(AbsenceType::DayOff->value);
			$table->string('status')->default(AbsenceStatus::Pending->value);
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->date('start');
			$table->string('start_period')->default(AbsencePeriod::Morning->value);
			$table->date('end')->nullable();
			$table->string('end_period')->default(AbsencePeriod::Afternoon->value);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('absences');
	}
};
