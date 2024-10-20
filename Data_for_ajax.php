<?php
    require_once "dbconnection.php";

//new tittle input

    if(isset($_POST['new_title'])){
        $new_title = $_POST['new_title'];
            //echo print_r($_POST);exit();
            try{
                $query = "SELECT *
                FROM job_title
                WHERE lower(title_name) = lower(:new_title)";

                $stmt = $conn->prepare($query);
                $stmt->execute([':new_title' => $new_title]);
                $result = $stmt->fetch();
                
                        if ($result) {
                            echo "exists";
                        }
                        else{
                            echo "Not exists";
                        }

            }
            catch (PDOException $e){
                die("Connection Fail."). $e->getMessage();
            }

    }
    
//username uniqueness verify
   
    if(isset($_POST['username'])){
            $username = $_POST['username'];
            //echo print_r($_POST);exit();
            $query = "SELECT *
            FROM login_details
            WHERE Login_id = :username";
            $stmt = $conn->prepare($query);
            $stmt->execute([':username' => $username]);
            $result = $stmt->fetch();
        
            
            if ($result) {
                echo "exists";
            }
            else{
                echo "Not exists";
            }
    }

    //apply for job
    if(isset($_POST['personid'])){
               
        $query = "SELECT *
        FROM  job_opportunity jo, job_title jt
        where jo.status = 'Active'
        AND jo.title_id = jt.title_id
        and jo.job_id not in (SELECT a.job_id
        FROM  application a
        where a.person_id = $personid)";
      

        $stmt = $conn->query($query);
        $result = $stmt->fetchall();

        if(count($result)>0){
            foreach ($result as $r)
            {
                $a_date = new DateTime($r['date_of_closing']);
                $last_apply_date = $a_date->format("d-m-Y"); 
                
                echo"          
                <div class='card d-inline-block shadow me-3' style='width: 18rem;'>
                    <div class='card-body'>
                        <h6 class='card-title'>Profile:</h6>
                        <p class='card-text'>".$r['title_name']."</p>
                        <p class='card-text'>".$r['job_discription']."</p>
                        <h6 class='card-title'>Number of vacancy:</h6>
                        <p class='card-text'>".$r['num_of_vacancy']."</p>
                        <h6 class='card-title'>Last date to apply:</h6>
                        <p class='card-text'>".$last_apply_date."</p>
                        <div style='text-align:center;'>
                        <input type='hidden' id='personid' value='".$personid."' >  
                        <input type='hidden' id='job_id' value='".$r['job_id']."' >  
                        <button id='apply' class='btn btn-primary' onclick='return applyJob();'>Apply</button>
                                    
                        </div>
                    </div>
                </div>";
            }

        }
        else{
            echo "<h4>No jobs to apply.</h4>";
        }
    }


$conn=null;
?>