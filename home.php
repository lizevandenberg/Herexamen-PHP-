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
                        <li><a href="transaction.php?id=<?php echo $user['id']; ?>"><?php echo $user['username']; ?></a></li>
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
                        if ($trans['receiverID'] == $userID) { ?>
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
    <script>
        function searchName(searchName) {
            console.log(searchName);

            fetchSearchName(searchName);
        }

        function fetchSearchName(searchName) {
            fetch('ajax/searchUser.php', {
                    method: 'POST',
                    body: new URLSearchParams('searchName=' + searchName)
                })
                .then(result => result.json())
                .then(result => viewResults(result))
                .catch(error => console.error('Error: ' + error))
        }

        function viewResults(result) {
            const results = document.getElementById("results");
            results.innerHTML = "";

            for (let i = 0; i < result.length; i++) {
                let a = document.createElement("a");
                let li = document.createElement("li");
                let href = "transaction.php?id=" + result[i].userID;
                let name = result[i].firstname + " " + result[i].lastname;

                a.textContent = name;
                a.setAttribute('href', href);
                li.appendChild(a);
                results.appendChild(li);
            }
        }

        const saldo = document.getElementById('saldo');

        window.onload = timer;

        function timer() {
            setInterval(() => {
                update()
            }, 3000);

            setInterval(() => {
                updateHistory()
            }, 3000);
        }

        const userID = document.getElementById("hidden").value;
        console.log(userID);

        function update() {
            let formData = new FormData();
            formData.append('userID', userID);

            fetch('ajax/updateSaldo.php', {
                    method: 'POST',
                    body: formData
                })

                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    saldo.innerHTML = "Your saldo is " + result + " tokens"
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateHistory() {
            let formData = new FormData();
            formData.append('userID', userID);

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
                if (result[i].senderID == userID) {
                    let a = document.createElement("a");
                    let li = document.createElement("li");
                    let href = "details.php?id=" + result[i].transID;
                    let title = "You sent " + result[i].recipient_firstname + " " + result[i].amount + " tokens.";

                    li.classList.add("transItems");
                    a.classList.add("transLink");

                    a.textContent = title;
                    a.setAttribute('href', href);
                    li.appendChild(a);
                    history.appendChild(li);

                    console.log("history items updated");
                } else {
                    let a = document.createElement("a");
                    let li = document.createElement("li");
                    let href = "details.php?id=" + result[i].transID;
                    let title = result[i].sender_firstname + " sent you " + result[i].amount + " tokens.";

                    li.classList.add("transItems");
                    a.classList.add("transLink");

                    a.textContent = title;
                    a.setAttribute('href', href);
                    li.appendChild(a);
                    history.appendChild(li);

                    console.log("history items updated");
                }
            }
        }
    </script>
</body>

</html>