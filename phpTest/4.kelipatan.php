<!DOCTYPE html>
<html>
<head>
    <title>Cek Kelipatan</title>
</head>
<body>
<?php
$kelipatan = $_POST['kelipatan'] ?? 0;
?>   
    <form method="post">
        Masukkan angka: <input type="number" name="kelipatan" required>
        <input type="submit" value="Cek">
    </form>

    <?php if ($kelipatan > 0): ?>
        <h3>Kelipatan dari <?= $kelipatan ?>:</h3>
        <?php for ($i = 1; $i <= 100; $i++): ?>
            <?php if ($i % $kelipatan == 0): ?>
                <p><?= $i ?> (Terpilih)</p>
            <?php else: ?>
                <p><?= $i ?></p>
            <?php endif; ?>
        <?php endfor; ?>
    <?php endif; ?>
</body>
</html>