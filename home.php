<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");

$getName = new User();
$getName->setId($id);
$name = $getName->searchName($id);

$saldo = new Transaction();
$saldo->setId($id);
$sum = $saldo->saldo($id);

$sums = new Transaction();
$sums->setId($id);
$gains = $sums->adds($id);
$losses = $sums->losses($id);

$allUsers = new Transaction();
$allUsers->setId($id);
$users = $allUsers->allUsers($id);

$history = new Transaction();
$history->setId($id);
$transactions = $history->history($id);
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
        <div class="header">
            <h1>Hi, <?php echo $name['username']; ?>!</h1>
            <button type="button" class="btn btn-default btn-sm"><a class="logout-btn" href="logout.php"> Log out</a></button>
        </div>
        <h4 id="saldo">Your saldo is <?php echo $adds - $losses; ?> tokens</h4>

        <div>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" class="search" name="receiver" oninput=searchName(this.value) id="receiver" placeholder="Search user">
            </form>
        </div>
        <div>
            <div>
                <ul id="results" class="listitems">
                    <?php foreach ($users as $user) : ?>
                        <li><a href="transaction.php?id=<?php echo $user['id']; ?>"><?php echo $user['firstname'] . " " . $user['lastname']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div>
            <div>
                <h2>History</h2>
                <ul>
                    <?php
                    foreach ($transactions as $trans) : ?>
                        <?php
                        if ($trans['receiverID'] == $id) { ?>
                            <li><a href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo  $trans['sender_firstname'] . " sent you " . $trans['amount'] . " tokens"; ?></a></li>
                        <?php } else { ?>
                            <li><a href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo "You sent " . $trans['receiver_firstname'] . " " . $trans['amount'] . " tokens"; ?></a></li>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>
    </div>
    <script src=js/home.js></script>
</body>

</html>