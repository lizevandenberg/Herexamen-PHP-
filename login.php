<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");
session_start();
session_destroy();

if (!empty($_POST['login'])) {
    $loginValidate = new User();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $loginValidate->setEmail($email);
    $loginValidate->setPassword($password);
    $result = $loginValidate->loginValidate($email, $password);

    if ($result == 1) {
        session_start();
        $userID = $loginValidate->userID($email);
        $_SESSION['user'] = $id;
        header("Location: home.php");
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Kaching</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
  
<main class="main-content">
 <div class="col-md-6 col-md-offset-2">
<form method="post" action="login.php">
<div>
     <input type="text" name="email" id="email" placeholder="Email">
</div>

<div>
    <input type="password" name="password" id="password" placeholder="Password">
</div>

<div>
    <input type="submit" value="Sign in" name="login" id="login" class="shadow cta">
</div>
</form>
</div>

</main>
</div>

</body>
</html>