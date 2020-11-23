<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Transaction.php");
session_start();
session_destroy();

if (!empty($_POST['register'])) {
    if(count(array_filter($_POST))==count($_POST)){
        // check if email is filled out
        if (!empty($_POST['email'])) {
            // check for thomas more email
            $verifyEmail = new User();
            $email = $_POST['email'];
            $verifyEmail->setEmail($email);
            $resultEmail = $verifyEmail->availableEmail($email);
  // if thomas more email = ok
  if ($resultEmail == 1) {
    // check if email is not taken
    $availableEmail = new User();
    $availableEmail->setEmail($email);
    $available = $availableEmail->availableEmail($email);
    if ($available == 1) {
        // check if password and verifypassword are the same
        if (!empty($_POST['password']) && $_POST['password'] === $_POST['confirmPassword']) {
            //check if password length is ok
            $verifyPassword = new User();
            $password = $_POST['password'];
            $verifyPassword->setPassword($password);
            $resultPassword = $verifyPassword->passwordValidate($password);

            if ($resultPassword == 1) {
                // register the user
                $user = new User();
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPassword($password);
                $register = $user->register($email, $password, $username);

                // start a session for the currently logged in user
                session_start();
                $id = $user->userID($email);
                $_SESSION['user'] = $id;
                $tokens = new Transaction();
                $tokens->setId($id);
                $activationTokens = $tokens->activationTokens($id);
                echo "Tokens sent.";
                header("Location: index.php");
            } else {
                echo '<script language="javascript">';
                echo 'alert("Password too short")';
                echo '</script>';
            }
        } else {
            echo '<script language="javascript">';
            echo 'alert("Passwords does not match")';
            echo '</script>';
        }
    } else {
        echo '<script language="javascript">';
        echo 'alert("Email taken")';
        echo '</script>';
    }
} else {
    echo '<script language="javascript">';
    echo 'alert("Only TM email")';
    echo '</script>';
}
}
} 
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

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav center">
        <li><a href="login.php">Log in</a></li>
        <li><a href="register.php">Register</a></li>
      </ul>

</div>
</nav>

<main class="main-content">
<div class="col-md-6 col-md-offset-2">
<form method="post" action="register.php">
    <div>
     <input type="text" name="username" id="username" placeholder="Username">
    </div">

    <div>
     <input type="text" name="email" id="email" placeholder="Email">
    </div>

    <div>
     <input type="password" name="password" id="password" placeholder="Password">
    </div>

    <div>
      <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm password">
    </div>

    <div>
       <input type="submit" class="shadow cta" value="Sign up" name="register" id="register">
    </div>

    <div>
      <p>Have an account?</p><a href="login.php">Sign in</a>
    </div>
</form>
</div>

</main>
</div>

</body>
</html>