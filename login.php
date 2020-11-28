<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");


if (!empty($_POST['login'])) {
    $validateLogin = new User($email);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $validateLogin->setEmail($email);
    $validateLogin->setPassword($password);
    $result = $validateLogin->loginValidate($email, $password);

    if ($result == 1) {
        session_start();
        $id = $validateLogin->searchUserByEmail($email);
        $_SESSION['user_id'] = $id;
        header("Location: home.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>


<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav center">
                <li><a href="login.php">Log in</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>

        </div>
</nav>

<body>
    <div class="d-md-flex h-md-100 align-items-center">
        <div class="col-md-6 p-0 h-md-100 brandingarea">
            <div class="text-white d-md-flex align-items-center h-100 p-5 text-center justify-content-center">
                <img class="logo" src="images/logo_white.svg" alt="">
            </div>
        </div>

        <div class="col-md-6 p-0 bg-white h-md-100 signuparea">
            <div class="d-md-flex align-items-center h-md-100 p-5 justify-content-center">
                <div class="flex-box">
                    <h1 class="title">Login</h1>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                    <div>
                        <p class="tiny">Don't have an account?</p><a href="register.php" class="login">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>