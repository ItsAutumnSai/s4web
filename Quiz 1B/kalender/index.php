<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="calendar-container">
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

        //key & values
        $month_names = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $display_month_name = $month_names[$month];
        //untuk mendapatkan jumlah hari dalam bulan tertentu
        $num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        //untuk tahu hari apa tanggal 1 bisa ditaruh dalam tabel
        $first_day_of_month = date('w', mktime(0, 0, 0, $month, 1, $year));

        //function back and forth untuk bulan
        $prev_month_link = '?month=' . ($month - 1) . '&year=' . $year;
        $next_month_link = '?month=' . ($month + 1) . '&year=' . $year;

        echo '<div class="navigation">';
        echo '<a href="' . $prev_month_link . '">&lt;&lt; Bulan Sebelumnya</a>';
        echo '<span class="current-month-year">' . $display_month_name . ' ' . $year . '</span>';
        echo '<a href="' . $next_month_link . '">Bulan Berikutnya &gt;&gt;</a>';
        echo '</div>';

        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Minggu</th>';
        echo '<th>Senin</th>';
        echo '<th>Selasa</th>';
        echo '<th>Rabu</th>';
        echo '<th>Kamis</th>';
        echo '<th>Jumat</th>';
        echo '<th>Sabtu</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $day_counter = 1;
        echo '<tr>';

        for ($i = 0; $i < $first_day_of_month; $i++) {
            echo '<td></td>';
        }

        for ($day = 1; $day <= $num_days; $day++) {
            $full_date = $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day);
            $class = '';

            if ($day == $current_day) {  
                $class = 'today';
            }

            echo '<td class="' . $class . '">' . $day . '</td>';

            if (($day + $first_day_of_month) % 7 == 0 && $day < $num_days) {
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
        echo '</tbody>';
        echo '</table>';
        ?>
    </div>
</body>

</html>