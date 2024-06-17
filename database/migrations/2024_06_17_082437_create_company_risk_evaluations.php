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
        Schema::create('company_risk_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_risk_id')->constrained('company_risks');
            $table->foreignId('author_id')->constrained('users');
            $table->integer('probability');
            $table->integer('impact');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_risk_evaluations');
    }
};
