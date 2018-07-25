<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';

include_once '../../../api/objects/User.php';
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$data =json_decode(file_get_contents("php://input"));
$user->IdUser = $data->IdUser;
$user->readById();
$OldPassword = md5($data->OldPassword);
$NewPassword = md5($data->NewPassword);
if($user->Password==$OldPassword)
{
    $user->Password=$NewPassword;
    if($user->update()){
        echo json_encode(array("message" => "Password Berhasil diubah!", "Akses" => $user->Akses));
    }else {
        echo json_encode(array("message" => "Password Gagal diubah!"));
    }
}else
{
    echo json_encode(array("message" => "Password Lama Anda Tidak Sesuai!"));
}
?>