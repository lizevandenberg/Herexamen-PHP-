<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");

$transID = $_GET['id'];

$history = new Transaction();
$history->setId($transID);
$transactions = $history->history($transID);
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
    <div class="transfer">
        <div>
            <div>
                <ul>
                    <li>Transaction date</li>
                    <li>Sender</li>
                    <li>Recipient</li>
                    <li>Amount</li>
                    <li>Message</li>
                </ul>
                <ul>
                    <?php foreach ($transactions as $trans) : ?>
                        <?php if ($trans['transID'] == $transID) { ?>
                            <li><?php echo $trans['time']; ?></li>
                            <li><?php echo $trans['sender_username']; ?></li>
                            <li><?php echo $trans['receiver_username']; ?></li>
                            <li><?php echo $trans['amount'] . " tokens"; ?></li>
                            <li><?php echo $trans['comment']; ?></li>
                    <?php }
                    endforeach; ?>
                </ul>
            </div>
        </div>

        <ul>
            <?php
            foreach ($transactions as $trans) : ?>
                <?php
                if ($trans['recipientID'] == $id) { ?>
                    <li><a <?php if ($transID == $trans['transID']) {
                                                                    echo "selected";
                                                                } else {
                                                                }; ?>" href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo  $trans['sender_username'] . " sent you " . $trans['amount'] . " tokens"; ?></a></li>
                <?php } else { ?>
                    <li><a <?php if ($transID == $trans['transID']) {
                                                                    echo "selected";
                                                                } else {
                                                                }; ?>" href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo "You sent " . $trans['receiver_username'] . " " . $trans['amount'] . " tokens"; ?></a></li>
            <?php }

                if ($transID == $trans['transID']) {
                    echo '<input type="hidden" id="transHidden" name="hidden" value ="' . $trans['transID'] . '">';
                } else {
                }
            endforeach; ?>
        </ul>

    </div>
    <script>
        window.onload = timer;

        function timer() {
            setInterval(() => {
                updateHistory()
            }, 3000);
        }

        const id = document.getElementById("hidden").value;
        console.log(id);

        let transID = document.getElementById("transHidden").value;
        console.log(transID);

        function updateHistory() {
            let formData = new FormData();
            formData.append('id', id);

            fetch('ajax/fetchHistory.php', {
                    method: 'POST',
                    body: formData
                })

                .then(response => response.json())
                .then(result => viewHistory(result))
                .catch(error => {
                    console.log('Error: ', error);
                });
        }

        function viewHistory(result) {
            const history = document.getElementById("listitems");
            history.innerHTML = "";

            for (let i = 0; i < result.length; i++) {
                if (result[i].senderID == id) {
                    let a = document.createElement("a");
                    let li = document.createElement("li");
                    let href = "details.php?id=" + result[i].transID;
                    let title = "You sent " + result[i].receiver_username + " " + result[i].amount + " tokens.";

                    li.classList.add("transItems");
                    a.classList.add("transLink");

                    a.textContent = title;
                    a.setAttribute('href', href);
                    li.appendChild(a);
                    history.appendChild(li);

                    if (transID == result[i].transID) {
                        a.classList.add("selected");
                    } else {}

                    console.log("history items updated");
                } else {
                    let a = document.createElement("a");
                    let li = document.createElement("li");
                    let href = "details.php?id=" + result[i].transID;
                    let title = result[i].sender_username + " sent you " + result[i].amount + " tokens.";

                    li.classList.add("transItems");
                    a.classList.add("transLink");

                    a.textContent = title;
                    a.setAttribute('href', href);
                    li.appendChild(a);
                    history.appendChild(li);

                    if (transID == result[i].transID) {
                        a.classList.add("selected");
                    } else {}

                    console.log("history items updated");
                }
            }
        }
    </script>
</body>

</html>