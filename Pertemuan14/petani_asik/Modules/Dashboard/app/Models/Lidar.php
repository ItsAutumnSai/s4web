<?php

namespace Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Dashboard\Database\Factories\LidarFactory;

class Lidar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
     protected $table = 'lidars';
     protected $fillable = [];

    // protected static function newFactory(): LidarFactory
    // {
    //     // return LidarFactory::new();
    // }
}
