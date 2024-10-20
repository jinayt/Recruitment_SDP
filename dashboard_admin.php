<?php
include_once "header.php";
require_once "dbconnection.php";

//employee count
$query1 = "select count(emp_id) as num_of_emp 
from employee_master";

$stmt = $conn->prepare($query1);
$stmt->execute();
$result = $stmt->fetch();
$num_of_emp = $result['num_of_emp'];

//application for job
$query2 = "select count(a.person_id) as num_application 
from person p, application a 
where p.person_id = a.person_id
and a.status = 'Applied'";

$stmt2 = $conn->prepare($query2);
$stmt2->execute();
$result2 = $stmt2->fetch();
$num_of_app = $result2['num_application'];

//active jobs
$query3 = "select count(job_id) as num_jobs 
from job_opportunity 
where status = 'Active'";

$stmt3 = $conn->prepare($query3);
$stmt3->execute();
$result3 = $stmt3->fetch();
$num_of_jobs = $result3['num_jobs'];


?>

<div class="min_wid">
    <div class="row mx-0 px-0">
        <div class="col-3 px-0" style="width: 20%;"><?php include_once "sidebar.php"; ?>
        </div>
        <div class="col-9 wid-admin min_wid ps-0 pe-0" style="width: 80%;">
            <div class="user-menu">

                <a class="link-icon" href="#">
                    <div class="menu1">
                        <h1><?php echo $num_of_emp; ?></h1>
                        <p>No. Employee</p>
                    </div>
                </a>


                <a class="link-icon" href="application_list.php">
                    <div class="menu1">
                        <h1><?php echo $num_of_app; ?></h1>
                        <p>Application to approve</p>

                    </div>
                </a>


                <a class="link-icon" href="view_jobs.php">
                    <div class="menu1">
                        <h1><?php echo $num_of_jobs; ?></h1>
                        <p>Active Job Opportunity</p>

                    </div>
                </a>


            </div>
           
        </div>

    </div>
</div>
<?php include_once "footer.php" ?>  