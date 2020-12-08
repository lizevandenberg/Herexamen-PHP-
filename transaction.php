<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");
$alert = 0;

if (isset($_GET['id'])) {
    $receiverId = $_GET['id'];
    $recipient = new Transaction();
    $result = $recipient->searchReceiver($receiverId);
}

$sums = new Transaction();
$id = $_SESSION['user_id'];
$sums->setId($id);
$adds = $sums->adds($id);
$losses = $sums->losses($id);
$saldo = $adds - $losses;

$history = new Transaction();
$history->setId($id);
$transactions = $history->history($id);

//beginnen van een nieuwe transactie
if (!empty($_POST['submit'])) {
    $newTransaction = new Transaction();
    $amount = $_POST['amount'];
    $message = $_POST['message'];

    if ($saldo < $amount) {
        $alert = 1;
    } else if ($amount < 1) {
        echo '<script language="javascript">';
        echo 'alert("You need 1 token to send something")';
        echo '</script>';
    } else {
        $transaction = $newTransaction->makeTransfer($id, $receiverId, $amount, $message);
        $alert = 3;
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
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <img id="logo" src="img/logo-8.png" alt="">
    <button class="logout" type="button"><a href="home.php">Back</a></button>
    <h3>Transaction</h3>
    <h4 id="saldoo">Saldo: <?php echo $adds - $losses; ?> tokens</h4>
    <div class="transfer">
        <form class="formmm" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post" class="transaction-form">
            <div><input type="number" name="amount" id="amount" placeholder="Choose an amount"></div>
            <div><textarea name="message" id="message" placeholder="Write something" cols="27" rows="8"></textarea></div>
            <div><input type="submit" value="Submit" class="cta shadow" id="submit" name="submit"></div>
        </form>
    </div>
    <script src="js/transaction.js"></script>
</body>

</html>