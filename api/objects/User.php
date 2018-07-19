<?php
class User{
    private $conn;
    private $table_name = "user";
    public $IdUser;
    public $Username;
    public $Email;
    public $Password;
    public $Akses;
    public $Hash;
    public $Active;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET Username=:Username, Email=:Email, Password=:Password, Akses=:Akses, Hash=:Hash";
        $stmt = $this->conn->prepare($query);
        $this->Username=htmlspecialchars(strip_tags($this->Username));
        $this->Email=htmlspecialchars(strip_tags($this->Email));
        $this->Password=htmlspecialchars(strip_tags($this->Password));
        $this->Akses=htmlspecialchars(strip_tags($this->Akses));
        $this->Hash=htmlspecialchars(strip_tags($this->Hash));
        $stmt->bindParam(":Username", $this->Username);
        $stmt->bindParam(":Email", $this->Email);
        $stmt->bindParam(":Password", $this->Password);
        $stmt->bindParam(":Akses", $this->Akses);
        $stmt->bindParam(":Hash", $this->Hash);
        if($stmt->execute()){
            $this->IdUser = $this->conn->lastInsertId();
            return true;
        }else{
            return false;
        }
    }
    public function readOne()
    {
        $query= "SELECT * FROM ".$this->table_name." WHERE Email= ?";
        $stmt=$this->conn->prepare($query);
        $this->Email=htmlspecialchars(strip_tags($this->Email));
        $stmt->bindParam(1, $this->Email);
        $stmt->execute();
        return $stmt;
    }
    public function readById()
    {
        $query= "SELECT * FROM ".$this->table_name." WHERE IdUser= ?";
        $stmt=$this->conn->prepare($query);
        $this->IdUser=htmlspecialchars(strip_tags($this->IdUser));
        $stmt->bindParam(1, $this->IdUser);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->Username = $row['Username'];
        $this->Email = $row['Email'];
        $this->Active = $row['Active'];
    }
    public function read()
    {
        $query= "SELECT * FROM ".$this->table_name." WHERE Username= ? and Password=? and Active";
        $stmt=$this->conn->prepare($query);
        $this->Username=htmlspecialchars(strip_tags($this->Username));
        $this->Password=htmlspecialchars(strip_tags($this->Password));
        $stmt->bindParam(1, $this->Username);
        $stmt->bindParam(2, $this->Password);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->IdUser=$row["IdUser"];
        $this->Username=$row["Username"];
        $this->Email=$row["Email"];
        $this->Password=$row["Password"];
        $this->Akses=$row["Akses"];
        $this->Hash=$row["Hash"];
        $this->Active=$row["Active"];
    }
    public function CheckSession()
    {
        session_start();
        if(!isset($_SESSION['Username']))
        {
            return false;
        }else{
            return $_SESSION;
        }
    }
}


?>