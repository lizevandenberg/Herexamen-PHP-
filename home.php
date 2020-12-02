<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");



$getName = new User("placeholder");
$name = $getName->searchName($userID);

$saldo = new Transaction();
$sum = $saldo->saldo($userID);

$sums = new Transaction();
$adds = $sums->adds($userID);
$losses = $sums->losses($userID);

$allUsers = new Transaction();
$users = $allUsers->allUsers($userID);

$history = new Transaction();
$transactions = $history->history($userID);
echo "<p hidden id='user_id'>" . $userID . "</p>";
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
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <img id="logo" src="img/logo-8.png" alt="">
    <button class="logout" type="button"><a href="logout.php">Log out</a></button>
    <div class="header">
        <h1>Hi, <?php echo $name['username']; ?>!</h1>
    </div>
    <h4 id="saldo">Saldo: <?php echo $adds - $losses; ?> tokens</h4>
    <input type="hidden" id="user_id" name="user_id" value="<?php echo $userID; ?>">
    <div class="left">
        <h2>Transaction</h2>
        <div class="zoek">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="receiver" oninput=searchName(this.value) id="receiver" placeholder="Search user">
            </form>
        </div>
        <div>
            <div class="gebruikers">
                <ul id="results" class="listitems">
                    <?php foreach ($users as $user) : ?>
                        <li class="list"><a class="font" href="transaction.php?id=<?php echo $user['id']; ?>"><?php echo $user['username']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="right">
        <h2>History</h2>
        <ul class="lijst">
            <?php
            foreach ($transactions as $trans) : ?>
                <?php
                if ($trans['receiverID'] == $userID) { ?>
                    <li class="list"><a class="font" href="details.php?id=<?php echo $trans['id']; ?>"><?php echo  $trans['sender_username'] . " sent you " . $trans['amount'] . " tokens"; ?></a></li>
                <?php } else { ?>
                    <li class="list"><a class="font" href="details.php?id=<?php echo $trans['id']; ?>"><?php echo "You sent " . $trans['receiver_username'] . " " . $trans['amount'] . " tokens"; ?></a></li>
                <?php } ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="js/home.js"></script>
</body>

</html>