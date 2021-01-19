<?php
require_once("IFileIO.php");
function getTimeForDay($year, $month, $day) {
    $json = new JsonStorage('date.json');
    $return =  $json->query(function ($elem) use ($year, $month, $day) {
        return ($elem['year'] == $year) && ($elem['month'] == $month) && ($elem['day'] == $day);
    });

    if ((count($return) > 0)) {
        $appointments = array_values($return)[0]["appointments"];
        $returnapps = [];
        foreach ($appointments as &$value) {
            $value["current"] = count($value["attendees"]);
            $returnapps[] = $value;
        }
        unset($value);

        return $returnapps;
    }
    else {
        return NULL;
    }
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
    //Searching the corresponding date, if the day of the appointment has been set already
    $json = new JsonStorage('date.json');
    $year = $appointment->year;
    $month = $appointment->month;
    $day = $appointment->day;
    $elements =  $json->query(function ($elem) use ($year, $month, $day) {
        return ($elem['year'] == $year) && ($elem['month'] == $month) && ($elem['day'] == $day);
    });

    //If more then one day was found
    if (count($elements) > 1) {
        echo "Hiba!";
        return;
    }
    //Creating appointment data
    $app = new stdClass();
    $app->hour = $appointment->hour;
    $app->minute = $appointment->min;
    $app->limit = $appointment->limit;
    $app->attendees = [];
    $app->id = uniqid();
    $app->dayid = "no_id";

    //If the day has already has been set
    if (count($elements) == 1) {
        $newRecord = array_values($elements)[0];

        //Adding new appointment to that day
        $app->dayid = $newRecord["id"];
        $newRecord["appointments"][$app->id] = $app;
        $json->update($newRecord["id"],$newRecord);
        $json->save();
    }

    //If the day has not been created
    else if(count($elements) == 0) {
        //Creating day structure
        $info = new stdClass();
        $info->id = "no_id";
        $info->year = $appointment->year;
        $info->month = $appointment->month;
        $info->day = $appointment->day;
        $info->appointments = [];

        //Adding appointment
        $info->appointments[$app->id] = $app;
        $id = $json->add($info);

        //Cross referencing
        $info->appointments[$app->id]->dayid = $id;
        $json->findById($id)->id = $id;

    }

}

function attendUser($user, $appointment) {

}
