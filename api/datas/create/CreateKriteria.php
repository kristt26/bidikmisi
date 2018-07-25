<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';

include_once '../../../api/objects/Kriteria.php';

$database = new Database();
$db = $database->getConnection();
$kriteria = new Kriteria($db);
$data =json_decode(file_get_contents("php://input"));
$kriteria->Kriteria = $data->Kriteria;
$kriteria->Bobot =  $data->Bobot;
$kriteria->Keterangan = $data->Keterangan;
$kriteria->Jenis = $data->Jenis;
if($kriteria->create()){
    echo json_encode(array("IdKriteria" => $kriteria->IdKriteria));
}else {
    echo json_encode(array("Message" => "Gagal Simpan"));
}

?>