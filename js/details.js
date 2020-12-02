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
            } else { }

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
            } else { }

            console.log("history items updated");
        }
    }
}