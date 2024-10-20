<?php
require_once("dbconnection.php");
session_start();
//Update form
if (isset($_POST['apply_id'])) {
    $app_id = $_POST['apply_id'];
    $query = "SELECT date_of_application
                FROM application
                where application_id = :app_id";

    $stmt = $conn->prepare($query);
    $stmt->execute([':app_id' => $app_id]);
    $result = $stmt->fetch();
    $app_date = $result['date_of_application'];
    $html = <<<EOD
                <form id="myform" onsubmit="return validateForm()">
                    <div class="input-text">
                        <label for='status'>Status:</label>
                        <select class="select-op" id='status' name='status'>
                            <option value="In Progress" selected>In Progress</option>
                            <option value="Selected">Selected</option>
                        </select><br>
                        <label for='status' id='int_lable' style='display:block'>Interview Date:</label>
                            <input type='date' id='inter_date' style='display:block'>
                        
                        <label for='status' id='hire_lable' style='display:none'>Hire Date:</label>
                        <input type='date' id='hire_date' style='display:none'>
                        <span class='err' id='dateError'></span>
                        <button type='submit' id='submit' name="submit" data-app-id='$app_id' class='btn1 mt-3'>Submit</button>
                        
                </form>
            EOD;

    echo $html;
}

//load data
function loadData($conn){
    try {
        $emp_id = $_SESSION['personid'];

        $query2 = "SELECT app.application_id,per.Person_id, per.First_name,per.Last_name, 
                jt.title_name, app.date_of_application, app.interview_date, app.status   
                FROM application app, person per, job_title jt, job_opportunity jo
                where Interviewer_id = :person_id
                and app.STATUS = 'In Progress'
                and app.Person_id = per.Person_id
                and app.job_id = jo.job_id
                and jo.title_id = jt.title_id";

        $stmt2 = $conn->prepare($query2);
        $stmt2->execute([':person_id' => $emp_id]);
        $result2 = $stmt2->fetchall();
        // echo'<pre>';print_r($result); echo'</pre>';
        $num = 1;
        $html2 = null;
        
        if ($stmt2->rowCount() > 0) {

            foreach ($result2 as $r) {
                $a_date = new DateTime($r['date_of_application']);
                $apply_date = $a_date->format("d-m-Y");

                $i_date = new DateTime($r['interview_date']);
                $int_date = $i_date->format("d-m-Y");

                $person_id = $r['Person_id'];
                $First_name = strtoupper($r['First_name']);
                $Last_name = strtoupper($r['Last_name']);
                $title_name = strtoupper($r['title_name']);
                $status = strtoupper($r['status']);
                $application_id = $r['application_id'];




                $html2 .= <<<EOD
                    <tr><td>$num</td>
                    <td>$person_id</td>
                    <td>$First_name</td>
                    <td>$Last_name</td>
                    <td>$title_name</td>
                    <td>$apply_date</td>
                    <td>$int_date</td>
                    <td style="width:120px;">$status</td>
                    <td>
                    <div style="display: flex; gap: 0.5rem;">
                    <a id="viewButton" class="btn btn-primary mr-2" href="profile.php?id=$person_id">View</a>
                    <button id="updateButton" class="btn btn-success mr-2" data-bs-toggle="modal" data-bs-target="#status_update" data-app-id="$application_id">Update</button>
                    <button id='rejectButton' class='btn btn-warning mr-2'  data-rej-id="$application_id">Reject</button>
                    </div>
                    </td>
                    </tr>

                    EOD;
                $num++;
            }
        } else {
            $html2 = "<tr><td colspan='5'><h4>No candite for interview.</h4></td></tr>";
        }
        
        echo $html2;
    } catch (PDOException $e) {
        die("Error" . $e->getMessage());
    }
}



//update in database

if (isset($_POST['status']) && isset($_POST['app_id'])) {
    try {
        $status = $_POST['status'];
        $app_id = $_POST['app_id'];
        if ($status == 'In Progress' && isset($_POST['inter_date'])) {
            $date = $_POST['inter_date'];
            $query = "Update application
                set status = :status,
                interview_date = :date,
                last_update = current_timestamp()
                where application_id = :app_id";
        }

        if ($status == 'Selected' && isset($_POST['hire_date'])) {
            $date = $_POST['hire_date'];
            $query = "Update application
                set status = :status,
                hire_date = :date,
                last_update = current_timestamp()
                where application_id = :app_id";
        }



        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':app_id' => $app_id,
            ':status' => $status,
            ':date' => $date
        ]);
    } catch (PDOException $e) {
        die("Error" . $e->getMessage());
    }

//reloading table data
    loadData($conn);
    
}


//rejection
if(isset($_POST['rej_id'])){
    $app_id = $_POST['rej_id'];
    $query = "Update application
    set status = 'Rejected',
    last_update = current_timestamp()
    where application_id = :app_id";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([
    ':app_id' => $app_id
   ]);

//reloading table data
    loadData($conn);

}

?>