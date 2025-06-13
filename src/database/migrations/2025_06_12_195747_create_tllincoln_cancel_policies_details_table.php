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
        Schema::create('tllincoln_cancel_policy_details', function (Blueprint $table) {
            $table->id();
            $table->string('tllincoln_cancel_policy_id');
            $table->float('tllincoln_percent')->nullable();
            $table->float('tllincoln_amount')->nullable();
            $table->string('tllincoln_currency_code')->nullable();
            $table->string('tllincoln_from')->nullable();
            $table->string('tllincoln_to')->nullable();
            $table->timestamps();

            $table->index('tllincoln_cancel_policy_id', 'idx_tllincoln_cancel_policy_details_01');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tllincoln_cancel_policies_details');
    }
};
