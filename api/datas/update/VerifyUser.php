<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>BIDIK MISI > Sign up</title>
    <link href="../../../assets/css/style.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <!-- start header div --> 
    <div id="header">
        <h3>NETTUTS > Sign up</h3>
    </div>
    <!-- end header div -->   
     
    <!-- start wrap div -->   
    <div id="wrap">
        <!-- start PHP code -->
        <?php
         
         $con = @mysqli_connect('localhost', 'root', '', 'db_bidikmisi');

         if (!$con) {
             echo "Error: " . mysqli_connect_error();
             exit();
         }

         if(isset($_GET['IdUser']) && !empty($_GET['IdUser']) && isset($_GET['Email']) && !empty($_GET['Email']) AND isset($_GET['Hash']) && !empty($_GET['Hash'])){
            // Verify data
            $IdUser = $_GET['IdUser'];
            $Email = $_GET['Email']; // Set email variable
            $Hash = $_GET['Hash']; // Set hash variable
            $search = mysqli_query($con, "SELECT Email, Hash, Active FROM user WHERE IdUser='".$IdUser."' AND Email='".$Email."' AND Hash='".$Hash."' AND Active='0'") or die(mysqli_error()); 
            $match  = mysqli_num_rows($search);
            
            if($match > 0){
                // We have a match, activate the account
                mysqli_query($con, "UPDATE user SET Active='1' WHERE IdUser='".$IdUser."' AND Email='".$Email."' AND Hash='".$Hash."' AND Active='0'") or die(mysqli_error());
                echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
            }else{
                // No match -> invalid url or account has already been activated.
                echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
            }
        }else
        {
            echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
        }
             
        ?>
        <!-- stop PHP Code -->
 
         
    </div>
    <!-- end wrap div --> 
</body>
</html>