<?php
require_once("IFileIO.php");

function getTimeForDay($year, $month, $day) {
    $json = new JsonStorage('date.json');
    $return =  $json->query(function ($elem) use ($year, $month, $day) {
        return ($elem['year'] == $year) && ($elem['month'] == $month) && ($elem['day'] == $day);
    });

    return (count($return) > 0) ? array_values($return)[0]["appointments"] : NULL;
}

function addNewUser($user, $customId = NULL) {
    $json = new JsonStorage('users.json');
    return $json->add($user, $customId);
}

function isRegistered($userEmailID) {
    $json = new JsonStorage('users.json');
    return $json->findById($userEmailID) == NULL ? false : true;
}
