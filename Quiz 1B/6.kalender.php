<!DOCTYPE html>
<html>
<head>
    <title>Kalender Sederhana</title>
</head>
<body>

<?php
// Perintah Waktu di PHP:
// // Mendapatkan timestamp saat ini (jumlah detik sejak 1 Januari 1970)
// time();
// // Mendapatkan tanggal dan waktu saat ini dalam format tertentu
// date('Y-m-d H:i:s'); // Format standar: 2023-05-20 14:30:15
// // Membuat timestamp dari format tanggal tertentu
// strtotime('2023-05-20'); // Mengubah string tanggal ke timestamp

// date('Y'); // Tahun 4 digit (2023)
// date('y'); // Tahun 2 digit (23)
// date('m'); // Bulan 2 digit (01-12)
// date('n'); // Bulan tanpa 0 di depan (1-12)
// date('F'); // Nama bulan (January-December)
// date('M'); // Singkatan bulan (Jan-Dec)
// date('d'); // Hari dalam bulan 2 digit (01-31)
// date('j'); // Hari tanpa 0 di depan (1-31)
// date('D'); // Singkatan hari (Mon-Sun)
// date('l'); // Nama hari lengkap (Monday-Sunday)
// date('H'); // Jam 24 jam (00-23)
// date('h'); // Jam 12 jam (01-12)
// date('i'); // Menit (00-59)
// date('s'); // Detik (00-59)
// date('a'); // am/pm
// date('A'); // AM/PM


 //* BAGIAN 1: MENGAMBIL BULAN DAN TAHUN YANG AKAN DITAMPILKAN

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('n'); // n = format bulan (1-12)
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Y = format tahun 4 digit


//  * BAGIAN 2: PENYESUAIAN BULAN DAN TAHUN
if ($bulan < 1) {
    $bulan = 12; // Desember
    $tahun--; // Tahun sebelumnya
} 
if ($bulan > 12) {
    $bulan = 1; // Januari
    $tahun++; // Tahun berikutnya
}


//  * BAGIAN 3: DAFTAR NAMA BULAN
$nama_bulan = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
];

/*
 * BAGIAN 4: MENGHITUNG JUMLAH HARI DALAM BULAN
 * - Fungsi date('t') menghitung jumlah hari dalam bulan tertentu
 * - strtotime mengubah format tanggal menjadi timestamp
 */
$jumlah_hari = date('t', strtotime("$tahun-$bulan-01")); // Contoh: "2024-05-21"

/*
 * BAGIAN 5: MENENTUKAN HARI PERTAMA BULAN
 * - date('w') mengembalikan angka 0 (Minggu) sampai 6 (Sabtu)
 * - Menentukan hari apa tanggal 1 jatuh pada bulan tersebut
 */
$hari_pertama = date('w', strtotime("$tahun-$bulan-01")); // 0=Minggu, 1=Senin, dst
?>

<!-- BAGIAN 6: TAMPILAN KALENDER -->
<h2>Kalender <?php echo $nama_bulan[$bulan-1]." ".$tahun; ?></h2>

<!-- 
    BAGIAN 7: TOMBOL NAVIGASI 
    - Tombol "Bulan Sebelumnya" mengurangi nilai bulan
    - Tombol "Bulan Berikutnya" menambah nilai bulan
-->
<div>
    <a href="?bulan=<?php echo $bulan-1; ?>&tahun=<?php echo $tahun; ?>">
        Bulan Sebelumnya
    </a>
    |
    <a href="?bulan=<?php echo $bulan+1; ?>&tahun=<?php echo $tahun; ?>">
        Bulan Berikutnya
    </a>
</div>

<!-- BAGIAN 8: TABEL KALENDER -->
<table border="1">
    <!-- Baris header nama hari -->
    <tr>
        <th>Minggu</th><th>Senin</th><th>Selasa</th><th>Rabu</th>
        <th>Kamis</th><th>Jum'at</th><th>Sabtu</th>
    </tr>
    
    <tr>
        <?php
        /* 
         * BAGIAN 9: MENGISI SEL KOSONG SEBELUM TANGGAL 1
         * - Loop untuk mengisi sel kosong di awal kalender
         * - Jumlah sel kosong = hari pertama bulan tersebut
         */
        for ($i = 0; $i < $hari_pertama; $i++) {
            echo "<td></td>"; // Sel kosong
        }
        
        /* 
         * BAGIAN 10: MENAMPILKAN SEMUA HARI DALAM BULAN
         * - Loop dari tanggal 1 sampai jumlah hari dalam bulan
         * - Setiap tanggal ditampilkan dalam sel tabel
         */
        for ($hari = 1; $hari <= $jumlah_hari; $hari++) {
            // Jika hari ini sama dengan tanggal yang sedang diproses
            // DAN bulan dan tahun juga sama dengan saat ini
            if ($hari == date('j') && $bulan == date('n') && $tahun == date('Y')) {
                echo "<td><strong>$hari</strong></td>"; // Tandai dengan tebal
            } else {
                echo "<td>$hari</td>"; // Tampilkan normal
            }
            
            /* 
             * BAGIAN 11: PINDAH BARIS SETIAP AKHIR MINGGU
             * - Jika (tanggal + hari pertama) habis dibagi 7
             * - Artinya sudah sampai hari Sabtu (akhir minggu)
             */
            if (($hari + $hari_pertama) % 7 == 0) {
                echo "</tr><tr>"; // Tutup baris, buka baris baru
            }
        }
        ?>
    </tr>
</table>

</body>
</html>