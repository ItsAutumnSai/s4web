<?php

namespace Modules\History\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\History\Database\Factories\HistoryiotFactory;

class Historyiot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'sensor_iots';
    protected $fillable = ['timestamp', 'temperature', 'humidity', 'windspeed', 'rainfall', 'light_intensity', 'ph', 'soil_moisture', 'ec', 'tds', 'soil_temp', 'pressure', 'feromon', 'battery_level', 'signal_strenght', 'Nitrogen_Level', 'Phosphorus_Level', 'Potassium_Level',  'iot_id'];


    // protected static function newFactory(): HistoryiotFactory
    // {
    //     // return HistoryiotFactory::new();
    // }
}
