<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");

//checken of het formulier leeg is.
if (!empty($_POST['login'])) {
    $email = $_POST['email'];
    $validateLogin = new User($email);
    $password = $_POST['password'];
    $validateLogin->setEmail($email);
    $validateLogin->setPassword($password);
    $result = $validateLogin->loginValidate($email, $password);

    if ($result == 1) {
        $id = $validateLogin->searchUserByEmail($email);
        session_start();
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

<body>
    <main class="register">
        <img class="logo" src="img/logowit-8.png" alt="">
        <div>
            <div>
                <div class="flex-box">
                    <form class="formm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div>
                            <input type="text" name="email" id="email" placeholder="Email">
                        </div>

                        <div>
                            <input type="password" name="password" id="password" placeholder="Password">
                        </div>

                        <div>
                            <input class="knopp" type="submit" value="Sign in" name="login" id="login" class="shadow cta">
                        </div>
                    </form>
                    <p class="signin">Don't hava an account? <a href="register.php">Sign up</a></p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>