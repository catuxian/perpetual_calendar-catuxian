<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .title {
            background-image: url("https://picsum.photos/500/400/?random=1");
        }
    </style>
    <title>月曆</title>
</head>

<body>
    <?php
    date_default_timezone_set("Asia/Taipei");
    $today = date('Y-m-d');
    $thisYear = isset($_GET['thisYear']) ? $_GET['thisYear'] : date('Y');
    // echo "今年為" . $thisYear . "<br>";
    $thisMonth = isset($_GET['thisMonth']) ? $_GET['thisMonth'] : date('m');
    // echo "這個月為" . $thisMonth . "月<br>";
    $monthDays = date('t', strtotime("{$thisYear}-{$thisMonth}"));
    // echo "這個月為".date('F',strtotime("{$thisYear}-{$thisMonth}"))."<br>";
    // echo "這個月天數為" . $monthDays . "天<br>";
    $firstDay = strtotime(date('Y-m-') . "1"); //這個月中的第一天(unix時間戳)
    $firstDayWeek = date('w', strtotime("{$thisYear}-{$thisMonth}-1"));
    // echo "這個月的第一天是星期" . $firstDayWeek . "<br>"; 
    if (($firstDayWeek >= 5 && $monthDays == 31) || ($monthDays == 28 && $firstDayWeek > 0) || ($firstDayWeek > 5 && $monthDays == 30)) {
        $monthWeeks = ceil($monthDays / 7) + 1;
    } else {
        $monthWeeks = ceil($monthDays / 7);
    }
    if ($thisMonth == 1) {
        $preMonth = 12;
        $preYear = $thisYear - 1;
    } else {
        $preMonth = $thisMonth - 1;
        $preYear = $thisYear;
    }
    if ($thisMonth == 12) {
        $nextMonth = 1;
        $nextYear = $thisYear + 1;
    } else {
        $nextMonth = $thisMonth + 1;
        $nextYear = $thisYear;
    }
    ?>

    <div class="container">
        <div class="title-wrapper">
            <div class="title">
                <div class="year"><?php echo $thisYear; ?></div>
                <div class="link">
                    <?php echo "<a href='index.php?thisYear={$preYear}&thisMonth={$preMonth}'>" ?><span class="material-icons">navigate_before</span></a>
                    <div class="month"><?php echo date('F', strtotime("{$thisYear}-{$thisMonth}")); ?></div>
                    <?php echo "<a href='index.php?thisYear={$nextYear}&thisMonth={$nextMonth}'>" ?><span class="material-icons">navigate_next</span></a>
                </div>
            </div>
        </div>

        <table>
            <tr class="week">
                <td>Sun</td>
                <td>Mon</td>
                <td>Tue</td>
                <td>Wen</td>
                <td>Thu</td>
                <td>Fri</td>
                <td>Sat</td>
            </tr>
            <?php
            for ($i = 0; $i < $monthWeeks; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= 7; $j++) {
                    if (($i * 7 + $j - $firstDayWeek) > $monthDays || ($i == 0 && $j <= $firstDayWeek)) {
                        echo "<td>" . "&nbsp" . "</td>";
                    } else if ($j == 1 || $j == 7) {
                        echo "<td class='holiday'>" . ($i * 7 + $j - $firstDayWeek) . "</td>";
                    } else if ($thisYear == date('Y') && $thisMonth == Date('m') && $j == (date('w') + 1) && $i == floor(date('d') / 7)) {
                        echo "<td class='today'>" . ($i * 7 + $j - $firstDayWeek) . "</td>";
                    } else {
                        echo "<td>" . ($i * 7 + $j - $firstDayWeek) . "</td>";
                    }
                }
                echo "</tr>";
            }
            ?>

        </table>
        <div class="footer"></div>
    </div>
</body>

</html>