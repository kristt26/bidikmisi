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
    public function read()
    {
        $query= "SELECT * FROM ".$this->table_name." WHERE ";
    }
}


?>