<?php
include_once(__DIR__."/../classes/Transaction.php");

$searchName = $_POST['searchName'];
$search = new Transaction();
$results = $search->searchName($searchName);

echo json_encode($results);