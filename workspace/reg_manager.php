<?php

// header("location:registration.php")

require_once "dbconnection.php";
//echo '<pre>';print_r($_POST);exit();

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$dob = $_POST['dob'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$username = $_POST['username'];
$login_pass = $_POST['paswrd'];



# Registration data storing
try {
    $query = "SELECT *
            FROM Person
            WHERE Login_id = :username";
    $stmt = $db->prepare($query);
    $stmt->execute([':username' => $username]);
    $result = $stmt->fetchAll();
    //echo "<pre>" . print_r($result);
    //exit();

    if ($result) {
        echo "<script>

                document.getElementById('usernameError').innerHTML='Username already exist';
                return false;
                </script>";
    } else {
        $query = "INSERT INTO Person(first_name,last_name,gender,date_of_birth,mobile_no,email,login_id,log_pass)
        VALUES(:fname, :lname, :gender, :dob, :mobile, :email, :username, :login_pass)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':fname' => $fname,
            ':lname' => $lname,
            ':dob' => $dob,
            ':mobile' => $mobile,
            ':email' => $email,
            ':gender' => $gender,
            ':username' => $username,
            ':login_pass' => $login_pass
        ]);
        echo"<script>
                alert('Form submit successfully.');
                window.location.href='registration.php';
            </script>";
        
    }
} catch (PDOException $e) {
    echo "error" . $e->getMessage();
}
$db = null;
