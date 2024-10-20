<?php
require_once "dbconnection.php";
    session_start();
    $otp = $_SESSION['otp']; 
    echo $otp;
    exit();
    if($_POST['otp'] == $otp){
        $username = $_SESSION['username'];
        echo $username;
        $pass = trim($_POST['password']);
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
        $query = "update login_details
                set log_pass = :pass
                WHERE Login_id = :username";

        $stmt = $conn->prepare($query);
        $result = $stmt->execute([':username' => $username,
                        ':pass'=>$hashedPassword   
                        ]);
        
        //print_r($result);
        if ($result) {
            // print_r($result);
            session_destroy();
            } else {
                echo "<script>alert('Lag gayi')</script>";
            }
        
    }
    else {
        echo "Not match";
    }
    
    $conn = null;



?>