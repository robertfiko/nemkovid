<?php
session_start();
require_once("databaseConnection.php");

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
}

if (isset($_SESSION["user"]) && $_SESSION["user"]["email"] != "admin@nemkovid.hu") {
    header("Location: index.php");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nem KOVID · Jelentkezés</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/login.css" rel="stylesheet">
</head>
<body class="text-center">

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">NemKoViD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault"
                aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">

        </div>
    </div>
</nav>

<main class="form-signin">
    <img class="mb-4" src="assets/covid.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 fw-normal">Időpont részletek</h1>
        <?php
        if (isset($_SESSION["user"])) {
            $app = getAppointmentInfo($_GET["appid"], $_GET["day"]);
            echo "<p><b>Időpont: </b>";
            echo $app["year"] . '.' . sprintf("%02s", $app["month"]) . '.' . sprintf("%02s", $app["day"]) . ' ' . sprintf("%02s", $app["hour"]) . ':' . sprintf("%02s", $app["min"]) . '</p>';

            foreach ($app["appoi"]["attendees"] as $attendee) {
                $user = getUser($attendee);
                echo '<p><b>'.$user["name"].'</b>: '.$user["taj"].' ('.$user["email"].')</p>';
            }

            if (count($app["appoi"]["attendees"]) == 0) {
                echo "<p>Erre az időpontra nincsen jelentkező!</p>";
            }

        }
        ?>

        <a href="index.php" class="w-100 btn btn-lg btn-outline-info" type="submit" name="approve">Vissza</a>
        <p class="mt-5 mb-3 text-muted">Nemzeti Koronavírus Depó - 2021</p>



</main>


</body>

</html>
