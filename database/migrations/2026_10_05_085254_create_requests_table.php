<?php

use App\Enums\{RequestStatus, RequestTypes};
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
		Schema::create('requests', function (Blueprint $table) {
			$table->id();
			$table->string('type')->default(RequestTypes::DayOff->value);
			$table->string('status')->default(RequestStatus::Pending->value);
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->date('start');
			$table->date('end')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('requests');
	}
};
