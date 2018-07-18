<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';
include_once '../../../api/objects/User.php';
include_once '../../../api/objects/Mahasiswa.php';
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$mahasiswa = new Mahasiswa($db);
$Data_Verifikasi=array(
    "Biodata"=>array(),
    "Kelengkapan"=>array()
);
session_start();
$mahasiswa->IdMahasiswa=$_SESSION["IdMahasiswa"];
$mahasiswa->readOne();
$item_mahasiswa = array(
    'NPM' => $mahasiswa->NPM, 
    'NamaMahasiswa'=>$mahasiswa->NamaMahasiswa,
    'Sex'=>$mahasiswa->Sex,
    'Alamat'=>$mahasiswa->Alamat,
    'Kontak'=>$mahasiswa->Kontak,
    'Kelas'=>$mahasiswa->Kelas,
    'Photo'=>$mahasiswa->Photo,
    'Status'=>$mahasiswa->Status,
);
array_push($Data_Verifikasi["Biodata"], $item_mahasiswa);
echo json_encode($Data_Verifikasi);
// $data=json_decode(file_get_contents("php://input"));

?>