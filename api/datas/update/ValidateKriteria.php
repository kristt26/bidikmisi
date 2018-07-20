<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';

include_once '../../../api/objects/KriteriaMahasiswa.php';
$database = new Database();
$db = $database->getConnection();
$kriteriamahasiswa = new KriteriaMahasiswa($db);
$data =json_decode(file_get_contents("php://input"));
$kriteriamahasiswa->IdKriteriaMahasiswa = $data;
$kriteriamahasiswa->Status ="true";
if($kriteriamahasiswa->update()){
    echo json_encode(array("message" => "Success!!!"));
}else {
    echo json_encode(array("message" => "FatalErrror!!!"));
}

?>