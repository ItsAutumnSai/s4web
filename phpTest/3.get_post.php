<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form GET & POST</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            color: #333;
        }
        .container {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #2c3e50;
        }
        form {
            margin-bottom: 20px;
            padding: 15px;
            background: #fff;
            border-radius: 5px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background: #2980b9;
        }
        .result {
            padding: 15px;
            background: #e8f4fc;
            border-radius: 5px;
            margin-top: 20px;
        }
        .tabs {
            display: flex;
            margin-bottom: 20px;
        }
        .tab {
            padding: 10px 20px;
            background: #ddd;
            cursor: pointer;
            margin-right: 5px;
            border-radius: 5px 5px 0 0;
        }
        .tab.active {
            background: #f9f9f9;
            font-weight: bold;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Form GET dan POST</h1>
        
        <div class="tabs">
            <div class="tab active" onclick="showTab('get-form')">Form GET</div>
            <div class="tab" onclick="showTab('post-form')">Form POST</div>
            <div class="tab" onclick="showTab('result')">Hasil</div>
        </div>
        
        <!-- Form dengan metode GET -->
        <div id="get-form" class="tab-content active">
            <h2>Form dengan Metode GET</h2>
            <p>Data dikirim melalui URL (terlihat di address bar browser)</p>
            
            <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" name="form_type" value="get">
                
                <label for="get_name">Nama:</label>
                <input type="text" id="get_name" name="get_name" required>
                
                <label for="get_email">Email:</label>
                <input type="email" id="get_email" name="get_email" required>
                
                <label for="get_gender">Jenis Kelamin:</label>
                <select id="get_gender" name="get_gender">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                
                <input type="submit" value="Kirim (GET)">
            </form>
        </div>
        
        <!-- Form dengan metode POST -->
        <div id="post-form" class="tab-content">
            <h2>Form dengan Metode POST</h2>
            <p>Data dikirim secara tidak terlihat (tidak muncul di URL)</p>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" name="form_type" value="post">
                
                <label for="post_username">Username:</label>
                <input type="text" id="post_username" name="post_username" required>
                
                <label for="post_password">Password:</label>
                <input type="password" id="post_password" name="post_password" required>
                
                <label for="post_bio">Bio Singkat:</label>
                <textarea id="post_bio" name="post_bio" rows="4"></textarea>
                
                <input type="submit" value="Kirim (POST)">
            </form>
        </div>
        
        <!-- Area untuk menampilkan hasil -->
        <div id="result" class="tab-content">
            <h2>Hasil Form Submission</h2>
            <div class="result">
                <?php
                // Proses data form GET
                if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['form_type']) && $_GET['form_type'] == 'get') {
                    echo "<h3>Data dari Form GET:</h3>";
                    echo "<p><strong>Nama:</strong> " . htmlspecialchars($_GET['get_name'] ?? '') . "</p>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($_GET['get_email'] ?? '') . "</p>";
                    echo "<p><strong>Jenis Kelamin:</strong> " . htmlspecialchars($_GET['get_gender'] ?? '') . "</p>";
                }
                
                // Proses data form POST
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_type']) && $_POST['form_type'] == 'post') {
                    echo "<h3>Data dari Form POST:</h3>";
                    echo "<p><strong>Username:</strong> " . htmlspecialchars($_POST['post_username'] ?? '') . "</p>";
                    echo "<p><strong>Password:</strong> " . (!empty($_POST['post_password']) ? '*****' : '') . "</p>";
                    echo "<p><strong>Bio:</strong> " . nl2br(htmlspecialchars($_POST['post_bio'] ?? '')) . "</p>";
                }
                
                ?>
            </div>
        </div>
    </div>
    
    <script>
        // Fungsi untuk menampilkan tab yang dipilih
        function showTab(tabId) {
            // Sembunyikan semua tab content
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Tampilkan tab yang dipilih
            document.getElementById(tabId).classList.add('active');
            
            // Update tab yang aktif
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
        }
        
        // Jika ada data yang dikirim, tampilkan tab hasil
        <?php if (isset($_GET['form_type']) || isset($_POST['form_type'])): ?>
            document.addEventListener('DOMContentLoaded', function() {
                showTab('result');
            });
        <?php endif; ?>
    </script>
</body>
</html>