<?php
session_start();

//TODO: If user is not logged in redurect to index
//TODO: Finish


require("databaseConnection.php");

if (isset($_POST)) {
    $errors = [];
    if (isset($_POST["approve"])) {
        if (!isset($_POST["check"])) {
            $errors[] = "Kérlek jelöld be, hogy elfogadod a feltételeket!";
        }

        if (count($errors) == 0) {
            //Időpont regisztrálás
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
        <img class="mb-4" src="assets/covid.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 fw-normal">Jelentkezés 5G chipre</h1>
        <?php
        if (count($errors)) {
            for ($i = 0; $i < count($errors); $i++) {
                echo "<p class='text-danger'>".$errors[$i]."</p>";
            }
        }
        ?>

        <form action="attend.php" method="post">
            <?php
            if(isset($_SESSION["user"])) {
                echo "<p></p><b>Teljes név: </b>".$_SESSION["user"]["name"]."</p>";
                echo "<p></p><b>Cím: </b>".$_SESSION["user"]["address"]."</p>";
                echo "<p></p><b>TAJ: </b>".$_SESSION["user"]["taj"]."</p>";
            }
            ?>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Elfogadom a <a href="feltetelek.pdf" target="_blank">jelentkezési feltételeket</a></label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit" name="approve">Jelentkezés megerősítése</button>
            <p class="mt-5 mb-3 text-muted">Nemzeti Koronavírus Depó - 2021</p>

        </form>


</main>


</body>

</html>
