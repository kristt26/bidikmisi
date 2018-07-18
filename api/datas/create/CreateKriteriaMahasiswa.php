<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../../api/config/database.php';

include_once '../../../api/objects/KriteriaMahasiswa.php';
session_start();
$database = new Database();
$db = $database->getConnection();
$kriteriaMahasiswa = new KriteriaMahasiswa($db);
$data=json_decode(file_get_contents("php://input"));
$kriteriaMahasiswa->IdMahasiswa = $_SESSION["IdMahasiswa"];
$kriteriaMahasiswa->IdKriteria = $data->IdKriteria;
$kriteriaMahasiswa->Nilai = $data->Nilai;
$kriteriaMahasiswa->Berkas = $data->Berkas;
$kriteriaMahasiswa->Status = "Pending";
if($kriteriaMahasiswa->create()){
    echo json_encode(array("message" => $kriteriaMahasiswa->IdKriteriaMahasiswa));
}else {
    echo json_encode(array("message" => "invalid!"));
}
?>