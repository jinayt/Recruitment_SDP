<?php
include_once "header.php";
require_once "dbconnection.php";
$personid=$_SESSION['personid'];
$num = 1;
$query="SELECT app.*, per.first_name, per.last_name, jt.title_name
FROM application app
left JOIN person per ON per.person_id = app.Interviewer_id
JOIN job_opportunity jo ON app.job_id = jo.job_id
JOIN job_title jt ON jo.title_id = jt.title_id
WHERE app.person_id = $personid
ORDER BY app.date_of_application";
$stmt = $conn->query($query);
$result = $stmt->fetchAll();
// echo'<pre>';print_r($result); echo'</pre>';



?>

<div class="min_wid ms-5 me-5">
<br>
    <h2>Job application status:</h2><hr>
    <br>
    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Sr. No.</th>
                            <th scope="col">Application Id</th>
                            <th scope="col">Date of application</th>
                            <th scope="col">Position</th>
                            <th scope="col">Status</th>
                            <th scope="col">Interviewer Name</th>
                            <th scope="col">Interviewer Date</th>
                           
                        </tr>
                    </thead>
                    <tbody id="table_data">

                        <?php
                        if($stmt->rowCount()>0){
                            foreach ($result as $r) { 
                            $a_date = new DateTime($r['date_of_application']);
                            $apply_date = $a_date->format("d-m-Y"); 
                            
                            if(!empty($r['interview_date'])){
                                $i_date = new DateTime($r['interview_date']);
                            $int_date = $i_date->format("d-m-Y");
                            }
                            else{
                                $int_date = '';
                            }
                            


                            ?>
                            <tr>
                                <td><?php  echo htmlspecialchars($num); $num++;?></td>
                                <td><?php  echo htmlspecialchars($r['application_id']);?></td>
                                <td><?php  echo htmlspecialchars($apply_date);?></td>
                                <td><?php  echo htmlspecialchars(ucwords($r['title_name']));?></td>
                                <td><?php  echo htmlspecialchars($r['status']);?></td>
                                <td><?php  echo htmlspecialchars($r['first_name'].' '.$r['last_name']);?></td> 
                                <td><?php  echo htmlspecialchars($int_date);?></td> 
                                                               
                            </tr>

                        <?php } } else{ echo "<tr><td colspan = 3><h5>No Record found.</h5></td></tr>"; }?>

                    </tbody>
                </table>

</div>