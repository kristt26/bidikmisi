<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';

include_once '../../../api/objects/Kriteria.php';
include_once '../../../api/objects/SubKriteria.php';

$database = new Database();
$db = $database->getConnection();
$kriteria = new Kriteria($db);
$subkriteria = new SubKriteria($db);

$stmt = $kriteria->read();
$numRowKriteria = $stmt->rowCount();
if($numRowKriteria>0){
    $DatasKriteria=array(
        "Kriteria"=>array(),
        "message" => "Kriteria found"
    );
    while ($rowKriteria = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($rowKriteria);
        $ItemKriteria=array(
            "IdKriteria"=>$IdKriteria,
            "Kriteria"=>$Kriteria,
            "Bobot"=>$Bobot,
            "Keterangan"=>$Keterangan,
            "Jenis" => $Jenis,
            "SubKriteria"=>array()
        );
        $subkriteria->IdKriteria=$IdKriteria;
        $stmtSub = $subkriteria->readOne();
        while ($rowSub = $stmtSub->fetch(PDO::FETCH_ASSOC)) {
            extract($rowSub);
            $ItemSub = array(
                "IdSubKriteria"=>$IdSubKriteria,
                "Jarak"=>$Jarak,
                "BobotSubKriteria"=>$BobotSubKriteria
            );
            array_push($ItemKriteria["SubKriteria"], $ItemSub);
        }
        array_push($DatasKriteria["Kriteria"], $ItemKriteria);
    }
    echo json_encode($DatasKriteria);
}else {
    echo json_encode(
        array("message" => "No Kriteria found.")
    );
}

?>