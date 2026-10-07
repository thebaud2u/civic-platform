<?php

use App\Enums\AbsenceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('balances', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->string('type')->default(AbsenceType::DayOff->value);
			$table->integer('minutes')->default(0);
			$table->timestamps();

			$table->unique(['user_id', 'type']);
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('balances');
	}
};