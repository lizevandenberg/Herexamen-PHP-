<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Transaction.php");

$alert = 0;


if (!empty($_POST['register'])) {
  if (count(array_filter($_POST)) == count($_POST)) {
    // check if email is filled out
    if (!empty($_POST['email'])) {
      // check for thomas more email
      $email = $_POST['email'];
      $user = new User($email);
      $user->setEmail($email);
      $resultEmail = $user->validateEmail($email);
      // if thomas more email = ok
      if ($resultEmail == 1) {
        // check if email is not taken
        $availableEmail = new User($email);
        $availableEmail->setEmail($email);
        $available = $availableEmail->availableEmail($email);
        if ($available == 1) {

          if (!empty($_POST['password']) && $_POST['password'] === $_POST['confirmPassword']) {

            $verifyPassword = new User($email);
            $password = $_POST['password'];
            $verifyPassword->setPassword($password);
            $resultPassword = $verifyPassword->passwordValidate($password);

            if ($resultPassword == 1) {

              $user = new User($email);
              $username = $_POST['username'];
              $email = $_POST['email'];
              $password = $_POST['password'];
              $user->setUsername($username);
              $user->setEmail($email);
              $user->setPassword($password);
              $register = $user->register($username, $email, $password);
              $user = new User($email);

              session_start();
              $_SESSION['email'] = $user->getEmail();
              $id = $user->getId();
              $_SESSION['user'] = $user->getUsername();
              $tokens = new Transaction();
              $tokens->setReceiver($id);
              $activationTokens = $tokens->activationTokens($id);
              header("Location: home.php");
            } else {
              echo "Password too short.";
              $alert = 1;
            }
          } else {
            echo "Password doesn't match.";
            $alert = 2;
          }
        } else {
          echo "Email taken.";
          $alert = 3;
        }
      } else {
        echo "Only Thomas More emails please.";
        $alert = 4;
      }
    }
  } else {
    echo "Fill all fields out please.";
    $alert = 5;
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
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
          <input type="text" name="username" id="username" placeholder="Username">
          </div">

          <div>
            <input type="text" name="email" id="email" placeholder="Email">
          </div>
          <div class='alert alert-danger' <?php if ($alert != 4) {
                                            echo "style='display:none'";
                                          } else {
                                          } ?>>Only Thomas More student email allowed.</div>
          <div class='alert alert-danger' <?php if ($alert != 3) {
                                            echo "style='display:none'";
                                          } else {
                                          } ?>>Email taken.</div>

          <div>
            <input type="password" name="password" id="password" placeholder="Password">
          </div>

          <div>
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm password">
          </div>
          <div class='alert alert-danger' <?php if ($alert != 2) {
                                            echo "style='display:none'";
                                          } else {
                                          } ?>>Passwords don't match.</div>
          <div class='alert alert-danger' <?php if ($alert != 1) {
                                            echo "style='display:none'";
                                          } else {
                                          } ?>>Password too short.</div>
          <div>
            <input type="submit" class="shadow cta" value="Sign up" name="register" id="register">
          </div>
          <div class='alert alert-danger' <?php if ($alert != 5) {
                                            echo "style='display:none'";
                                          } else {
                                          } ?>>Fill out all field please.</div>

          <div>
            <p>Have an account?</p><a href="login.php">Sign in</a>
          </div>
      </form>
    </div>

  </main>
  </div>

</body>

</html>