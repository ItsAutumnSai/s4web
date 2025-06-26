database/migrations/xxxx_create_mahasiswas_table.php:

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) { // yang berarti menyuruh untuk membuatkan tabel 'mahasiswas' di DB, sesuai isi kolom dibawah ini, yang mana Laravel secara otomatis menambahkan‘s’.
            $table->id(); // seting id biarkan seperti ini karena otomatis AI
            $table->string('nama'); //tipe string membuat varchar(255)
            $table->string('nim')->unique(); // dibuat unik di DB
            $table->string('prodi');
            $table->timestamps(); // waktu saat pengisian
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswas'); //jika sudah ada dan akan ada pembaruan maka akan ditimpa migration yang baru.
    }
};
