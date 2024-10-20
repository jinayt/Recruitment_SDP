<?php

include_once "header.php";
require_once "dbconnection.php";

$limit = 10;
if(isset($_GET['page'])){
    $page = $_GET['page'];
}
else{
    $page = 1;
}

$offset  = ($page-1) * $limit;
//query for list
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
ORDER BY 
    app.date_of_application DESC
    limit {$offset},{$limit}";


$stmt = $conn->query($query);
$result = $stmt->fetchall();
// echo $stmt->rowCount();
// echo "<pre>".$query; print_r($result); exit();
$num = 1;

$query3 = "SELECT 
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
ORDER BY 
    app.date_of_application DESC";


$stmt3 = $conn->query($query3);
$total_records = $stmt3->rowCount();
$total_page = ceil($total_records / $limit);

//query for filter
$query2 = "SELECT jt.title_name, jo.*
FROM job_opportunity jo, job_title jt
where jo.title_id = jt.title_id";


$stmt2 = $conn->query($query2);
$result2 = $stmt2->fetchall();

//person id selection
$query3 = "SELECT 
    DISTINCT app.person_id, 
    per.First_name, 
    per.Last_name 
 FROM 
    application app
JOIN 
    person per ON per.Person_id = app.person_id";


$stmt3 = $conn->query($query3);
$result3 = $stmt3->fetchall();
?>



