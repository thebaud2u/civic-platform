<?php

use App\Enums\RequestTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('balance_transactions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->foreignId('balance_id')->constrained()->cascadeOnDelete();
			$table->foreignId('request_id')->nullable()->constrained()->cascadeOnDelete();
			$table->string('type')->default(RequestTypes::DayOff->value);
			$table->date('date');
			$table->unsignedInteger('minutes');
			$table->enum('way', ['plus', 'minus']);
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('balance_transactions');
	}
};