<?php

use App\Enums\AbsenceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('balance_transactions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('absence_id')->comment('Est précisé si est lié à une demande d\'absence sinon null')->nullable()->constrained()->cascadeOnDelete();
			$table->foreignId('balance_id')->constrained()->cascadeOnDelete();
			$table->foreignId('manager_id')->comment('Est précisé si un manager corrige une anomalie de badgeage sinon null')->nullable()->constrained('users')->nullOnDelete();
			$table->string('type')->default(AbsenceType::DayOff->value);
			$table->date('date')->nullable();
			$table->unsignedInteger('minutes');
			$table->enum('way', ['plus', 'minus']);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('balance_transactions');
	}
};