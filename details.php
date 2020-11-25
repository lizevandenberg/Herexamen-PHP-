<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");

$transID = $_GET['id'];

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
        <div>
            <div>
                <div>
                    <div>
                        <h1><a href="home.php" class="return">Back</a></h1>
                    </div>
                    <div>
                        <ul class="labels">
                            <li class="label">Transaction date</li>
                            <li class="label">Sender</li>
                            <li class="label">Recipient</li>
                            <li class="label">Amount</li>
                            <li class="label">Message</li>
                        </ul>
                        <ul class="variables">
                            <?php foreach ($transactions as $trans) : ?>
                                <?php if ($trans['transID'] == $transID) { ?>
                                    <li class="var"><?php echo $trans['time']; ?></li>
                                    <li class="var"><?php echo $trans['sender_username']; ?></li>
                                    <li class="var"><?php echo $trans['recipient_username']; ?></li>
                                    <li class="var"><?php echo $trans['amount'] . " tokens"; ?></li>
                                    <li class="var"><?php echo $trans['message']; ?></li>
                            <?php }
                            endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div>
                <div>
                    <h2 class="history">History</h2>
                    <input type="hidden" id="hidden" name="hidden" value="<?php echo $id; ?>">
                    <ul id="listitems" class="listitems">
                        <?php
                        foreach ($transactions as $trans) : ?>
                            <?php
                            if ($trans['recipientID'] == $id) { ?>
                                <li class="transItems"><a class="transLink <?php if ($transID == $trans['transID']) {
                                    echo "selected";
                                    } else {
                                    }; ?>" href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo  $trans['sender_firstname'] . " sent you " . $trans['amount'] . " tokens"; ?></a></li>
                            <?php } else { ?>
                                <li class="transItems"><a class="transLink <?php if ($transID == $trans['transID']) {
                                    echo "selected";
                                    } else {
                                    }; ?>" href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo "You sent " . $trans['recipient_firstname'] . " " . $trans['amount'] . " tokens"; ?></a></li>
                        <?php }

                            if ($transID == $trans['transID']) {
                                echo '<input type="hidden" id="transHidden" name="hidden" value ="' . $trans['transID'] . '">';
                            } else {
                            }
                        endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    </div>
    <script src=js/detail.js> </script> 
</body> 
</html>