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
        Schema::create('performance_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->year('start_year'); // e.g., 2024
            $table->year('end_year');   // e.g., 2025
            $table->integer('current_step')->default(1);
            $table->foreignId('created_by')->constrained('users');
            $table->string('status')->default('draft');
            $table->foreignIdFor(\App\Models\User::class,'reviewer_id')->nullable()->constrained();
            $table->dateTime('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_contracts');
    }
};
