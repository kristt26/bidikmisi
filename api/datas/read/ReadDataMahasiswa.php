<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';
include_once '../../../api/objects/User.php';
include_once '../../../api/objects/Mahasiswa.php';
include_once '../../../api/objects/TahunAjaran.php';
include_once '../../../api/objects/Kriteria.php';
include_once '../../../api/objects/KriteriaMahasiswa.php';
include_once '../../../api/objects/SubKriteria.php';
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$mahasiswa = new Mahasiswa($db);
$tahunajaran = new TahunAjaran($db);
$user = new User($db);
$kriteria = new Kriteria($db);
$kriteriamahasiswa = new KriteriaMahasiswa($db);
$subkriteria = new SubKriteria($db);
$DataMahasiswa=array();
$DataMahasiswa['record']=array();
session_start();
$stmtMahasiswas = $mahasiswa->Read();
$num = $stmtMahasiswas->rowCount();
if($num>0)
{
    while ($rowMahasiswas = $stmtMahasiswas->fetch(PDO::FETCH_ASSOC)) {
        extract($rowMahasiswas);
        $tahunajaran->IdTahunAjaran= $IdTahunAjaran;
        $tahunajaran->readOne();
        $ItemMahasiswa = array(
            'IdMahasiswa' => $IdMahasiswa,
            'NPM'=> $NPM,
            'NamaMahasiswa' => $NamaMahasiswa,
            'Sex' => $Sex,
            'Alamat' => $Alamat,
            'Kontak' => $Kontak,
            'Kelas' => $Kelas,
            'Photo' => $Photo,
            'Status' => $Status,
            'TahunAjaran'=>$tahunajaran->TahunAjaran,
            'User'=> array(),
            'Kriteria' =>array()
        );
        $user->IdUser = $IdUser;
        $user->readById();
        $ItemUser = array(
            'Username' => $user->Username, 
            'Email' => $user->Email,
            'Active' => $user->Active
        );
        array_push($ItemMahasiswa["User"], $ItemUser);
        $stmtKriteria = $kriteria->read();
        while ($rowKriteria = $stmtKriteria->fetch(PDO::FETCH_ASSOC)) {
            extract($rowKriteria);
            $ItemKriteria=array(
                "IdKriteria"=>$IdKriteria,
                "Kriteria"=>$Kriteria,
                "Bobot"=>$Bobot,
                "Keterangan"=>$Keterangan,
                "KriteriaMahasiswa"=>array()
            );
            $kriteriamahasiswa->IdMahasiswa = $IdMahasiswa;
            $kriteriamahasiswa->IdKriteria = $IdKriteria;
            $kriteriamahasiswa->readOne();
            $subkriteria->IdKriteria = $IdKriteria;
            $subkriteria->BobotSubKriteria = $kriteriamahasiswa->Nilai;
            $subkriteria->readbyIdKriteriaBobot();
            $ItemKriteriaMahasiswa = array(
                'IdKriteriaMahasiswa' => $kriteriamahasiswa->IdKriteriaMahasiswa, 
                'Nilai' => $kriteriamahasiswa->Nilai,
                'Berkas' => $kriteriamahasiswa->Berkas,
                'Status' => $kriteriamahasiswa->Status,
                'Jarak' => $subkriteria->Jarak
            );
            array_push($ItemKriteria["KriteriaMahasiswa"], $ItemKriteriaMahasiswa);
            array_push($ItemMahasiswa["Kriteria"], $ItemKriteria);
        }
        array_push($DataMahasiswa["record"], $ItemMahasiswa);
    }
    
    echo json_encode($DataMahasiswa);
}


// $data=json_decode(file_get_contents("php://input"));

?>