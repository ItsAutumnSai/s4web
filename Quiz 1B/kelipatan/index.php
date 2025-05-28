<?php
$kelipatan = 0;

if (isset($_GET['kelipatan'])) {
    $inputKelipatan = $_GET['kelipatan'];

    if ($inputKelipatan === '' || $inputKelipatan === '0') {
        $all_green = true;
    } elseif (is_numeric($inputKelipatan) && $inputKelipatan >= 0) {
        $kelipatan = (int)$inputKelipatan;
        $all_green = false;
    }
} else {
    $all_green = true;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelipatan Angka</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="input-section">
            <form action="index.php" method="GET">
                <label for="kelipatan">Masukkan Kelipatan : </label>
                <input type="number" id="kelipatan" name="kelipatan" value="<?php echo htmlspecialchars($inputKelipatan ?? '0'); ?>">
                <button onclick="checkInput()">Kirim</button>
            </form>
        </div>

        <h2 id="judul-kelipatan">Kelipatan dari <?php echo $kelipatan; ?></h2>

        <table>
            <thead>
                <tr>
                    <th>Angka</th>
                    <th>Kelipatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 1; $i <= 40; $i++) {
                    $is_multiple = ($kelipatan != 0 && $i % $kelipatan == 0);
                    $class = ($all_green || $is_multiple) ? 'kelipatan-cell' : '';
                    echo "<tr>";
                    echo "<td>" . $i . "</td>";
                    echo "<td class='" . $class . "'>" . $i . " (kelipatan dari " . $kelipatan . ")</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const kelipatanVal = urlParams.get('kelipatan');
            const judulKelipatan = document.getElementById('judul-kelipatan');

            if (kelipatanVal === '' || (kelipatanVal !== null && parseInt(kelipatanVal) === 0)) {
                judulKelipatan.textContent = 'Kelipatan dari 0';
            } else if (kelipatanVal !== null && !isNaN(parseInt(kelipatanVal))) {
                judulKelipatan.textContent = `Kelipatan dari ${parseInt(kelipatanVal)}`;
            } else {
                judulKelipatan.textContent = 'Kelipatan dari 0';
            }
        });
        function checkInput() {
            const k = document.getElementById("kelipatan");
            if (k.value < 0) {
                k.setCustomValidity("Input tidak boleh negatif");
                k.reportValidity();
            } else {
                k.setCustomValidity("");
            }
        }
    </script>
</body>
</html>