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
        Schema::create('lidars', function (Blueprint $table) {
            $table->id();
            $table->text('iot_id');
            $table->decimal('distance', 5, 2);
            $table->integer('movement_detected');
            $table->text('servo_position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lidars');
    }
};
