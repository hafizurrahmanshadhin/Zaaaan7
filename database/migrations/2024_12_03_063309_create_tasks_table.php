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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client')->comment('from users table');
            $table->unsignedBigInteger('helper')->comment('from users table')->nullable();

            $table->foreignId('address_id')->constrained('addresses')->cascadeOnDelete();
            $table->foreignId('sub_category_id')->constrained('sub_categories')->cascadeOnDelete();

            $table->enum('status', ['pending', 'accepted', 'in process', 'completed', 'expired'])->default('pending');
            $table->longText('description')->comment('task description');
            $table->date('date');
            $table->time('time');

            $table->foreign('client')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('helper')->references('id')->on('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
