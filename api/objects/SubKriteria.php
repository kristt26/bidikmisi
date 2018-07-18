<?php
class SubKriteria{
    private $conn;
    private $table_name="subkriteria";
    public $IdSubKriteria;
    public $IdKriteria;
    public $Jarak;
    public $BobotSubKriteria;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function readOne()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE IdKriteria=:IdKriteria";
        $stmt = $this->conn->prepare($query);
        $this->IdKriteria=htmlspecialchars(strip_tags($this->IdKriteria));
        $stmt->bindParam(":IdKriteria", $this->IdKriteria);
        $stmt->execute();
        return $stmt;
    }
    public function readbyId()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE IdSubKriteria=:IdSubKriteria";
        $stmt = $this->conn->prepare($query);
        $this->IdSubKriteria=htmlspecialchars(strip_tags($this->IdSubKriteria));
        $stmt->bindParam(":IdSubKriteria", $this->IdSubKriteria);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->IdKriteria = $row["IdKriteria"];
    }
    public function create()
    {
        $query="INSERT INTO ". $this->table_name ." SET IdKriteria=:IdKriteria, Jarak=:Jarak, BobotSubKriteria=:BobotSubKriteria";
        $stmt = $this->conn->prepare($query);
        $this->IdKriteria=htmlspecialchars(strip_tags($this->IdKriteria));
        //$this->Jarak=htmlspecialchars(strip_tags($this->Jarak));
        $this->BobotSubKriteria=htmlspecialchars(strip_tags($this->BobotSubKriteria));
        $stmt->bindParam(":IdKriteria", $this->IdKriteria);
        $stmt->bindParam(":Jarak", $this->Jarak);
        $stmt->bindParam(":BobotSubKriteria", $this->BobotSubKriteria);
        if($stmt->execute()){
            $this->IdSubKriteria = $this->conn->lastInsertId();
            return true;
        }else {
            return false;
        }
    }
    public function update()
    {
        $query="UPDATE ". $this->table_name ." SET Jarak=:Jarak, BobotSubKriteria=:BobotSubKriteria WHERE IdSubKriteria=:IdSubKriteria";
        $stmt = $this->conn->prepare($query);
        $this->IdSubKriteria=htmlspecialchars(strip_tags($this->IdSubKriteria));
        //$this->Jarak=htmlspecialchars(strip_tags($this->Jarak));
        $this->BobotSubKriteria=htmlspecialchars(strip_tags($this->BobotSubKriteria));
        $stmt->bindParam(":IdSubKriteria", $this->IdSubKriteria);
        $stmt->bindParam(":Jarak", $this->Jarak);
        $stmt->bindParam(":BobotSubKriteria", $this->BobotSubKriteria);
        if($stmt->execute()){
            return true;
        }else {
            return false;
        }
    }
    public function delete()
    {
        $query = "DELETE FROM ".$this->table_name." WHERE IdSubKriteria=:IdSubKriteria";
        $stmt = $this->conn->prepare($query);
        $this->IdSubKriteria=htmlspecialchars(strip_tags($this->IdSubKriteria));
        $stmt->bindParam(":IdSubKriteria", $this->IdSubKriteria);
        if($stmt->execute()){
            return true;
        }else {
            return false;
        }
    }
}

?>