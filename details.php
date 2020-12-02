<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");

$transID = $_GET['id'];

$transaction = new Transaction();
$trans = $transaction->findTransactionById($transID);
$trans = $trans[0];

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
    <button class="logout" type="button"><a href="home.php">Back</a></button>
    <h3>Details</h3>
    <div class="kader">
        <div>
            <div>
                <ul>
                    <li class="weg">Time: <?php echo $trans['time']; ?></li>
                    <li class="weg">Sender: <?php echo $trans['senderID']; ?></li>
                    <li class="weg">Receiver: <?php echo $trans['receiverID']; ?></li>
                    <li class="weg">Amount: <?php echo $trans['amount'] . " tokens"; ?></li>
                    <li class="weg">Comment: <?php echo $trans['comment']; ?></li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>