<?php
session_start();
require_once("databaseConnection.php");

if (!isset($_SESSION["user"])) {
    $url = "attend.php?appid=" . $_GET["appid"] . "&day=" . $_GET["day"];
    header("Location: login.php?appid=" . $_GET["appid"] . "&day=" . $_GET["day"]);
}

if ((isset($_SESSION["user"]) && $_SESSION["user"]["appointment"] != null) || (!isset($_GET["appid"])) || (!isset($_GET["day"]))) {
    header("Location: index.php");
}

if (isset($_SESSION["user"]) && $_SESSION["user"]["email"] == "admin@nemkovid.hu") {
    header("Location: appinfo.php?appid=" . $_GET["appid"] . "&day=" . $_GET["day"]);
}


$errors = [];

$url = "attend.php?appid=" . $_GET["appid"] . "&day=" . $_GET["day"];
if (isset($_POST) && isset($_SESSION["user"]) && $_SESSION["user"]["appointment"] == null) {
    if (isset($_POST["approve"])) {
        if (!isset($_POST["check"])) {
            $errors[] = "Kérlek jelöld be, hogy elfogadod a feltételeket!";
        }

        if (count($errors) == 0) {
            //Időpont regisztrálás
            attendUser($_SESSION["user"]["email"], $_GET["appid"], $_GET["day"]);
            $_SESSION['user'] = updateUser($_SESSION["user"]["email"]);
            header("Location: index.php");
        }
    }
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
    <h1 class="h3 mb-3 fw-normal">Jelentkezés oltásra</h1>
    <?php
    if (count($errors)) {
        for ($i = 0; $i < count($errors); $i++) {
            echo "<p class='text-danger'>" . $errors[$i] . "</p>";
        }
    }
    ?>

    <form action="<?= $url ?>" method="post" novalidate>
        <?php
        if (isset($_SESSION["user"])) {
            echo "<p><b>Teljes név: </b>" . $_SESSION["user"]["name"] . "</p>";
            echo "<p><b>Cím: </b>" . $_SESSION["user"]["address"] . "</p>";
            echo "<p><b>TAJ: </b>" . $_SESSION["user"]["taj"] . "</p>";
            echo "<p><b>Időpont: </b>";
            $app = getAppointmentInfo($_GET["appid"], $_GET["day"]);
            echo $app["year"] . '.' . sprintf("%02s", $app["month"]) . '.' . sprintf("%02s", $app["day"]) . ' ' . sprintf("%02s", $app["hour"]) . ':' . sprintf("%02s", $app["min"]) . '</p>';

        }
        ?>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="check" name="check">
            <label class="form-check-label" for="check">Elfogadom a <a href="feltetelek.pdf" target="_blank">jelentkezési
                    feltételeket</a></label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit" name="approve">Jelentkezés megerősítése</button>
        <p class="mt-5 mb-3 text-muted">Nemzeti Koronavírus Depó - 2021</p>

    </form>


</main>


</body>

</html>
