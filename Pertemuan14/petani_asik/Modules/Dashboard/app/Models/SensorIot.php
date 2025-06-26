<?php

namespace Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Dashboard\Database\Factories\SensorIotFactory;

class SensorIot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'sensor_iots';
    protected $fillable = [
        'iot_id', 'temperature', 'humidity', 'windspeed', 'rainfall',
        'light_intensity', 'ph', 'soil_moisture', 'ec', 'tds', 'soil_temp',
        'pressure', 'feromon', 'battery_level', 'signal_strength',
        'Nitrogen_Level', 'Phosphorus_Level', 'Potassium_Level'
    ];

    // protected static function newFactory(): SensorIotFactory
    // {
    //     // return SensorIotFactory::new();
    // }
    //public $timestamps = false; // ✅ Wajib kalau tidak ada kolom created_at dan updated_at

}
