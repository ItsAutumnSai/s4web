<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'country',
        'tempat_lahir',
        'tanggal_lahir',
        'eyecolor',
        'haircolor',
    ];
}
