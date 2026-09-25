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
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->enum('gender', ['mr', 'mme', 'autre']);
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->unique();
			$table->string('slug');
			$table->string('password');
			$table->rememberToken();
			$table->date('birthday')->nullable();
			$table->string('phone')->nullable();
			$table->string('mobile')->nullable();
			$table->json('values')->nullable();
			$table->foreignId('service_id')->nullable();
			$table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
			$table->timestamp('last_logon')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('password_reset_tokens', function (Blueprint $table) {
			$table->string('email')->primary();
			$table->string('token');
			$table->timestamp('created_at')->nullable();
		});

		Schema::create('sessions', function (Blueprint $table) {
			$table->string('id')->primary();
			$table->foreignId('user_id')->nullable()->index();
			$table->string('ip_address', 45)->nullable();
			$table->text('user_agent')->nullable();
			$table->longText('payload');
			$table->integer('last_activity')->index();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('users');
		Schema::dropIfExists('password_reset_tokens');
		Schema::dropIfExists('sessions');
	}
};
