<?php
session_start();
require_once("databaseConnection.php");
$errors = [];

if (isset($_POST)) {
    if (isset($_POST["register"])) {
        $errors = [];

        $data = new stdClass();
        if (isset($_POST["inputName"])) {
            $data->name = htmlspecialchars($_POST["inputName"]);
        }
        else {
            $errors[] = "A beírt név nem értelmezhető!";
        }

        if (isset($_POST["inputTaj"]) && strlen(strval($_POST["inputTaj"])) == 9) {
            $data->taj = htmlspecialchars($_POST["inputTaj"]);
        }
        else {
            $errors[] = "A TAJ számnak 9 hosszúnak kell lennie!";
        }

        if (isset($_POST["inputAddress"])) {
            $data->address = htmlspecialchars($_POST["inputAddress"]);
        }
        else {
            $errors[] = "A beírt cím nem értelmezhető!";
        }

        if (isset($_POST["inputEmail"])) {
            $data->email = htmlspecialchars($_POST["inputEmail"]);
        }
        else {
            $errors[] = "A beírt e-mail nem értelmezhető!";
        }

        if (isset($_POST["inputPassword"]) && isset($_POST["inputPasswordAgain"]) && (htmlspecialchars($_POST["inputPasswordAgain"])) == htmlspecialchars($_POST["inputPassword"])) {
            $data->password = password_hash(htmlspecialchars($_POST["inputPassword"]), PASSWORD_DEFAULT);
        }
        else {
            $errors[] = "A jelszó és ellenőrzése nem megfelelő!";
        }

        if (count($errors) == 0) {
            if (!isRegistered($data->email)) {
                //Sikeres regisztráció
                $data->appointment = NULL;
                addNewUser($data, $data->email);
                header('Location: login.php');
            }
            else {
                $errors[] = "Ez az e-mail cím már regisztrálva van!";
            }

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
    <form method="POST" action="register.php" novalidate>
        <img class="mb-4" src="assets/covid.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 fw-normal">Regisztráció</h1>
        <?php
            if (count($errors)) {
                for ($i = 0; $i < count($errors); $i++) {
                    echo "<p class='text-danger'>".$errors[$i]."</p>";
                }
            }
        ?>

        <label for="inputName" class="visually-hidden">Teljes név</label>
        <input type="text" id="inputName" name="inputName" class="form-control" value="<?php if (isset($_POST["inputName"])) echo $_POST["inputName"];?>" placeholder="Teljes név" required autofocus>

        <label for="inputTaj" class="visually-hidden">TAJ szám</label>
        <input type="number" id="inputTaj" name="inputTaj" class="form-control"  value="<?php if (isset($_POST["inputTaj"])) echo $_POST["inputTaj"];?>" placeholder="TAJ szám" required >

        <label for="inputAddress" class="visually-hidden">Értesítési cím</label>
        <input type="text" id="inputAddress" name="inputAddress" class="form-control" value="<?php if (isset($_POST["inputAddress"])) echo $_POST["inputAddress"];?>"  placeholder="Értesítési cím" required >

        <label for="inputEmail" class="visually-hidden">Email cím</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" value="<?php if (isset($_POST["inputEmail"])) echo $_POST["inputEmail"];?>" placeholder="Email cím" required >

        <label for="inputPassword" class="visually-hidden">Jelszó</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control"  placeholder="Jelszó" required>

        <label for="inputPasswordAgain" class="visually-hidden">Jelszó megismétlése</label>
        <input type="password" id="inputPasswordAgain" name="inputPasswordAgain" class="form-control" placeholder="Jelszó megismétlése" required>


        <button class="w-100 btn btn-lg btn-primary" type="submit" name="register">Regisztrálás</button>
        <p class="mt-5 mb-3 text-muted">Nemzeti Koronavírus Depó - 2021</p>
    </form>
</main>


</body>

</html>
