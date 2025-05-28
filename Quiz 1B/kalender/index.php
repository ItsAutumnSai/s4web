<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <?php
        //getting current dates
        date_default_timezone_set('Asia/Jakarta');
        $month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
        $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
        if ($month < 1) {
            $month = 12;
            $year--;
        } elseif ($month > 12) {
            $month = 1;
            $year++;
        }
        $today = date('Y-m-d');
        $current_month = date('n');
        $current_year = date('Y');
        $current_day = date('j');

        $month_names = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $display_month_name = $month_names[$month];
        $num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $first_day_of_month = date('w', mktime(0, 0, 0, $month, 1, $year));

        // Header with navigation
        echo '<h2>';
        echo '<form method="get" style="display:inline">';
        echo '<input type="hidden" name="month" value="' . ($month - 1) . '">';
        echo '<input type="hidden" name="year" value="' . $year . '">';
        echo '<button type="submit" class="arrow-btn" aria-label="Bulan sebelumnya">&#9664;</button>';
        echo '</form> ';
        echo $display_month_name . ' ' . $year;
        echo ' <form method="get" style="display:inline">';
        echo '<input type="hidden" name="month" value="' . ($month + 1) . '">';
        echo '<input type="hidden" name="year" value="' . $year . '">';
        echo '<button type="submit" class="arrow-btn" aria-label="Bulan berikutnya">&#9654;</button>';
        echo '</form>';
        echo '</h2>';

        echo '<table>';
        echo '<tr>';
        echo '<th>Minggu</th>';
        echo '<th>Senin</th>';
        echo '<th>Selasa</th>';
        echo '<th>Rabu</th>';
        echo '<th>Kamis</th>';
        echo '<th>Jum\'at</th>';
        echo '<th>Sabtu</th>';
        echo '</tr>';

        $day_counter = 1;
        echo '<tr>';

        for ($i = 0; $i < $first_day_of_month; $i++) {
            echo '<td></td>';
        }

        for ($day = 1; $day <= $num_days; $day++) {
            $class = '';
            if ($day == $current_day) {
                $class = 'marker';
            }
            echo '<td' . ($class ? ' class="' . $class . '"' : '') . '>' . $day . '</td>';

            if ((($day + $first_day_of_month) % 7 == 0) && $day < $num_days) {
                echo '</tr><tr>';
            }
        }

        $remaining_cells = 7 - (($num_days + $first_day_of_month) % 7);
        if ($remaining_cells < 7) {
            for ($i = 0; $i < $remaining_cells; $i++) {
                echo '<td></td>';
            }
        }
        echo '</tr>';
        echo '</table>';
        ?>
    </div>
</body>

</html>