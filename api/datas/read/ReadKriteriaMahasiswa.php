<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';

include_once '../../../api/objects/Kriteria.php';
include_once '../../../api/objects/SubKriteria.php';
include_once '../../../api/objects/Mahasiswa.php';
include_once '../../../api/objects/KriteriaMahasiswa.php';
session_start();
$database = new Database();
$db = $database->getConnection();
$kriteria = new Kriteria($db);
$subkriteria = new SubKriteria($db);
$mahasiswa= new Mahasiswa($db);
$kriteriaMahasiswa = new KriteriaMahasiswa($db);

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
            "SubKriteria"=>array(),
            "KriteriaMhasiswa"=>array(),
            "Nilai"=>"",
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
        
        $kriteriaMahasiswa->IdKriteria=$IdKriteria;
        $kriteriaMahasiswa->IdMahasiswa=$_SESSION['IdMahasiswa'];
        $kriteriaMahasiswa->readOne();
        $ItemMahasiswa = array(
            'Nilai' => $kriteriaMahasiswa->Nilai, 
            'Berkas' => $kriteriaMahasiswa->Berkas,
            'Status' => $kriteriaMahasiswa->Status
        );
        array_push($ItemKriteria["KriteriaMhasiswa"], $ItemMahasiswa);
        $ItemKriteria["Nilai"]=$kriteriaMahasiswa->Nilai;
        array_push($DatasKriteria["Kriteria"], $ItemKriteria);
    }
    echo json_encode($DatasKriteria);
}else {
    echo json_encode(
        array("message" => "No Kriteria found.")
    );
}

?>