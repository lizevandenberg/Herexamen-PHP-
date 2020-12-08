<?php
include_once(__DIR__ . "/Db.php");

class Transaction
{
    private $id;
    private $sum;
    private $msg;
    private $receiver;
    private $searchName;

    //deze functie zal de tokens toevoegen vanaf de moment dat je bent geregisteerd bent
    public function activationTokens($receiver)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("INSERT INTO transactions (senderID, receiverID, amount, comment) VALUES (0, :receiverID, 10, 'Welcome to the Kaching family!')");
        $stmt->bindParam(':receiverID', $receiver);
        $result = $stmt->execute();
        return $result;
    }

    //deze functie zal dus de de transaction vinden aan de hand van het ID.
    public function findTransactionById($id){
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT * FROM transactions WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //deze functie zal het saldo onder hadnen nemen.
    public function saldo($receiver)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT SUM(amount) FROM transactions WHERE receiverID = :receiverID");
        $stmt->bindParam(':receiverID', $receiver);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    //deze functie gaat zoeken naar alle users voor de transactie te beginnen.
    public function allUsers($id)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id != :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //deze functie zal zoeken naar de username
    public function searchName($searchName)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username LIKE :searchName");
        $stmt->execute(['searchName' => $searchName . '%']);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //deze functie gaat de ontvanger zoeken 
    public function searchReceiver($receiver)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $receiver);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //deze functie gaat de history voor de details.
    public function history($id)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT transactions.*, sender.username AS sender_username,receiver.username AS receiver_username FROM transactions INNER JOIN users as sender ON transactions.senderID = sender.id INNER JOIN users as receiver ON transactions.receiverID = receiver.id WHERE senderID = :id OR receiverID = :id ORDER BY transactions.id DESC");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //deze functie zal het maken van de transfer doen.
    public function makeTransfer($id, $receiver, $sum, $msg)
    {
        $time = date('Y-m-d H:i:s');

        $pdo = Db::connect();
        $stmt = $pdo->prepare("INSERT INTO transactions (senderID, receiverID, amount, comment, time) VALUES (:id, :receiverID, :amount, :comment, :time)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':receiverID', $receiver);
        $stmt->bindParam(':amount', $sum);
        $stmt->bindParam(':comment', $msg);
        $stmt->bindParam(':time', $time);
        $result = $stmt->execute();
        return $result;
    }

    //deze functie is het optellen van tokens
    public function adds($id)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT SUM(amount) FROM transactions WHERE receiverID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    //deze functie is het aftrekken van tokens
    public function losses($id)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT SUM(amount) FROM transactions WHERE senderID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }



    public function getSum()
    {
        return $this->sum;
    }

    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;

        return $this;
    }

    public function getReceiver($receiver)
    {
        return $this->$receiver;
    }

    public function setReceiver($receiver)
    {
        $this->$receiver = $receiver;

        return $this;
    }

    public function getsearchName()
    {
        return $this->searchName;
    }

    public function setsearchName($searchName)
    {
        $this->searchName = $searchName;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
