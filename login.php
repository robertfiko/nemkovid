<?php
session_start();
require_once("databaseConnection.php");

$errors = [];

$url = "login.php";
if (isset($_GET["appid"]) && isset($_GET["day"])) {
    $url = "login.php?appid=".$_GET["appid"]."&day=".$_GET["day"];
}

if (isset($_POST) && isset($_POST["loginBtn"])) {
    $errors = [];

    $query = new stdClass();
    if (isset($_POST["inputEmail"])) {
        $query->email = htmlspecialchars($_POST["inputEmail"]);
    }
    else {
        $errors[] = "Az e-mail cím nem felismerhető!";
    }

    if (isset($_POST["inputPassword"])) {
        $query->password = htmlspecialchars($_POST["inputPassword"]);
    }
    else {
        $errors[] = "A jelszó nem felismerhető!";
    }

    if (count($errors) == 0) {
        $user = checkUser($query);
            if ($user["passed"]) {
            //Sikeres belépés
            $_SESSION["user"] = $user["userdata"];
            if (isset($_GET["day"]) && isset($_GET["appid"])) {
                header("Location: attend.php?appid=".$_GET["appid"]."&day=".$_GET["day"]);
            } else {
                header('Location: index.php');
            }
        }
        else {
            $errors = array_merge($errors, $user["errors"]);
        }
    }


}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nem KOVID · Bejelentkezés</title>

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
    <form action="<?=$url?>" method="post" novalidate>
        <img class="mb-4" src="assets/covid.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 fw-normal">Bejelentkezés</h1>
        <?php
        if (count($errors)) {
            for ($i = 0; $i < count($errors); $i++) {
                echo "<p class='text-danger'>".$errors[$i]."</p>";
            }
        }
        ?>

        <label for="inputEmail" class="visually-hidden">Email cím</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email cím" required autofocus>

        <label for="inputPassword" class="visually-hidden">Jelszó</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Jelszó" required>

        <button class="w-100 btn btn-lg btn-primary" name="loginBtn" type="submit">Belépés</button>

        <p class="mt-5 mb-3 text-muted">Nemzeti Koronavírus Depó - 2021</p>
    </form>
</main>


</body>
</html>
