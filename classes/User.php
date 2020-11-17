<?php 
include_once(__DIR__ . "/Db.php");
class User {

    private $id; 
    private $username;
    private $email;
    private $password;

    public function register($username, $email, $password){
        $pdo = Db::connect();
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $options= [
            'cost' => 12,
                  ];
        $password = password_hash($password, PASSWORD_BCRYPT, $options);
        $stmt -> bindParam(':username', $username);
        $stmt -> bindParam(':email', $email);
        $stmt -> bindParam(':password', $password);
        $result = $stmt->execute(); //voert de voorbereide statement uit. 
        return $result;
    }
  

    public function searchName($id){
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;                                      
    }
   
    public function userID($email){

        $pdo = DB::connect();
        $stmt = $pdo->prepare("SELECT userID FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;

    }

    public function availableEmail($email){

        $pdo = DB::connect();
        $stmt = $pdo->prepare("SELECT COUNT(userID) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        
        if ($result > 0){
            return false;
        } else{
            return true;
        }
    }

    public function loginValidate($email, $password){

        $pdo = DB::connect();
        $stmt = $pdo->prepare("SELECT password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch();
        if (password_verify($password, $result['password'])){
            return true;
        } else {
            return false;
        }

    }


    public function passwordValidate($password){
        
        $length = strlen($password);

        if($length < 5){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('|@student.thomasmore.be$|', $email)) {
            return true;
        } else {
            echo false;
        }
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

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


?>