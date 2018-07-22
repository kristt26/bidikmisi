<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';
// include_once '../../../api/objects/User.php';
include_once '../../../api/objects/Mahasiswa.php';
include_once '../../../api/objects/TahunAjaran.php';
include_once '../../../api/objects/Kriteria.php';
include_once '../../../api/objects/KriteriaMahasiswa.php';
include_once '../../../api/objects/NilaiAkhir.php';

//get connection;
$database = new Database();
$db = $database->getConnection();
//inizialisation object;
$mahasiswa = new Mahasiswa($db);
$kriteria = new Kriteria($db);
$kriteriaMahasiswa = new KriteriaMahasiswa($db);
$tahunAjaran = new TahunAjaran($db);
$hasilAkhir = new NilaiAkhir($db);

$Datas = array();
$Datas["Mahasiswas"]=array();
$Datas["Years"]=array();
$Datas["HasilAkhir"]=array();
$stmtMahasiswa = $mahasiswa->read();
while ($rowMahasiswa = $stmtMahasiswa->fetch(PDO::FETCH_ASSOC)) {
    extract($rowMahasiswa);
    $Mahasiswa = array(
        'IdMahasiswa' => $IdMahasiswa,
        'NPM'=> $NPM,
        'NamaMahasiswa' => $NamaMahasiswa,
        'Sex' => $Sex,
        'Alamat' => $Alamat,
        'Kontak' => $Kontak,
        'Kelas' => $Kelas,
        'Photo' => $Photo,
        'Status' => $Status,
        'TahunAjaran'=>$IdTahunAjaran,
        'Kriterias' =>array() 
    );
    $stmtKriteria = $kriteria->read();
    while ($rowKriteria = $stmtKriteria->fetch(PDO::FETCH_ASSOC)) {
        extract($rowKriteria);
        $kriteriaMahasiswa->IdMahasiswa = $IdMahasiswa;
        $kriteriaMahasiswa->IdKriteria =  $IdKriteria;
        $kriteriaMahasiswa->readOne();
        $Kriteria = array(
            "IdKriteria"=>$IdKriteria,
            "Kriteria"=>$Kriteria,
            "Bobot"=>$Bobot,
            "Keterangan"=>$Keterangan,
            "Nilai" => $kriteriaMahasiswa->Nilai,
            "Berkas" => $kriteriaMahasiswa->Berkas,
            "Status" => $kriteriaMahasiswa->Status,
            "Jenis" => $Jenis
        );
        array_push($Mahasiswa["Kriterias"], $Kriteria);
    }
    array_push($Datas["Mahasiswas"], $Mahasiswa);
}
$stmtTahun = $tahunAjaran->read();
while ($rowTahun = $stmtTahun->fetch(PDO::FETCH_ASSOC)) {
    extract($rowTahun);
    $Year = array(
        'IdTahunAjaran' => $IdTahunAjaran,
        'TahunAjaran' => $TahunAjaran,
        'TanggalBuka' => $TanggalBuka,
        'TanggalTutup' => $TanggalTutup,
        'Keterangan' => $Keterangan
    );
    array_push($Datas["Years"], $Year);
}
$stmtHasil = $hasilAkhir->read();
$num = $stmtHasil->rowCount();
while ($rowHasil = $stmtHasil->fetch(PDO::FETCH_ASSOC)) {
    extract($rowHasil);
    $Hasil = array(
        'IdNilaiAkhir' => $IdNilaiAkhir,
        'IdTahunAjaran' => $IdTahunAjaran,
        'IdMahasiswa' => $IdMahasiswa,
        'NilaiAkhir' => $NilaiAkhir,
    );
    array_push($Datas["HasilAkhir"], $Hasil);
}
echo json_encode($Datas);




?>