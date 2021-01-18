<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Nem KOVID</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/starter-template/">


    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        table#calendar {
            table-layout: fixed;
            border: darkgrey solid 1px;
        }

        table#calendar td, table#calendar tr {
            border: darkgrey solid 1px;
        }

        table#calendar tr.days {
            height: 150px;
        }

        .top {
            vertical-align: text-top;
        }

        td.today {
            color: indianred;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">NemKoViD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault"
                aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
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
            <?php
            if (isset($_SESSION["user"])) {
                echo '    <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <span class="nav-link" data-target="#myModal" data-toggle="modal">Üdvözlet, ' . $_SESSION["user"]["name"] . '!</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php" data-target="#myModal" data-toggle="modal">Kijelentkezés</a>
                            </li>
                        </ul>
                            ';

            }
            ?>


        </div>
    </div>
</nav>

<main class="container">

    <h3>Vezérlőpult</h3>
    <a href="createNewAppointment.php" class="btn-success">Új időpont meghírdetése</a>


    <div class="starter-template text-center py-5 px-3">

        </table>
        <table class="" style="table-layout: fixed; width: 100%; margin-bottom: 1rem; vertical-align: top;">
            <tr>
                <td>
                    <button id="prev" type="button" class="btn btn-outline-info"><< Előző</button>
                </td>
                <td id="calHeader">Aktuális</td>
                <td>
                    <button id="next" type="button" class="btn btn-outline-info">Következő >></button>
                </td>
            </tr>
        </table>

        <table class="table" id="calendar">
            <tr>
                <th>Hétfő</th>
                <th>Kedd</th>
                <th>Szerda</th>
                <th>Csütörtök</th>
                <th>Péntek</th>
                <th>Szombat</th>
                <th>Vasárnap</th>
            </tr>
            <tr id="loading">
                <td colspan="7">Betöltés alatt...</td>
            </tr>

    </div>


</main><!-- /.container -->


</body>


<script src="calendarHandler.js"></script>


</html>
