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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->bigIncrements('payment_request_id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('trip_id')->unsigned();
            $table->text('reference_code');
            $table->text('proofs');
            $table->text('description')->nullable();
            $table->decimal('total_rates_amount', 19,2);
            $table->enum('status', ['cancel', 'pending', 'done'])->default('pending');
            $table->text('reason')->nullable();
            $table->text('payment_proof')->nullable();
            $table->timestamps();
        });

        Schema::table('payment_requests', function (Blueprint $table) {
            $table->foreign('trip_id')->references('trip_id')->on('trip')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};
