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
        Schema::create('tllincoln_cancel_policy_plans', function (Blueprint $table) {
            $table->id();
            $table->string('tllincoln_cancel_policy_id');
            $table->string('tllincoln_plan_code');
            $table->timestamps();

            $table->index('tllincoln_cancel_policy_id', 'idx_tllincoln_cancel_policy_plans_01');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tllincoln_cancel_policy_plans');
    }
};
