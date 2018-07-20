<?php
class KriteriaMahasiswa
{
    private $conn;
    private $table_name = "kriteriamahasiswa";
    public $IdKriteriaMahasiswa;
    public $IdMahasiswa;
    public $IdKriteria;
    public $Nilai;
    public $Berkas;
    public $Status;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET IdMahasiswa=?, IdKriteria=?, Nilai=?, Berkas=?, Status=?";
        $stmt= $this->conn->prepare($query);
        $stmt->bindParam(1, $this->IdMahasiswa);
        $stmt->bindParam(2, $this->IdKriteria);
        $stmt->bindParam(3, $this->Nilai);
        $stmt->bindParam(4, $this->Berkas);
        $stmt->bindParam(5, $this->Status);
        if($stmt->execute()){
            $this->IdKriteriaMahasiswa = $this->conn->lastInsertId();
            return true;
        }else {
            return false;
        }
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
        $query = "SELECT * FROM ".$this->table_name." where IdMahasiswa=? and IdKriteria=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->IdMahasiswa);
        $stmt->bindParam(2, $this->IdKriteria);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->IdKriteriaMahasiswa=$row["IdKriteriaMahasiswa"];
        $this->Nilai=$row["Nilai"];
        $this->Berkas=$row["Berkas"];
        $this->Status=$row["Status"];
    }
    public function update()
    {
        $query="UPDATE ". $this->table_name ." SET Status=:Status WHERE IdKriteriaMahasiswa=:IdKriteriaMahasiswa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Status", $this->Status);
        $stmt->bindParam(":IdKriteriaMahasiswa", $this->IdKriteriaMahasiswa);
        if($stmt->execute()){
            return true;
        }else {
            return false;
        }
    }
}

?>