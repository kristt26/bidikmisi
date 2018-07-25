<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';

include_once '../../../api/objects/TahunAjaran.php';
$database = new Database();
$db = $database->getConnection();
$tahunajaran= new TahunAjaran($db);
$data =json_decode(file_get_contents("php://input"));
if($tahunajaran->update()){
    $tahunajaran->TahunAjaran = $data->TahunAjaran;
    $tahunajaran->TanggalBuka = $data->TanggalBuka;
    $tahunajaran->TanggalTutup = $data->TanggalTutup;
    if($tahunajaran->create()){
        echo json_encode(array("message" => "Success!!!"));
    }else {
        echo json_encode(array("message" => "Gagal Simpan!!!"));
    }
}else
    echo json_encode(array("message" => "Gagal Simpan!!!"));

?>