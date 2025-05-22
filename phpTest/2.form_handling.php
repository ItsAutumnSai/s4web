<!DOCTYPE html>
<html>
<head>
    <title>Form Handling Sederhana</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: inline-block;
            width: 120px;
        }
        input[type="text"], 
        input[type="email"], 
        input[type="number"] {
            padding: 8px;
            width: 250px;
        }
        .result {
            background-color: #f5f5f5;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <h2>Form Input Data</h2>
    
    <?php
    // Inisialisasi variabel
    $nama = $email = $usia = $jenis_kelamin = '';
    $errors = [];
    
    // Cek apakah form disubmit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Ambil data dari form
        $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $usia = isset($_POST['usia']) ? trim($_POST['usia']) : '';
        $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
        
        // Validasi
        if (empty($nama)) {
            $errors['nama'] = 'Nama harus diisi';
        }
        
        if (empty($email)) {
            $errors['email'] = 'Email harus diisi';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid';
        }
        
        if (!empty($usia) && !is_numeric($usia)) {
            $errors['usia'] = 'Usia harus berupa angka';
        }
        
        // Jika tidak ada error, tampilkan hasil
        if (empty($errors)) {
            echo '<div class="result">';
            echo '<h3>Data yang Dikirim:</h3>';
            echo '<p><strong>Nama:</strong> ' . htmlspecialchars($nama) . '</p>';
            echo '<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>';
            echo '<p><strong>Usia:</strong> ' . htmlspecialchars($usia) . ' tahun</p>';
            echo '<p><strong>Jenis Kelamin:</strong> ' . htmlspecialchars($jenis_kelamin) . '</p>';
            echo '<p class="success">Data berhasil diterima!</p>';
            echo '</div>';
        }
    }
    ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group">
            <label for="nama">Nama Lengkap:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="usia">Usia:</label>
            <input type="number" id="usia" name="usia" min="1" max="120" value="<?php echo htmlspecialchars($usia); ?>">
        </div>
        
        <div class="form-group">
            <label>Jenis Kelamin:</label>
            <input type="radio" id="laki" name="jenis_kelamin" value="Laki-laki" <?php echo ($jenis_kelamin == 'Laki-laki') ? 'checked' : ''; ?>>
            <label for="laki">Laki-laki</label>
            <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan" <?php echo ($jenis_kelamin == 'Perempuan') ? 'checked' : ''; ?>>
            <label for="perempuan">Perempuan</label>
        </div>
        
        <div class="form-group">
            <input type="submit" value="Kirim Data">
        </div>
    </form>
</body>
</html>