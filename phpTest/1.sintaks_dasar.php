<?php
// Menampilkan Output
echo "Halo Dunia!<br>"; // Menampilkan teks
print "Selamat belajar PHP<br>"; // Alternatif lain untuk menampilkan teks


// Variabel diawali dengan tanda $
$pecahan = 3.14;                 // angka desimal
$array = ["apel", "jeruk"];    // Tipe data array/
$angka = 10;         // Variabel angka
$teks = "Player 1";     // Variabel teks
$benar = true;       // Variabel boolean (true/false)
echo "Nama saya adalah " . $teks . "<br>";
echo "Saya Suka Makan " . $array[0] . "<br>";

// Operator matematika
$hasil = 5 + 3;   // Penjumlahan
$hasil = 5 - 3;   // Pengurangan
$hasil = 5 * 3;   // Perkalian
$hasil = 5 / 3;   // Pembagian

// Operator perbandingan
$lebih_besar = 5 > 3;    // true
$sama = 5 == "5";        // true (nilai sama)


// Percabangan (If-Else)
$nilai = 75;
if ($nilai >= 80) {
    echo "Nilai Anda A <br>";
} elseif ($nilai >= 70) {
    echo "Nilai Anda B <br>";
} else {
    echo "Nilai Anda C <br>";
}


// Perulangan for
for ($i = 1; $i <= 5; $i++) {
    echo "Ini perulangan for ke-$i <br>";
}

// Perulangan while
$j = 1;
while ($j <= 5) {
    echo "Ini perulangan while ke-$j <br>";
    $j++;
}

// DO-WHILE Loop
$counter = 1;
do {
    echo "Counter: $counter <br>";
    $counter++;
} while ($counter <= 5);


// Membuat fungsi
function sapa($nama) {
    return "Halo, " . $nama . "!" . "<br>";
}

// Memanggil fungsi
echo sapa("Player 1") ; // Output: Halo, Player 1!


$hari = "Mon";

switch ($hari) {
    case "Mon":
        echo "Hari Senin";
        break;
    case "Tue":
        echo "Hari Selasa";
        break;
    case "Wed":
        echo "Hari Rabu";
        break;
    default:
        echo "Hari lainnya";
}

//FOREACH Loop (untuk array)

$buah = array("Apel", "Jeruk", "Mangga");

foreach ($buah as $item) {
    echo "$item <br>";
}

// Dengan key dan value
$usia = array("Andi" => 25, "Budi" => 30);

foreach ($usia as $nama => $umur) {
    echo "$nama berusia $umur tahun <br>";
}


// Break dan Continue
for ($i = 1; $i <= 10; $i++) {
    if ($i == 5) {
        break; // Menghentikan loop saat $i == 5
    }
    echo "$i ";
} echo "<br>";
// Output: 1 2 3 4

for ($i = 1; $i <= 5; $i++) {
    if ($i == 3) {
        continue; // Lewati iterasi saat $i == 3
    }
    echo "$i ";
} echo "<br>";
// Output: 1 2 4 5



//Ternary Operator
$umur = 20;
$status = ($umur >= 18) ? "Dewasa" : "Anak-anak";
echo $status . "<br>"; // Output: Dewasa



// Null Coalescing Operator
$nilai = $_GET['nilai'] ?? 'default';
echo $nilai; // Output: 'default' jika $_GET['nilai'] tidak ada



echo "<br> <br>";

// Debuging Var Dump
$data = [
    'nama' => 'Andi',
    'usia' => 25,
    'pekerjaan' => 'Developer',
    'hobi' => ['coding', 'membaca', 'olahraga']
];

// Menampilkan informasi variabel secara detail
var_dump($data);

/* Output:
array(4) {
  ["nama"]=>
  string(4) "Andi"
  ["usia"]=>
  int(25)
  ["pekerjaan"]=>
  string(9) "Developer"
  ["hobi"]=>
  array(3) {
    [0]=>
    string(6) "coding"
    [1]=>
    string(7) "membaca"
    [2]=>
    string(9) "olahraga"
  }
}
*/

echo "<br> <br>";


// Debugging Exit (Die)
echo "Ini akan ditampilkan";
die(); // atau exit();
echo "Ini TIDAK akan ditampilkan";

?>
