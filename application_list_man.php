<?php
require_once ("dbconnection.php");

function loadData($conn){
    $query = "SELECT app.*,jt.title_name,per.First_name, per.Last_name
    from application app, job_opportunity jo, job_title jt, person per
    where app.job_id = jo.job_id
    and jo.title_id = jt.title_id
    and app.status = 'Applied'
    and per.Person_id = app.person_id
    ORDER by app.person_id,jt.title_name";

    $stmt = $conn->query($query);
    $result = $stmt->fetchall();
    $num=1;

    if(count($result)>0)
    {
        foreach ($result as $r){
            $a_date = new DateTime($r['date_of_application']);
            $apply_date = $a_date->format("d-m-Y");
            echo "<tr>      <td>".$num."</td>
                            <td> ".$r['person_id']."</td>
                            <td> ".strtoupper($r['First_name'])."</td>
                            <td>".strtoupper($r['Last_name'])."</td>
                            <td>".strtoupper($r['title_name'])."</td>
                            <td>".$apply_date."</td>
                            <td>
                                <a id='viewButton' class='btn btn-primary mr-2' href='profile.php?id=".$r['person_id']."'>View</a>
                                <button id='approveButton' class='btn btn-success mr-2' data-bs-toggle='modal' data-bs-target='#approval' data-app-id=".$r['application_id'].">Approve</button>
                                <button id='rejectButton' class='btn btn-warning mr-2' data-rej-id=".$r['application_id'].">Reject</button>
                                <button id='deleteButton' class='btn btn-danger' data-del-id=".$r['application_id'].">Delete</button>
                                
                            </td>
                        </tr>";
                        $num++;

        }

                        
    }
    else{
        echo "<td colspan=3><h4>No record Found.</h4></td>";
    }


}

//application search
if(isset($_POST['search']) or isset($_POST['position']))
{
    if(isset($_POST['search'])){
        $search = $_POST['search'];
    }
   
    
    if(!empty($_POST['position']) && !empty($_POST['search'])){
    
        $position = $_POST['position'];    
        
        $query = "SELECT app.*,jt.title_name,per.First_name, per.Last_name
        from application app, job_opportunity jo, job_title jt, person per
        where app.job_id = jo.job_id
        and jo.title_id = jt.title_id
        and app.status = 'Applied'
        and per.Person_id = app.person_id
        and jt.title_name = '$position'
        and (per.First_name like '%{$search}%' or per.Last_name like '%{$search}%' or jt.title_name like '%{$search}%')
        ORDER by app.person_id, jt.title_name";
    }
    else if(!empty($_POST['position']) && empty($_POST['search'])){
        $position = $_POST['position'];
        $query = "SELECT app.*,jt.title_name,per.First_name, per.Last_name
        from application app, job_opportunity jo, job_title jt, person per
        where app.job_id = jo.job_id
        and jo.title_id = jt.title_id
        and app.status = 'Applied'
        and per.Person_id = app.person_id
        and jt.title_name = '$position'
        ORDER by app.person_id, jt.title_name";
    }
    else if (empty($_POST['position']) && !empty($_POST['search'])){
        $query = "SELECT app.*,jt.title_name,per.First_name, per.Last_name
        from application app, job_opportunity jo, job_title jt, person per
        where app.job_id = jo.job_id
        and jo.title_id = jt.title_id
        and app.status = 'Applied'
        and per.Person_id = app.person_id
        and (per.First_name like '%{$search}%' or per.Last_name like '%{$search}%' or jt.title_name like '%{$search}%')
        ORDER by app.person_id, jt.title_name";
    }
    else{
        $query = "SELECT app.*,jt.title_name,per.First_name, per.Last_name
        from application app, job_opportunity jo, job_title jt, person per
        where app.job_id = jo.job_id
        and jo.title_id = jt.title_id
        and app.status = 'Applied'
        and per.Person_id = app.person_id
        ORDER by app.person_id, jt.title_name";
    }
    
    $stmt = $conn->query($query);
    $result = $stmt->fetchall();
    $num=1;

    if(count($result)>0)
    {
        foreach ($result as $r){
            $a_date = new DateTime($r['date_of_application']);
            $apply_date = $a_date->format("d-m-Y");
            echo "<tr>      <td>".$num."</td>
                            <td> ".$r['person_id']."</td>
                            <td> ".strtoupper($r['First_name'])."</td>
                            <td>".strtoupper($r['Last_name'])."</td>
                            <td>".strtoupper($r['title_name'])."</td>
                            <td>".$apply_date."</td>
                            <td>
                                <a id='viewButton' class='btn btn-primary mr-2' href='profile.php?id=".$r['person_id']."'>View</a>
                                <button id='approveButton' class='btn btn-success mr-2' data-bs-toggle='modal' data-bs-target='#approval' data-app-id=".$r['application_id'].">Approve</button>
                                <button id='rejectButton' class='btn btn-warning mr-2'  data-rej-id=".$r['application_id'].">Reject</button>
                                <button id='deleteButton' class='btn btn-danger' data-del-id=".$r['application_id'].">Delete</button>
                                    
                            </td>
                        </tr>";
                        $num++;

        }

                        
    }
    else{
        echo "<td colspan=3><h4>No record Found.</h4></td>";
    }

}


