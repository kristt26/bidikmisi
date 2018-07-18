<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../../api/config/database.php';

include_once '../../../api/objects/Mahasiswa.php';
$database = new Database();
$db = $database->getConnection();
$mahasiswa = new Mahasiswa($db);
$data=json_decode(file_get_contents("php://input"));
$mahasiswa->NPM=$data->NPM;
$mahasiswa->NamaMahasiswa=$data->NamaMahasiswa;
$mahasiswa->Sex=$data->Sex;
$mahasiswa->Alamat=$data->Alamat;
$mahasiswa->Kontak=$data->Kontak;
$mahasiswa->Kelas=$data->Kelas;
$mahasiswa->Photo=$data->Photo;
$mahasiswa->Status="Pending";
session_start();
$mahasiswa->IdUser= $_SESSION["IdUser"];
$mahasiswa->readByUser();
if($mahasiswa->update())
{
    echo json_encode(array("message" => "Data was updated!"));
}else {
    echo json_encode(array("message" => "Data Can't Update!"));
}

?>