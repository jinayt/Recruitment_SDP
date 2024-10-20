<?php
require_once "dbconnection.php";
   
        $personid = $_POST['personid'];
        $job_id = $_POST['job_id'];

        $queryi="insert into application(job_id,person_id,status,last_update)
                VALUES(:job_id,:personid,'Applied',current_timestamp())";

        $stmti=$conn->prepare($queryi);
        $stmti->execute([
            ':job_id'=>$job_id,
            ':personid'=>$personid
                      
        ]);

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
                        <p class='card-text'>".htmlspecialchars($r['title_name'])."</p>
                        <p class='card-text'>".htmlspecialchars($r['job_discription'])."</p>
                        <h6 class='card-title'>Number of vacancy:</h6>
                        <p class='card-text'>".htmlspecialchars($r['num_of_vacancy'])."</p>
                        <h6 class='card-title'>Last date to apply:</h6>
                        <p class='card-text'>".htmlspecialchars($last_apply_date)."</p>
                        <div style='text-align:center;'>
                        <form>
                        <input type='hidden' id='personid' name='personid' value='".htmlspecialchars($personid)."' >  
                        <button type='button' data-job-id='".htmlspecialchars($r['job_id'])."' class='btn btn-primary apply-button'>Apply</button>
                        </form>       
                        </div>
                    </div>
                </div>";
            }

        }
        else{
            echo "<h4>No jobs to apply.</h4>";
        }
    
    



?>