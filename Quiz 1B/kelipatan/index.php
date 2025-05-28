<?php
$kelipatan = 1;

if (isset($_GET['kelipatan'])) {
    $inputKelipatan = $_GET['kelipatan'];

    if ($inputKelipatan === '' || $inputKelipatan === '0') {
        $kelipatan = 1;
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
    <div class="wrapper">
        <h2>Masukkan Kelipatan</h2>
        <div class="input-section">
            <form action="index.php" method="GET">
                <label for="kelipatan">Masukkan Kelipatan: </label>
                <input type="number" id="kelipatan" name="kelipatan" value="<?php echo htmlspecialchars($inputKelipatan ?? '0'); ?>">
                <button type="submit" onclick="checkInput()">Kirim</button>
            </form>
        </div>
        <h4 id="judul-kelipatan">
            Kelipatan dari <?php echo $all_green ? 'Semua' : $kelipatan; ?>
        </h4>
        <table>
            <tr>
                <th>Angka</th>
                <th>Kelipatan</th>
            </tr>
            <?php
            for ($i = 1; $i <= 40; $i++) {
                $is_multiple = ($kelipatan != 0 && $i % $kelipatan == 0);
                $class = ($all_green || $is_multiple) ? 'marker' : '';
                $statement = ($all_green || $is_multiple) ? $i." (kelipatan dari ".$kelipatan.")" : $i;
                echo "<tr>";
                echo "<td>$i</td>";
                echo "<td class='$class'>" .$statement.
                "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <script>
        function checkInput() {
            const k = document.getElementById("kelipatan");
            if (k.value < 0) {
                k.setCustomValidity("Input tidak boleh negatif");
                k.reportValidity();
            } else {
                k.setCustomValidity("");
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const kelipatanVal = urlParams.get('kelipatan');
            const judulKelipatan = document.getElementById('judul-kelipatan');
            if (kelipatanVal === '' || (kelipatanVal !== null && parseInt(kelipatanVal) === 0)) {
                judulKelipatan.textContent = 'Kelipatan dari Semua';
            } else if (kelipatanVal !== null && !isNaN(parseInt(kelipatanVal))) {
                judulKelipatan.textContent = `Kelipatan dari ${parseInt(kelipatanVal)}`;
            } else {
                judulKelipatan.textContent = 'Kelipatan dari Semua';
            }
        });
    </script>
</body>
</html>