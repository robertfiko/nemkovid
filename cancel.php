<?php
session_start();
require_once ("databaseConnection.php");
if (isset($_SESSION['user'])) {
    $_SESSION['user'] = cancelAppointment($_SESSION['user']);
}
header("Location: index.php");
