<?php

namespace Modules\Yolo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Yolo\Database\Factories\HistoryYoloFactory;

class HistoryYolo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'sensor_kameras';
    protected $fillable = [];

    // protected static function newFactory(): HistoryYoloFactory
    // {
    //     // return HistoryYoloFactory::new();
    // }
}
