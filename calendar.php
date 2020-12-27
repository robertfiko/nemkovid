<?php

$number_of_days = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
echo $number_of_days;


function getCurrentMonth($currentMonth, $year) {
    //Get the first day of the month and the number of days
    $date = mktime(12, 0, 0, $currentMonth, 1, $year);
    $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $year);

    //Get the offset to determine the "empty" columns
    $offset = date("w", $date);
    $offset = $offset == 0 ? 6 : $offset - 1;
    $row_number = 1;

    $calendar = new stdClass();
    $calendar->offset = $offset;



    for ($day = 1; $day <= $numberOfDays; $day++) {
        if (($day + $offset - 1) % 7 == 0 && $day != 1) {
            echo "</tr> <tr>";
            $row_number++;
        }
        echo "<td>" . $day . "</td>";
    }


    while (($day + $offset) <= $row_number * 7) {
        echo "<td></td>";
        $day++;
    }
    echo "</tr></table>";
}

?>
<html>
<head>
    <title>Calendar of the current month (Dec 2019)</title>
</head>
<body>
<p>Calendar of the Dec 2019</p>
<?php
// Dec 2019 in PHP
showCurrentMonth(12, 2020);
?>
</body>
</html>