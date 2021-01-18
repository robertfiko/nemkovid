<?php
session_start();
require("databaseConnection.php");


//TODO: Finish and check

if (isset($_POST)) {
    $errors = [];
    if (isset($_POST["record"])) {
        $data = new stdClass();
        $data->id = "no_id"; //TODO check if needed

        //Dátum
        if (isset($_POST["date"])) {
            $components = explode(".",htmlspecialchars($_POST["date"]));
            if (count($components) == 3) {
                $year = intval($components[0]);
                $month = intval($components[1]);
                $day = intval($components[2]);
                if ($year < intval(date("Y"))) {
                    $errors[] = "Nem lehet időpontot a múltban rögzíteni (év)!";
                    if ($month < intval(date("m"))) {
                        $errors[] = "Nem lehet időpontot a múltban rögzíteni (hónap)!";
                        if ($month < intval(date("m"))) {
                            $errors[] = "Nem lehet időpontot a múltban rögzíteni (nap)!";
                        }
                    }
                }
                if (count($errors) == 0) {
                    $data->year = $year;
                    $data->month = $month;
                    $data->day = $day;
                }
            }
            else {
                $errors[] = "Dátum formátum nem megfelelő!";
            }
        }
        else {
            $errors[] = "A beírt dátum nem értelmezhető!";
        }

        //Időpont
        if (isset($_POST["time"])) {
            $components = explode(":",htmlspecialchars($_POST["time"]));
            if (count($components) == 2) {
                $hour = intval($components[0]);
                $min = intval($components[1]);

                //Dátum validálása sikeres volt, tehát nem vagyunk a múltban.
                if (count($errors) == 0) {
                    if ($hour < intval(date("G"))) {
                        $errors[] = "Nem lehet időpontot a múltban rögzíteni (óra)!";
                        if ($day < intval(date("i"))) {
                            $errors[] = "Nem lehet időpontot a múltban rögzíteni (perc)!";
                        }
                    }
                    if (count($errors) == 0) {
                        $data->hour = $hour;
                        $data->min = $min;
                    }
                }

            }
            else {
                $errors[] = "Időpont formátum nem megfelelő!";
            }
        }
        else {
            $errors[] = "A beírt időpont nem értelmezhető!";
        }

        //Helyek
        if (isset($_POST["places"])) {
            if (is_numeric(htmlspecialchars($_POST["places"]))) {
                $limit = intval(htmlspecialchars($_POST["places"]));
                if ($limit <= 0) {
                    $errors[] = "A helyek számának pozitívnak kell lennie!";
                }
                $data->limit = $limit;
            }
            else {
                $errors[] = "A helyek számának számnak kell lennie!";
            }
        }
        else {
            $errors[] = "A beírt időpont nem értelmezhető!";
        }


        if (count($errors) == 0) {
            //Sikeres validálás
            recordNewAppointment($data);
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nem KOVID · Regisztráció</title>

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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">

            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item active">
                    <a class="nav-link" href="register.php">Regisztráció</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Bejelentkezés</a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<main class="form-signin">
    <form method="POST" action="createNewAppointment.php">
        <img class="mb-4" src="assets/covid.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 fw-normal">Regisztráció</h1>
        <?php
            if (count($errors)) {
                for ($i = 0; $i < count($errors); $i++) {
                    echo "<p class='text-danger'>".$errors[$i]."</p>";
                }
            }
        ?>

        <div class="form-group">
            <label for="date" class="visually-hidden">Dátum</label>
            <input type="text" class="form-control" id="date" name="date" placeholder="Dátum" value="<?php if (isset($_POST["date"])) echo $_POST["date"];?>" required>
            <small id="dateHelp" class="form-text text-muted">ÉÉÉÉ.HH.NN formátumban</small>
        </div>

        <div class="form-group">
            <label for="time" class="visually-hidden">Dátum</label>
            <input type="text" class="form-control" id="time" name="time" placeholder="Időpont" value="<?php if (isset($_POST["time"])) echo $_POST["time"];?>" required>
            <small id="timeHelp" class="form-text text-muted">ÓÓ:PP formátumban</small>
        </div>

        <div class="form-group">
            <label for="places" class="visually-hidden">Helyek száma</label>
            <input type="number" class="form-control" id="places" name="places" placeholder="Időpont" value="<?php if (isset($_POST["places"])) echo $_POST["places"];?>" required>
            <small id="timeHelp" class="form-text text-muted">Meghírdetni kívánt helyek száma</small>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit" name="record">Időpont rögzítése</button>
        <p class="mt-5 mb-3 text-muted">Nemzeti Koronavírus Depó - 2021</p>
    </form>
</main>


</body>

</html>
