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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->unsignedBigInteger('client')->comment('from users table');
            $table->unsignedBigInteger('helper')->comment('from users table');
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->float('amount');
            $table->foreign('client')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('helper')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
