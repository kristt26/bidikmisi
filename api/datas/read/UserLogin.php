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
$data=json_decode(file_get_contents("php://input"));

$user->Username = $data->Username;
$user->Password = md5($data->Password);
$user->read();

if($user->IdUser!=null)
{
    $mahasiswa->IdUser=$user->IdUser;
    $mahasiswa->readByUser();
    session_start();
    $_SESSION["Username"] = $user->Username;
    $_SESSION["Email"] = $user->Email;
    $_SESSION["Akses"] = $user->Akses;
    $_SESSION["Active"] = $user->Active;
    $_SESSION["IdMahasiswa"]=$mahasiswa->IdMahasiswa;
    $_SESSION["IdUser"]=$user->IdUser;
    echo json_encode(array("Session" => $_SESSION));
}else {
    echo json_encode(array("message" => "Username dan Password Salah!"));
}

?>