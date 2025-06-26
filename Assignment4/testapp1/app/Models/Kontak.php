<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kontaks'; // nama tabel yang dihubungkan

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ // kolom yang akan diolah pada controller, jika mau ditambah maka tambahkan, namun untuk id tidak perlu, karena sudah automatis
        'nama',
        'alamat',
        'no_hp',
        'tanggal_lahir',
        'no_hp_darurat',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

    ];
}
