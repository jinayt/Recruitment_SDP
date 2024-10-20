<?php 
include_once "header.php";
include_once "dbconnection.php";


    $err1=$err2="";
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
       if(empty($_POST['username']) || empty($_POST['password']))
        {
            $err1="Enter both user name and password.<br>";
        }
        else
        {
            $username=trim($_POST['username']);
            $pass=trim($_POST['password']);
            
            $query="SELECT *
            FROM login_details
            WHERE Login_id = :username";

            $stmt = $conn->prepare($query);
            $stmt->execute([':username'=>$username]);    
            $result= $stmt->fetch();
            //print_r($result);
            if($result && password_verify($pass,$result['log_pass']))
            {
                // print_r($result);
                $_SESSION['personid'] = $result['Person_id'];
                $_SESSION['role']=$result['Role'];
                
                if($result['Role']=="A"){
                    header("location:dashboard_admin.php");
                    exit();
                }
                else{
                    header("location:dashbord.php");
                    exit();
                }
                
            }
            else{
                $err2="Please Enter valid details.<br>";
            }
            
            
        }
        
        $conn=null;
    }


?>
    <div class="min_wid">
        <div class="login">
                <form method="post">
                <i class="fa-regular fa-user" style="color: black; font-size:30px;"></i><span style="color: black; font-size:30px;"> Login</span>
                    <hr>
                    <table>
                        <tr><td> <i class="fa-solid fa-user"></i></td>
                            <td><input type="text" name="username" placeholder="Enter user name"></td>
                        </tr>
                        <tr><td> <i class="fa-solid fa-lock"></i></td>
                            <td><input type="password" name="password" placeholder="Enter password"></td></tr>
                    </table>
                    <span class="err"><?php echo $err1;echo $err2;?></span>
                    
                    <div class="btnn mb-3">
                        <button class="btn1" type="submit" name="btn_login1" >Login</button>
                        
                    </div>
                    <a href="forgot_pass.php">Forgot Password</a>
                </form>
                    
        </div>
    </div>


<?php include_once "footer.php";?>
