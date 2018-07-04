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
}

?>