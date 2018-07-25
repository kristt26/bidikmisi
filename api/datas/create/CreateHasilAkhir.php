<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';
include_once '../../../api/objects/NilaiAkhir.php';
include_once '../../../api/objects/TahunAjaran.php';
$database = new Database();
$db = $database->getConnection();
$nilaiAkhir = new NilaiAkhir($db);
$tahunajaran = new TahunAjaran($db);
$data =json_decode(file_get_contents("php://input"));
$tahunajaran->Keterangan ="true";
$tahunajaran->readAktif();
$a = new DateTime();
$aa=str_replace('-', '/', $a->format('Y-m-d'));
$aaa = date('Y-m-d',strtotime($aa . "+1 days"));
$b = new DateTime($tahunajaran->TanggalTutup);
$c = new DateTime($aaa);
$d = count($data);
$DataArray = array();
$DataArray["record"]=array();
if($b>$c){
    for ($i=0; $i < $d; $i++) { 
        $nilaiAkhir->IdTahunAjaran= $tahunajaran->IdTahunAjaran;
        $nilaiAkhir->IdMahasiswa = $data[$i]->IdMahasiswa;
        $nilaiAkhir->Alternatif = $data[$i]->Alternatif;
        $nilaiAkhir->NilaiAkhir = $data[$i]->NilaiAkhir;
        $nilaiAkhir->create();
        $item = array(
            'IdNilaiAkhir' => $nilaiAkhir->IdNilaiAkhir,
            'IdTahunAjaran' => $tahunajaran->IdTahunAjaran,
            'IdMahasiswa' => $data[$i]->IdMahasiswa,
            'NPM' => $data[$i]->NPM,
            'NamaMahasiswa' => $data[$i]->NamaMahasiswa,
            'Alternatif' => $data[$i]->Alternatif,
            'NilaiAkhir' => $data[$i]->NilaiAkhir
        );
        array_push($DataArray["record"], $item);
    }
    echo json_encode($DataArray);
}else {
    echo json_encode(array("message" => "Gagal!"));
}
?>