<?php
require_once ("dbconnection.php");
    $query = "SELECT 
                app.*, 
                jt.title_name, 
                per.First_name, 
                per.Last_name, 
                per_int.First_name as int_fname, 
                per_int.Last_name as int_lname
                FROM 
                application app
                JOIN 
                job_opportunity jo ON app.job_id = jo.job_id
                JOIN 
                job_title jt ON jo.title_id = jt.title_id
                JOIN 
                person per ON per.Person_id = app.person_id
                LEFT JOIN 
                person per_int ON app.Interviewer_id = per_int.Person_id
                where 1=1";
                
                
                
    //search
    if(!empty($_POST['search'])){
        $search = $_POST['search'];
        $query .= " and (per.First_name like '%{$search}%' or per.Last_name like '%{$search}%' or jt.title_name like '%{$search}%')";

    }
   
    //position
    if(!empty($_POST['position'])){
        $position = $_POST['position'];    
        $query .= " and jt.title_name = '$position'";
    }

    //from date
    if(!empty($_POST['from_date'])){
        $from_date = $_POST['from_date'];    
        $query .= " and app.date_of_application >= '$from_date'";
    }

    //to date
    if(!empty($_POST['to_date'])){
        $to_date = $_POST['to_date'];    
        $query .= " and app.date_of_application <= '$to_date'";
    }

    if(!empty($_POST['status'])){
        $status = $_POST['status'];    
        $query .= " and app.status in('$status')";
    }

    if(!empty($_POST['candidate_id'])){
        $candidate_id = $_POST['candidate_id'];    
        $query .= " and app.person_id =  $candidate_id";
    }
    
    $query .= " ORDER BY app.date_of_application DESC";
    
    echo $query;
    
    $stmt =  $conn->query($query);
    $result = $stmt->fetchall();
    $num=1;

    if(count($result)>0)
    {
        foreach ($result as $r){
            $a_date = new DateTime($r['date_of_application']);
            $apply_date = $a_date->format("d-m-Y");
            echo "<tr>
                                        <td>".htmlspecialchars($num)."</td>
                                        <td>".htmlspecialchars($r['person_id'])."</td>
                                        <td>".htmlspecialchars(strtoupper($r['First_name']))."</td>
                                        <td>".htmlspecialchars(strtoupper($r['Last_name']))."</td>
                                        <td>".htmlspecialchars(strtoupper($r['title_name']))."</td>
                                        <td>".htmlspecialchars($apply_date)."</td>
                                        <td>".htmlspecialchars(strtoupper($r['status']))."</td>

                                    </tr>";
                                    $num++ ;


        }

                        
    }
    else{
        echo "<td colspan=3><h4>No record Found.</h4></td>";
    }



?>