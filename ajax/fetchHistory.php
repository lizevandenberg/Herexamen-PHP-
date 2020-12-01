<?php
include_once(__DIR__."/../classes/Transaction.php");
include_once(__DIR__."/../inc/session.inc.php");

$id = $_POST['id'];
$update = new Transaction();
$adds = $update->adds($id);
$losses = $update->losses($id);

$results = $adds-$losses;

echo json_encode($results);