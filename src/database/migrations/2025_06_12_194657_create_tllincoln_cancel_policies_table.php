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
        Schema::create('tllincoln_cancel_policies', function (Blueprint $table) {
            $table->id();
            $table->string('tllincoln_hotel_code');
            $table->string('tllincoln_cancel_policy_code');
            $table->text('tllincoln_cancel_policy_text')->nullable();
            $table->float('tllincoln_percent_no_show')->nullable();
            $table->float('tllincoln_amount_no_show')->nullable();
            $table->string('tllincoln_currency_code_no_show')->nullable();
            $table->timestamps();

            $table->unique(['tllincoln_hotel_code', 'tllincoln_cancel_policy_code'], 'idx_tllincoln_cancel_policy_01');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tllincoln_cancel_policies');
    }
};
