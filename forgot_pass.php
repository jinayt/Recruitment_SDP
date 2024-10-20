<?php
include_once "header.php";
require_once "dbconnection.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){   
    $otp = $_SESSION['otp']; 
    
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
            echo "<script>alert('Password changed Successfull.');window.location.href='login.php'</script>";
            
            } else {
                echo "<script>alert('Lag gayi')</script>";
            }
        
    }
    else {
        echo "Not match";
    }
    }
    
    $conn = null;


?>
<div class="min_wid">
    <div class="login">

        <i class="fa-regular fa-user" style="color: black; font-size:30px;"></i><span style="color: black; font-size:30px;"> Login</span>
        <hr>
        <div id='login'>
            <table>
                <tr>
                    <td> <i class="fa-solid fa-user"></i></td>
                    <td><input type="text" name="username" placeholder="Enter user name"></td>
                </tr>

            </table>
            <span class="err" id="usernameError"></span>
            <div class="btnn">
                <button class="btn1" type="button" id="btn_otp" name="btn_otp">Send OTP</button>
            </div>
        </div>



    </div>
</div>


<script type="text/javascript">
    $('#btn_otp').on('click', function() {
        var username = $('input[name="username"]').val();
        if (!username) {
            $('#usernameError').html('Please Enter username.<br>');
        } else {
            $.ajax({
                url: 'send_mail.php',
                type: 'POST',
                data: {
                    username: username
                },
                success: function(data) {
                    $("#login").html(data);
                },
                error: function(xhr, status, error) {
                    alert('AJAX Error: ' + error);
                }

            });
        }
    });

    function validateForm() {
        var valid = true;
        var pattern = /^\d{6}$/;
        var otp = $('input[name="otp"]').val().trim();
        
        if (!pattern.test(otp)) {
            $('#otpError').html('Please Enter 6 digit OTP.<br>');
            valid = false;
        }
        else{
            $('#otpError').html('');
        }
        
        var password = $('input[name="password"]').val();
        password = password ? password.trim() : '';
        var passPattern = /^(?=.*[A-Z])(?=.*[\W]).{6,}$/;
        if (!password) {
            $('#pwdError').html('Enter password.<br>');
            valid = false;

        } else if (!passPattern.test(password)) {
            $('#pwdError').html('Please Enter 6 character password.(1 uppercase latter, 1 special characters)<br>');
            valid = false;

        } else {
            $('#pwdError').html('');
           
        }
        var cnfpassword = $('input[name="cnfpassword"]').val();
        cnfpassword = cnfpassword ? cnfpassword.trim() : '';
        //confirm password
        if (!cnfpassword) {
            $('#cnfpasError').html('Enter Confirm password.<br>');
            valid = false;

        } else if (cnfpassword != password) {
            $('#cnfpasError').html('Confirm password not matching.<br>');
            valid = false;

        }
        return valid;
    }

/*

    $(document).on('click', '#submit', function(e) {
            e.preventDefault();    
        if (!validateForm()) {
            return;
        }
        else{
                    
           

        $.ajax({
            url: 'forgot_pass_man.php',
            type: 'POST',
            success: function(data) {
                // $('#table_data').html(data);
                
                alert(data); 
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
                alert("Error: " + xhr.responseText);
            }

        });
    }
        });
    */
    
</script>

<?php include_once "footer.php"; ?>