//approval request process
if(isset($_POST['app_id']) && isset($_POST['interviewer']) && isset($_POST['iw_date'])){
    $app_id = $_POST['app_id'];
    $interviewer = $_POST['interviewer'];
    $iw_date = $_POST['iw_date'];

    $query2 = "update application
        set Interviewer_id = :interviewer,
        interview_date = :iw_date,
        status = 'In Progress',
        last_update = current_timestamp()
        where application_id = :app_id";

        $stmt2 = $conn->prepare($query2);
        try{
            $stmt2->execute([':app_id'=>$app_id,
                    ':interviewer'=>$interviewer,
                    ':iw_date'=>$iw_date
                    ]);
        loadData($conn);
        }
        catch(PDOException $e){
            echo "Error".$e->getMessage();
        }
        
    

}

//Approval form

if(isset($_POST['app_id'])){
    $app_id = $_POST['app_id'];
    $query = "select per.person_id, per.first_name, per.Last_name
            from login_details ld, person per
            where ld.Role in ('A','E')
            and ld.person_id = per.person_id
            ORDER by per.person_id";

    
    
    $stmt = $conn->query($query);
    $result = $stmt->fetchall();
    $num=1;

    
    $data ="
        <form id='aprovalForm' onsubmit='return validateForm()'>
                <div class='input-text'>
                    <label>Interviewer</label>
                    <select class='select-op' id='interviewer' name='interviewer'>
                    <option value=''>Please select interviewer</option>";

    foreach($result as $r){
        $data .= "<option value='".$r['person_id']."'>".$r['person_id'].' '.$r['first_name'].' '.$r['Last_name']."</option>";
    }

                        
    $data .="</select>
                <span class='err' id='interError'></span>
                    <label>Interview Date</label>
                    <input type='date' id='interview_date' name='interview_date'>
                </div>
                <span class='err' id='dateError'></span>
                <button type='submit' id='submit' data-id='".$app_id."' class='btn1'>Submit</button>
                </form>
    ";

    echo $data;
}

//reject
if(isset($_POST['rej_id'])){
    $app_id = $_POST['rej_id'];
    

    $query2 = "update application
        set status = 'Rejected',
        last_update = current_timestamp()
        where application_id = :app_id";

        $stmt2 = $conn->prepare($query2);
        try{
            $stmt2->execute([':app_id'=>$app_id                    
                    ]);
        loadData($conn);
        }
        catch(PDOException $e){
            echo "Error".$e->getMessage();
        }
        
    

}

//Delete
if(isset($_POST['del_id'])){
    $app_id = $_POST['del_id'];
    
    $query2 = "delete from application
               where application_id = :app_id";

        $stmt2 = $conn->prepare($query2);
        try{
            $stmt2->execute([':app_id'=>$app_id                    
                    ]);
        loadData($conn);
        }
        catch(PDOException $e){
            echo "Error".$e->getMessage();
        }
        
    

}





$conn=null;
?>