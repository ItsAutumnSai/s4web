<?php

namespace Modules\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Data\Database\Factories\UserFactory;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'users';
    protected $fillable = [];

    // protected static function newFactory(): UserFactory
    // {
    //     // return UserFactory::new();
    // }
}
