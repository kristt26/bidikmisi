<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../../api/config/database.php';

include_once '../../../api/objects/User.php';
require '../../../assets/PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$data =json_decode(file_get_contents("php://input"));
//set user property values
$user->Username = $data->username;
$user->Email = $data->email;
$user->Password = md5($data->password);
$user->Akses = "Mahasiswa";
$user->Hash = md5(rand(0,1000));
if($user->create()){
    $to      = $user->Email; // Send email to our user
    $subject = 'Signup | Verification'; // Give the email a subject 
    $message = '<div class="statusmsg">
    
    Thanks for signing up!<br>
    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
    <br>
    ------------------------<br>
    Username: '.$user->Username.'<br>
    Password: '.$data->password.'<br>
    ------------------------<br>
    
    Please click this link to activate your account:<br>
    http://localhost/bidikmisi/api/datas/update/VerifyUser.php?IdUser='.$user->IdUser.'&Email='.$user->Email.'&Hash='.$user->Hash.'<br>
    
    </div>'; // Our message above including the link
                        
    //$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
    // mail($to, $subject, $message, $headers); // Send our email
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'yonathankondobua@gmail.com';
    $mail->Password = '26031988@Aj';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom($user->Username, $user->Username);
    $mail->addReplyTo('yonathankondobua@gmail.com', 'BidikMisi');

    // Menambahkan penerima
    $mail->addAddress($to);

    // Menambahkan beberapa penerima
    //$mail->addAddress('penerima2@contoh.com');
    //$mail->addAddress('penerima3@contoh.com');

    // Menambahkan cc atau bcc 
    // $mail->addCC('cc@contoh.com');
    // $mail->addBCC('bcc@contoh.com');

    // Subjek email
    $mail->Subject = $subject;

    // Mengatur format email ke HTML
    $mail->isHTML(true);

    // Konten/isi email
    //$mail->mailHeader = $headers;
    
    $mail->Body = $message;
    if(!$mail->send()){
        echo '{';
            //echo '"UserId": "'.$barang->IdBarang.'"';
            echo '"message": "Pesan tidak dapat dikirim."';
            echo '"MailerError": "'.$mail->ErrorInfo.'"';
        echo '}';
    }else{
        echo '{';
            echo '"message": "Pesan telah terkirim."';
        echo '}';
    }
}else{
    echo '{';
        echo '"message": "Unable to create user."';
    echo '}';
}
?>