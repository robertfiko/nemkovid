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
    <form>
        <img class="mb-4" src="assets/covid.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 fw-normal">Regisztráció</h1>

        <label for="inputName" class="visually-hidden">Teljes név</label>
        <input type="text" id="inputName" name="inputName" class="form-control" placeholder="Teljes név" required autofocus>

        <label for="inputTaj" class="visually-hidden">TAJ szám</label>
        <input type="number" maxlength="9" minlength="9" id="inputTaj" name="inputTaj" class="form-control" placeholder="TAJ szám" required >

        <label for="inputAddress" class="visually-hidden">Értesítési cím</label>
        <input type="text" id="inputAddress" name="inputAddress" class="form-control" placeholder="Értesítési cím" required >

        <label for="inputEmail" class="visually-hidden">Email cím</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email cím" required >

        <label for="inputPassword" class="visually-hidden">Jelszó</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Jelszó" required>

        <label for="inputPasswordAgain" class="visually-hidden">Jelszó megismétlése</label>
        <input type="password" id="inputPasswordAgain" name="inputPasswordAgain" class="form-control" placeholder="Jelszó megismétlése" required>


        <button class="w-100 btn btn-lg btn-primary" type="submit">Regisztrálás</button>
        <p class="mt-5 mb-3 text-muted">Nemzeti Koronavírus Depó - 2021</p>
    </form>
</main>


</body>
</html>
