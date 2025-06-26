<?php

namespace Modules\Pendaftaran\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Pendaftaran\Database\Factories\DaftarFactory;

class Daftar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): DaftarFactory
    // {
    //     // return DaftarFactory::new();
    // }
}
