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

function checkUser($user) {
    $return = [
        "passed" => false,
        "errors" => [],
        "userdata" => NULL
    ];
    $json = new JsonStorage('users.json');
    if (isRegistered($user->email)) {
        $userDb = $json->findById($user->email);

        if ($userDb != NULL) {
            if (password_verify($user->password, $userDb["password"])) {
                $return["passed"] = true;
                $return["userdata"] = $userDb;
            }
            else {
                $return["errors"][] = "A megadott és a tárolt jelszó nem egyezik!";
            }
        }
    }
    else {
        $return["errors"][] = "Az adott e-mail címmel nincsen regisztrált felhasználó!";
    }

    return $return;

}

function recordNewAppointment($appointment) {
    $json = new JsonStorage('date.json');
    $year = $appointment->year;
    $month = $appointment->month;
    $day = $appointment->day;
    $elements =  $json->query(function ($elem) use ($year, $month, $day) {
        return ($elem['year'] == $year) && ($elem['month'] == $month) && ($elem['day'] == $day);
    });

    $app = new stdClass();
    $app->hour = $appointment->hour;
    $app->minute = $appointment->min;
    $app->limit = $appointment->limit;
    $app->current = 0;
    $app->attendees = [];

    if (count($elements) == 1) {
        array_values($elements)[0]["appointments"][] = $app;
        $json->save();
    }
    else if(count($elements) == 0) {
        $info = new stdClass();
        $info->id = $appointment->id;
        $info->year = $appointment->year;
        $info->month = $appointment->month;
        $info->day = $appointment->day;
        $info->appointments = [];
        $info->appointments[] = $app;
        $id = $json->add($info);
        $json->findById($id)->id = $id;
        echo "<script>alert('Új rekord létrehozva!')</script>";

    }
    else {
        echo "Hiba!";
    }
}

function attendUser($user, $appointment) {

}
