<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");

if (isset($_GET['id'])) {
    $reveiverId = $_GET['id'];
    $recipient = new Transaction();
    $result = $recipient->searchReceiver($reveiverId);
}

$sums = new Transaction();
$sums->setId($id);
$gains = $sums->adds($id);
$losses = $sums->losses($id);
$saldo = $gains - $losses;

$history = new Transaction();
$history->setId($id);
$transactions = $history->history($id);

if (!empty($_POST['submit'])) {
    $newTransaction = new Transaction();
    $amount = $_POST['amount'];
    $message = $_POST['message'];

    if ($saldo < $amount) {
        echo '<script language="javascript">';
        echo 'alert("Not enough tokens.")';
        echo '</script>';
    } else if ($amount < 1) {
        echo '<script language="javascript">';
        echo 'alert("You need 1 token to send something")';
        echo '</script>';
    } else {
        $transaction = $newTransaction->makeTransfer($id, $reveiverId, $amount, $message);
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
        <h4 id="saldo">Your saldo is <?php echo $adds - $losses; ?> tokens</h4>
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post" class="transaction-form">
                <div><input type="number" name="amount" id="amount" placeholder="Choose an amount"></div>
                <div><textarea name="message" id="message" placeholder="Let them know you appreciate them :)" cols="48" rows="10"></textarea></div>
                <div><input type="submit" value="Submit" class="cta shadow" id="submit" name="submit"></div>
            </form>
        </div>
        <div>
            <div>
                <h2>History</h2>
                <ul>
                    <?php
                    foreach ($transactions as $trans) : ?>
                        <?php
                        if ($trans['reveiverid'] == $id) { ?>
                            <li><a href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo  $trans['sender_username'] . " sent you " . $trans['amount'] . " tokens"; ?></a></li>
                        <?php } else { ?>
                            <li><a href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo "You sent " . $trans['receiver_username'] . " " . $trans['amount'] . " tokens"; ?></a></li>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>
    </div>
    <script src=js/transaction.js> </script> </body> </html>