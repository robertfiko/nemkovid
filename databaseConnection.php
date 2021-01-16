<?php
require_once("IFileIO.php");

function getTimeForDay($year, $month, $day) {
    $json = new JsonStorage('date.json');
    $return =  $json->query(function ($elem) use ($year, $month, $day) {
        return ($elem['year'] == $year) && ($elem['month'] == $month) && ($elem['day'] == $day);
    });

    return (count($return) > 0) ? array_values($return)[0]["appointments"] : NULL;

}
