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

    public function ReadOne()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE IdMahasiswa= ?";
        $row = $this->conn->prepare($queri);
        $this->IdMahasiswa = htmlspecialchars(strip_tags($this->IdMahasiswa));
        $row=bindParam(1, $this->IdMahasiswa);
        $row->execute();
        $row = $row->fetch(PDO::FETCH_ASSOC);
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
    }

    public function FunctionName(Type $var = null)
    {
        # code...
    }
}

?>