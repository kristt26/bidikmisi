<?php
class NilaiAkhir
{
    private $conn;
    private $table_name="nilaiakhir";
    public $IdNilaiAkhir;
    public $IdTahunAjaran;
    public $IdMahasiswa;
    public $NilaiAkhir;
    public $Alternatif;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function read()
    {
        $queri = "SELECT * FROM ".$this->table_name."";
        $row = $this->conn->prepare($queri);
        $row->execute();
        return $row;
    }
    public function create()
    {
        $queri = "INSERT INTO ". $this->table_name. " SET IdTahunAjaran=?, IdMahasiswa=?, Alternatif=?, NilaiAkhir=?";
        $stmt = $this->conn->prepare($queri);
        $stmt->bindParam(1, $this->IdTahunAjaran);
        $stmt->bindParam(2, $this->IdMahasiswa);
        $stmt->bindParam(3, $this->Alternatif);
        $stmt->bindParam(4, $this->NilaiAkhir);
        if($stmt->execute()){
            $this->IdNilaiAkhir = $this->conn->lastInsertId();
            return true;
        }else{
            return false;
        }
    }
}

?>