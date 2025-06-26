<?php

namespace Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Dashboard\Database\Factories\SensorKameraFactory;

class SensorKamera extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'sensor_kameras';
    protected $fillable = [];

    // protected static function newFactory(): SensorKameraFactory
    // {
    //     // return SensorKameraFactory::new();
    // }
}
