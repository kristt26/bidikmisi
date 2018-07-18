<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';

include_once '../../../api/objects/SubKriteria.php';
$database = new Database();
$db = $database->getConnection();
$subkriteria = new SubKriteria($db);
$data =json_decode(file_get_contents("php://input"));
$subkriteria->IdSubKriteria = $data;
$subkriteria->readbyId();
if($subkriteria->delete())
{
    echo json_encode(array("IdKriteria" => $subkriteria->IdKriteria));
}else {
    echo json_encode(array("message" => "Gagal di Hapus"));
}

?>