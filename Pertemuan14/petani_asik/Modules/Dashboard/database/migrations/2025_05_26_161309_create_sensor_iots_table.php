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
        Schema::create('sensor_iots', function (Blueprint $table) {
            $table->id();
            $table->text('iot_id'); // Hardware ID
            $table->decimal('temperature', 5, 2); // Temperature in °C
            $table->decimal('humidity', 5, 2); // Humidity in %
            $table->decimal('windspeed', 5, 2); // Wind speed in m/s
            $table->decimal('rainfall', 5, 2); // Rainfall in mm
            $table->integer('light_intensity'); // Light intensity in lux
            $table->decimal('ph',  5, 1); // pH level
            $table->decimal('soil_moisture', 5, 2); // Soil moisture in %
            $table->decimal('ec', 5, 2); // Electrical conductivity (EC) in dS/m
            $table->decimal('tds', 5, 2); //TDS
            $table->decimal('soil_temp', 5, 2); // Soil temperature in °C
            $table->decimal('pressure', 5, 2); // Pressure in hPa or Pa
            $table->integer('feromon');
            $table->integer('battery_level'); // Battery level in percentage
            $table->integer('signal_strength'); // Signal strength in dBm
            $table->decimal('Nitrogen_Level', 5, 2); // Soil temperature in °C
            $table->decimal('Phosphorus_Level', 5, 2); // Soil temperature in °C
            $table->decimal('Potassium_Level', 5, 2); // Soil temperature in °C
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_iots');
    }
};
