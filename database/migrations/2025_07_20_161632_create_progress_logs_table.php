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
        Schema::create('progress_logs', function (Blueprint $table) {
            $table->id();

            $table->string('hash_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('training_id');
            $table->date('completion_date')->nullable();
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->integer('progress')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_logs');
    }
};
