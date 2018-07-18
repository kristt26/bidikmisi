<?php
class Mahasiswa{
    private $conn;
    private $table_name="mahasiswa";
    public $IdMahasiswa;
    public $NPM;
    public $NamaMahasiswa;
    public $Sex;
    public $Alamat;
    public $Kontak;
    public $Kelas;
    public $Photo;
    public $Status;
    public $IdTahunAjaran;
    public $IdUser;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function Read()
    {
        $queri = "SELECT * FROM ".$this->table_name."";
        $row = $this->conn->prepare($queri);
        $row->execute();
        return $row;
    }
    public function readByUser()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE IdUser= ?";
        $stmt = $this->conn->prepare($query);
        $this->IdUser = htmlspecialchars(strip_tags($this->IdUser));
        $stmt->bindParam(1, $this->IdUser);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->IdMahasiswa = $row["IdMahasiswa"];
        // $this->NPM = $row["NPM"];
        // $this->NamaMahasiswa = $row["NamaMahasiswa"];
        // $this->Sex = $row["Sex"];
        // $this->Alamat = $row["Alamat"];
        // $this->Kontak = $row["Kontak"];
        // $this->Kelas = $row["Kelas"];
        // $this->Photo = $row["Photo"];
        // $this->Status = $row["Status"];
        // $this->IdTahunAjaran = $row["IdTahunAjaran"];
        return true;
    }

    public function ReadOne()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE IdMahasiswa= ?";
        $stmt = $this->conn->prepare($query);
        $this->IdMahasiswa = htmlspecialchars(strip_tags($this->IdMahasiswa));
        $stmt->bindParam(1, $this->IdMahasiswa);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->NPM = $row["NPM"];
        $this->NamaMahasiswa = $row["NamaMahasiswa"];
        $this->Sex = $row["Sex"];
        $this->Alamat = $row["Alamat"];
        $this->Kontak = $row["Kontak"];
        $this->Kelas = $row["Kelas"];
        $this->Photo = $row["Photo"];
        $this->Status = $row["Status"];
        $this->IdTahunAjaran = $row["IdTahunAjaran"];
        $this->IdUser = $row["IdUser"];
        return true;
    }
    public function createSign()
    {
        $queri = "INSERT INTO ". $this->table_name. " SET IdTahunAjaran=?, IdUser=?";
        $stmt = $this->conn->prepare($queri);
        $this->IdTahunAjaran = htmlspecialchars(strip_tags($this->IdTahunAjaran));
        $this->IdUser = htmlspecialchars(strip_tags($this->IdUser));
        $stmt->bindParam(1, $this->IdTahunAjaran);
        $stmt->bindParam(2, $this->IdUser);
        if($stmt->execute()){
            $this->IdMahasiswa = $this->conn->lastInsertId();
            return true;
        }else{
            return false;
        }
    }
    public function update()
    {
        $queri = "UPDATE ". $this->table_name. " SET NPM=?, NamaMahasiswa=?, Sex=?, Alamat=?, Kontak=?, Kelas=?, Photo=?, Status=? WHERE IdMahasiswa=?";
        $stmt = $this->conn->prepare($queri);
        $this->NPM = htmlspecialchars(strip_tags($this->NPM));
        $this->NamaMahasiswa = htmlspecialchars(strip_tags($this->NamaMahasiswa));
        $this->Sex = htmlspecialchars(strip_tags($this->Sex));
        $this->Alamat = htmlspecialchars(strip_tags($this->Alamat));
        $this->Kontak = htmlspecialchars(strip_tags($this->Kontak));
        $this->Kelas = htmlspecialchars(strip_tags($this->Kelas));
        $this->Photo = htmlspecialchars(strip_tags($this->Photo));
        $this->Status = htmlspecialchars(strip_tags($this->Status));
        $this->IdMahasiswa = htmlspecialchars(strip_tags($this->IdMahasiswa));
        $stmt->bindParam(1, $this->NPM);
        $stmt->bindParam(2, $this->NamaMahasiswa);
        $stmt->bindParam(3, $this->Sex);
        $stmt->bindParam(4, $this->Alamat);
        $stmt->bindParam(5, $this->Kontak);
        $stmt->bindParam(6, $this->Kelas);
        $stmt->bindParam(7, $this->Photo);
        $stmt->bindParam(8, $this->Status);
        $stmt->bindParam(9, $this->IdMahasiswa);
        if($stmt->execute())
        {
            return true;
        }else {
            return false;
        }
    }
}

?>