<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/src/Exception.php";
require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/SMTP.php";

try {
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;

    if (isset($_POST['username'])) {

        $username = $_POST['username'];
        $_SESSION['username'] = $_POST['username'];
        require_once 'dbconnection.php';
        $query = "SELECT per.Email
            FROM person per
            JOIN login_details ld on ld.Person_id = per.Person_id 
            where ld.Login_id = :username";

        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':username' => $username

        ]);
        if($stmt->rowCount()>0){
            $result = $stmt->fetch();
        // print_r($result);
        $email = $result['Email'];
        

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tandel.jinay77@gmail.com';
        $mail->Password = 'ztgyvfcbbvhchgde';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('tandel.jinay77@gmail.com', 'Do Not Reply');

        $mail->addAddress($email);

        $mail->isHTML(true);

        $mail->Subject = 'Reseat Password OTP';
        $mail->Body = "Your 6 digit OTP code: <b>$otp</b>";

        if (!$mail->send()) {
            echo $mail->ErrorInfo;
        } else {
            $html = <<<EOD
                    <form id="myform" method="post" onsubmit="return validateForm()">
                    <table>
                    <tr><td><i class="fa-solid fa-lock"></i></td>
                            <td><input type="number" name="otp" placeholder="Enter OTP" maxlength="6" min=1></td>
                    </tr>
                    <tr><td></td><td><span class="err" id="otpError"></span></td></tr>
                    <tr><td><i class="fa-solid fa-lock"></i></td>
                            <td><input type="password" name="password" placeholder="Enter password"></td>
                    </tr>
                    <tr><td></td><td><span class="err" id="pwdError"></span></td></tr>
                    
                    <tr><td> <i class="fa-solid fa-lock"></i></td>
                            <td><input type="password" name="cnfpassword" placeholder="Confirm password"></td>
                 </tr>
                 <tr><td></td><td><span class="err" id="cnfpasError"></span></td></tr>
                 </table>
                 <div class="btnn">
                        <button class="btn1" type="submit" name="btn_login1" >Submit</button>
                    </div>
                </form>
        EOD;
        echo $html;
        }
        }
        else{
            echo"<script>alert('Username not found');window.location.href='forgot_pass.php';</Script>";
        }
        
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
