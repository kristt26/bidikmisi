<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';
// include_once '../../../api/objects/User.php';
include_once '../../../api/objects/Mahasiswa.php';
include_once '../../../api/objects/TahunAjaran.php';

//get connection;
$database = new Database();
$db = $database->getConnection();
$tahun = new TahunAjaran($db);
$stmt = $tahun->read();
$num = $stmt->rowCount();
$arr = array();
$arr["record"]=array();
if($num>0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = array(
            'IdTahunAjaran' => $IdTahunAjaran, 
            'TahunAjaran' => $TahunAjaran,
            'TanggalBuka' => $TanggalBuka,
            'TanggalTutup' =>$TanggalTutup,
        );
        array_push($arr["record"], $item);
    }
    echo json_encode($arr);
}
?>