<?php
session_start();
/*if (isset($_SESSION['user_id'])) {
} else {
    header("Location: login.php");
}*/

$userID = $_SESSION['user_id'];

include_once(__DIR__ . "/../classes/Db.php");
include_once(__DIR__ . "/../classes/User.php");
