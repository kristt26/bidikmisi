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
$user = new User();
$data=json_decode(file_get_contents("php://input"));

$user->Username = $data->Username;
$user->Password = $data->Password;

$stmt= $user->read();
$num=$stmt->rowCount();
if($num>0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $itemUser =array(
            ""
        );
    }
}
?>