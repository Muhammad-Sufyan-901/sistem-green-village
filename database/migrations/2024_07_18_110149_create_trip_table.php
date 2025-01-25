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
        Schema::create('trip', function (Blueprint $table) {
            $table->bigIncrements('trip_id');
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('driver_id')->unsigned();
            $table->bigInteger('type_trip_id')->unsigned();
            $table->string('name');
            $table->text('itinerary');
            $table->date('from_date');
            $table->date('until_date');
            $table->time('departure_time');
            $table->enum('status', ['cancel', 'pending', 'active', 'on-progress', 'done'])->default('pending');
            $table->time('return_time')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip');
    }
};
