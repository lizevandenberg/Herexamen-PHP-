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
        let username = result[i].username;

        a.textContent = username;
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

const userID = document.getElementById('user_id').value;
console.log(userID);

function update() {
    let formData = new FormData();
    formData.append('userID', userID);
    console.log(formData);

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
            console.error('Error: ', error);
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