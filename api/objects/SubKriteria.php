<?php
class SubKriteria{
    private $conn;
    private $table_name="subkriteria";
    public $IdSubKriteria;
    public $IdKriteria;
    public $Range;
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
}

?>