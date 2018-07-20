<?php
class NilaiAkhir
{
    private $conn;
    private $table_name="nilaiakhir";
    public $IdNilaiAkhir;
    public $IdTahunAjaran;
    public $IdMahasiswa;
    public $NilaiAkhir;
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
}

?>