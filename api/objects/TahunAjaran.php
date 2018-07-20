<?php
class TahunAjaran{
    private $conn;
    private $table_name="tahunajaran";
    public $IdTahunAjaran;
    public $TahunAjaran;
    public $TanggalBuka;
    public $TanggalTutup;
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
    public function readAktif()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE Keterangan=?";
        $stmt = $this->conn->prepare($query);
        $this->Keterangan = htmlspecialchars(strip_tags($this->Keterangan));
        $stmt->bindParam(1, $this->Keterangan);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->IdTahunAjaran= $row["IdTahunAjaran"];
        $this->TahunAjaran= $row["TahunAjaran"];
        $this->TanggalBuka= $row["TanggalBuka"];
        $this->TanggalTutup= $row["TanggalTutup"];
    }
    public function readOne()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE IdTahunAjaran= ?";
        $stmt = $this->conn->prepare($query);
        $this->IdTahunAjaran = htmlspecialchars(strip_tags($this->IdTahunAjaran));
        $stmt->bindParam(1, $this->IdTahunAjaran);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->TahunAjaran = $row['TahunAjaran'];
        $this->TanggalBuka = $row['TanggalBuka'];
        $this->TanggalTutup = $row['TanggalTutup'];
        $this->Keterangan = $row['Keterangan'];
    }
}

?>