<?php
session_start();
if (isset($_SESSION['user'])) {
} else {
    header("Location: login.php");
}

$userID = $_SESSION['user'];

include_once(__DIR__ . "/../classes/Db.php");
include_once(__DIR__ . "/../classes/User.php");