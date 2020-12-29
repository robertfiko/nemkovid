<?php
function getCurrentMonth($currentMonth, $year) {
    //Get the first day of the month and the number of days
    $date = mktime(12, 0, 0, $currentMonth, 1, $year);
    $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $year);

    //Get the offset to determine the "empty" columns
    $offset = date("w", $date);
    $offset = $offset == 0 ? 6 : $offset - 1;
    $row_number = 1;

    $calendar = new stdClass();
    $calendar->year = intval($year);
    $calendar->month = intval($currentMonth);
    $calendar->offset = $offset;
    $calendar->numberOfDays = $numberOfDays;
    $calendar->days = [];

    for ($day = 1; $day <= $numberOfDays; $day++) {
        if (($day + $offset - 1) % 7 == 0 && $day != 1) {
            $row_number++;
        }
        $calendar->days[] = $day;
    }
    $calendar->rows = $row_number;
    return $calendar;
}

function getCurrentDate() {
    $curr = new stdClass();
    $curr->year = date("Y");
    $curr->month = date("m");
    $curr->day = date("j");
    return $curr;
}



if (isset($_GET)) {
    $response = json_decode(file_get_contents('php://input'), true);
    if (isset($_GET["function"]) && $_GET["function"] == "getCal") {
        echo json_encode(getCurrentMonth($response["month"], $response["year"]));
    }
    else if (isset($_GET["function"]) && $_GET["function"] == "current") {
        echo json_encode(getCurrentDate());
    }
}





