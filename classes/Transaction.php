<?php
include_once(__DIR__ . "/Db.php");

class Transaction
{
    private $id;
    private $sum;
    private $msg;
    private $receiver;
    private $searchName;

    public function activationTokens($id)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("INSERT INTO transactions (senderID, receiverID, amount, comment) VALUES (1, :receiverID, 10, 'Welcome to the Kaching family!')");
        $stmt->bindParam(':receiverID', $receiver);
        $result = $stmt->execute();
        return $result;
    }

    public function saldo($receiver)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT SUM(amount) FROM transactions WHERE receiver = :receiver");
        $stmt->bindParam(':receiver', $receiver);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    public function allUsers($id)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id != :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchName($searchName)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username LIKE :searchName");
        $stmt->execute(['searchName' => $searchName . '%']);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchReceiver($receiver)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $receiver);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function history($id)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT transactions.*, sender.username AS sender_username,receiver.username AS receiver_username FROM transactions INNER JOIN users as sender ON transactions.senderID = sender.id INNER JOIN users as receiver ON transactions.receiverID = receiver.id WHERE senderID = :id OR receiverID = :id ORDER BY transactions.id DESC");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function makeTransfer($id, $receiver, $sum, $msg)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("INSERT INTO transactions (senderID, receiverID, amount, comment) VALUES (:id, :receiverID, :amount, :comment)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':receiverID', $receiver);
        $stmt->bindParam(':amount', $sum);
        $stmt->bindParam(':message', $msg);
        $result = $stmt->execute();
        return $result;
    }

    public function adds($id)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT SUM(amount) FROM transactions WHERE receiverID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

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