<div class="min_wid">
    <div class="container-fluid mx-0 px-0">
        <?php if ($_SESSION['role'] == "A") { ?>
            <div class="row mx-0 px-0">
                <div class="col-3 px-0" style="width: 20%;"><?php include_once "sidebar.php"; ?></div>
                <div class="col-9" style="width: 80%;">
                <?php } else { ?>
                    <div class="ms-2 me-3">
                    <?php } ?>
                    <br>
                    <h2>List of Application</h2>
                    <hr>

                    <lable class="ms-2" for='live_search'>Search: </lable>
                    <input type="text" class='search' id="live_search" name="live_search" autocomplete="off" onkeyup="candidateRecord()">

                    <label class="ms-2">Position:</label>
                    <select class='select-op' style="width: 200px;" id="position" name='position' onchange="candidateRecord()">
                        <option value=''>Please select Position</option>
                        <?php foreach ($result2 as $r2) {
                            echo "<option value='" . htmlspecialchars($r2['title_name']) . "'>" .htmlspecialchars($r2['title_name']) . "</option>";
                        } ?>

                    </select>
                    

                    <lable class="ms-2" for='from_date'>From: </lable>
                    <input type="date" class='search' id="from_date" name="from_date" onchange="candidateRecord()">

                    <lable class="ms-2" for='to_date'>To: </lable>
                    <input type="date" class='search' id="to_date" name='to_date' onchange="candidateRecord()">

                    <button id="pdf" class="btn btn-primary float-end" data-pdf-id="1">PDF</button>
                    
                    <br>
                    <lable class="ms-2" for='status'>Status: </lable>
                    <select class='select-op' style="width: 180px;" id="status" name='status' onchange="candidateRecord()">
                        <option value=''>Please select Position</option>
                        <option value='Applied'>Applied</option>
                        <option value='Rejected'>Rejected</option>
                        <option value='In Progress'>In Progress</option>
                        <option value='Selected'>Selected</option>
                        
                    </select>
                    <lable class="ms-2" for='candidate_id'>Candidate: </lable>
                    <select class='select-op' style="width: 200px;" id="candidate_id" name='candidate_id' onchange="candidateRecord()">
                        <option value=''>Please select Candidate</option>
                        <?php foreach ($result3 as $r3) {
                            echo "<option value='" . $r3['person_id'] . "'>" . $r3['person_id'].' '.strtoupper($r3['First_name']).' '. strtoupper($r3['Last_name']). "</option>";
                        } ?>

                    </select>

                    <table id='candidate_list' class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Sr. No.</th>
                                <th scope="col">Person Id</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Position</th>
                                <th scope="col">Date of application</th>
                                <th scope="col">Status</th>


                            </tr>
                        </thead>
                        <tbody id="table_data">

                            <?php if ($stmt->rowCount() > 0) {
                                foreach ($result as $r) {
                                    $a_date = new DateTime($r['date_of_application']);
                                    $apply_date = $a_date->format("d-m-Y");
                            ?>
                                    <tr>
                                        <td><?php echo $num;
                                            $num++ ?></td>
                                        <td><?php echo $r['person_id']; ?></td>
                                        <td><?php echo strtoupper($r['First_name']); ?></td>
                                        <td><?php echo strtoupper($r['Last_name']); ?></td>
                                        <td><?php echo strtoupper($r['title_name']); ?></td>
                                        <td><?php echo $apply_date; ?></td>
                                        <td><?php echo strtoupper($r['status']); ?></td>

                                    </tr>

                            <?php }
                            } else {
                                echo "<td colspan=3><h4>No record Found.</h4></td>";
                            } ?>

                        </tbody>
                    </table>
                    <div id="page_no">
                    <?php
                    if($total_records >5){
                        echo "<ul class='pagination'>";
                    for($i=1;$i<=$total_page;$i++){
                        if($i == $page){
                            $active="active";
                        }
                        else{
                            $active="";
                        }
                        echo "<li class='page-item ".$active."'><a class='page-link' href='report.php?page=".$i."'>".$i."</a></li>";
                    }
                    echo "</ul>";
                    }
                    
                    ?>
                    </div>
                    </div>
                </div>
            </div>
    </div>






    <script type="text/javascript">
        //search

        function candidateRecord() {
            var search_term = $('input[name="live_search"]').val();
            search_term = search_term ? search_term.trim() : '';

            var position = $('select[name="position"]').val();
            position = position ? position.trim() : '';

            var status = $('select[name="status"]').val();
                status = status ? status.trim() : '';

            var from_date = $('input[name="from_date"]').val();
            var to_date = $('input[name="to_date"]').val();
            
            
                if (from_date && to_date) {
                var fromDate = new Date(from_date);
                var toDate = new Date(to_date);

                if (fromDate > toDate) {
                    alert('From date cannot be greater than To date.');
                    var to_date = $('input[name="to_date"]').val('');
                    return;
                }
            
            }
            
            
            var candidate_id = $('select[name="candidate_id"]').val().trim();
             if(!search_term && !position && !status && !from_date && !to_date && !candidate_id){
                window.location.href = 'report.php';
                return;
            }
            $.ajax({
                url: 'report_man.php',
                type: 'POST',
                data: {
                    search: search_term,
                    position: position,
                    from_date: from_date,
                    to_date: to_date,
                    status: status,
                    candidate_id: candidate_id
                },
                success: function(data) {
                    $("#table_data").html(data);
                    $('#page_no').css('display','none');
                    
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + " - " + error);
                    alert("Error: " + xhr.responseText);
                }
            });

        }




        $(document).ready(function() {

            $(document).on('click', '#pdf', function() {
                var search_term = $('input[name="live_search"]').val();
                search_term = search_term ? search_term.trim() : '';

                var position = $('select[name="position"]').val();
                position = position ? position.trim() : '';

                var status = $('select[name="status"]').val();
                status = status ? status.trim() : '';


                var from_date = $('input[name="from_date"]').val();
                var to_date = $('input[name="to_date"]').val();

                var candidate_id = $('select[name="candidate_id"]').val().trim();
                

                if (from_date && to_date) {
                    var fromDate = new Date(from_date);
                    var toDate = new Date(to_date);

                    if (fromDate > toDate) {
                        alert('From date cannot be greater than To date.');
                        var to_date = $('input[name="to_date"]').val('');
                        return;
                    }
                }

                // var pdf_id = $(this).data('pdf-id');
                $.ajax({
                    url: 'report_pdf.php',
                    type: 'POST',
                    data: {
                        // pdf_id: pdf_id,
                        search: search_term,
                        position: position,
                        from_date: from_date,
                        to_date: to_date,
                        status: status,
                        candidate_id: candidate_id
                    },
                    success: function(response) {

                        if (response.status === 'success') {
                            window.open('download/' + response.filepath, '_blank');
                        } else {
                            alert("Error" + response.message);
                            alert(response.status);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " - " + error);
                        alert("Error: " + xhr.responseText);
                    }
                });
            });

        });
    </script>

    <?php include_once "footer.php" ?>