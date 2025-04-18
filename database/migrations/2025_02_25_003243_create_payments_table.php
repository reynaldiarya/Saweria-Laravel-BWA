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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid()->primary()->unique();
            $table->foreignUuid('donation_id')->references('uuid')->on('donations')->restrictOnDelete();
            $table->string('payment_id')->unique();
            $table->string('payment_method');
            $table->string('status');
            $table->text('payment_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
