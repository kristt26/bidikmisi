<?php
class Kriteria{
    private $conn;
    private $table_name = "kriteria";
    public $IdKriteria;
    public $Kriteria;
    public $Bobot;
    public $Keterangan;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM ".$this->table_name."";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function readOne()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE IdKriteria=?";
        $stmt = $this->conn->prepare($query);
        $this->IdKriteria = htmlspecialchars(strip_tags($this->IdKriteria));
        $stmt->bindParam(1, $this->IdKriteria);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->Kriteria = $row["Kriteria"];
        $this->Bobot = $row["Bobot"];
        $this->Keterangan = $row["Keterangan"];
    }
    public function create()
    {
        $query="INSERT INTO ". $this->table_name ." SET Kriteria=:Kriteria, Bobot=:Bobot, Keterangan=:Keterangan";
        $stmt = $this->conn->prepare($query);
        $this->kriteria=htmlspecialchars(strip_tags($this->Kriteria));
        $this->Bobot=htmlspecialchars(strip_tags($this->Bobot));
        $this->Keterangan=htmlspecialchars(strip_tags($this->Keterangan));
        $stmt->bindParam(":Kriteria", $this->Kriteria);
        $stmt->bindParam(":Bobot", $this->Bobot);
        $stmt->bindParam(":Keterangan", $this->Keterangan);
        if($stmt->execute()){
            $this->IdKriteria = $this->conn->lastInsertId();
            return true;
        }else {
            return false;
        }
    }
    public function update()
    {
        $query="UPDATE ". $this->table_name ." SET Kriteria=:Kriteria, Bobot=:Bobot, Keterangan=:Keterangan WHERE IdKriteria=:IdKriteria";
        $stmt = $this->conn->prepare($query);
        $this->IdKriteria=htmlspecialchars(strip_tags($this->IdKriteria));
        $this->kriteria=htmlspecialchars(strip_tags($this->Kriteria));
        $this->Bobot=htmlspecialchars(strip_tags($this->Bobot));
        $this->Keterangan=htmlspecialchars(strip_tags($this->Keterangan));
        $stmt->bindParam(":IdKriteria", $this->IdKriteria);
        $stmt->bindParam(":Kriteria", $this->Kriteria);
        $stmt->bindParam(":Bobot", $this->Bobot);
        $stmt->bindParam(":Keterangan", $this->Keterangan);
        if($stmt->execute()){
            return true;
        }else {
            return false;
        }
    }
}

?>