<?php

use App\Enums\LevelsTrainingEnum;
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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('hash_id')->unique();
            $table->string('name');
            $table->string('subname')->nullable();
            $table->text('description')->nullable();
            $table->string('equipment')->nullable();
            $table->integer('meta_days')->nullable();
            $table->enum('level', LevelsTrainingEnum::forSelectName())->default(LevelsTrainingEnum::BEGINNER);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
