<?php include_once("header.php");
require_once "dbconnection.php";

$person_id = $_SESSION['personid'];

$query = "SELECT app.application_id,per.Person_id, per.First_name,per.Last_name, 
jt.title_name, app.date_of_application, app.interview_date, app.status   
FROM application app, person per, job_title jt, job_opportunity jo
where Interviewer_id = :person_id
and app.STATUS = 'In Progress'
and app.Person_id = per.Person_id
and app.job_id = jo.job_id
and jo.title_id = jt.title_id";

$stmt = $conn->prepare($query);
$stmt->execute([':person_id' => $person_id]);
$result = $stmt->fetchall();
// echo'<pre>';print_r($result); echo'</pre>';
$num = 1;
?>



<div class="min_wid">
    <div class="container-fluid mx-0 px-0">
        <?php if ($_SESSION['role'] == "A") { ?>
            <div class="row mx-0 px-0">
                <div class="col-3 px-0" style="width: 20%;"><?php include_once "sidebar.php"; ?></div>
                <div class="col-9" style="width: 80%;">
                <?php } else { ?>
                    <div class="ms-3 me-3">
                    <?php } ?>
                    <br>
                    <h2>Interview</h2>
                    <hr>
                    <table id='candidate_list' class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Sr. No.</th>
                                <th scope="col">Person Id</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Position</th>
                                <th scope="col">Date of Application</th>
                                <th scope="col">Date of Interview</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody id="table_data">
                            <tr>
                                <?php if ($stmt->rowCount() > 0) {
                                    foreach ($result as $r) {
                                        $a_date = new DateTime($r['date_of_application']);
                                        $apply_date = $a_date->format("d-m-Y");

                                        $i_date = new DateTime($r['interview_date']);
                                        $int_date = $i_date->format("d-m-Y");
                                ?>


                                        <td><?php echo $num;
                                            $num++ ?></td>
                                        <td><?php echo $r['Person_id']; ?></td>
                                        <td><?php echo strtoupper($r['First_name']); ?></td>
                                        <td><?php echo strtoupper($r['Last_name']); ?></td>
                                        <td><?php echo strtoupper($r['title_name']); ?></td>
                                        <td><?php echo $apply_date; ?></td>
                                        <td><?php echo $int_date; ?></td>
                                        
                                        <td style="width:120px;"><?php echo strtoupper($r['status']); ?></td>
                                        <td>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a id="viewButton" class="btn btn-primary mr-2" href="profile.php?id=<?php echo $r['Person_id']; ?>">View</a>
                                            <button id="updateButton" class="btn btn-success mr-2" data-bs-toggle="modal" data-bs-target="#status_update" data-app-id="<?php echo $r['application_id']; ?>">Update</button>
                                            <button id='rejectButton' class='btn btn-warning mr-2'  data-rej-id="<?php echo $r['application_id']; ?>">Reject</button>
                                        </div>
                                        </td>
                            </tr>
                                <?php }
                                } else {?>
                                    <tr><td colspan='5'><h4>No candite for interview.</h4></td></tr>
                                <?php } ?>


                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
    </div>
</div>


<div class="modal fade" id="status_update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Interview Status:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="update">
                <form id="myform" onsubmit="return validateForm()">
                    <div class="input-text">
                        <label for='status'>Status:</label>
                        <select class="select-op" id='status' name='status'>
                            <option value="In Progress" selected>In Progress</option>
                            <option value="Selected">Selected</option>
                        </select><br>
                        <label for='status' id='int_lable' style='display:block'>Interview Date:</label>
                        <input type='date' id='inter_date' style='display:block' value='1992-07-31'>

                        <label for='status' id='hire_lable' style='display:none'>Hire Date:</label>
                        <input type='date' id='hire_date' name='hire_date' style='display:none'>
                        <span class='err' id='dateError'></span>
                        <button type='submit' id='submit' name="submit" data-app-id='$app_id' class='btn1 mt-3'>Submit</button>

                </form>
            </div>
        </div>

    </div>
</div>
</div>
<script type="text/javascript">
    function validateForm() {
        var valid = true;
        var status = $('#status').val().trim();

        var h_date = $('#hire_date').val();
        var hire_date = new Date(h_date);
        hire_date.setHours(0, 0, 0, 0);

        var i_date = $('#inter_date').val();
        var inter_date = new Date(i_date);
        inter_date.setHours(0, 0, 0, 0);

        var current_date = new Date();
        current_date.setHours(0, 0, 0, 0);


        // alert(hire_date + ' ' + h_date);

        $('#dateError').html('');

        if (status === 'Selected' && (!h_date)) {
            $('#dateError').html('Please Enter Date.<br>');
            valid = false;
        } else if (status === 'Selected' && (current_date > hire_date)) {
            $('#dateError').html('Hire date cannot be in the past.<br>');
            valid = false;
        }


        if (status === 'In Progress' && (!i_date)) {
            $('#dateError').html('Please Enter Date.<br>');
            valid = false;
        } else if (status === 'In Progress' && (current_date > inter_date)) {
            $('#dateError').html('Interview date cannot be in the past.<br>');
            valid = false;
        }


        return valid;
    }

    //update form
    $(document).ready(function() {
        

        $(document).on('change', '#status', function() {
            var status = $(this).val();
            

            if (status === 'Selected') {
                $('#hire_date').css('display', 'block');
                $('#hire_lable').css('display', 'block');
                $('#inter_date').val('');
            } else {
                $('#hire_date').css('display', 'none');
                $('#hire_lable').css('display', 'none');
            }

            if (status === 'In Progress') {
                $('#inter_date').css('display', 'block');
                $('#int_lable').css('display', 'block');
                $('#hire_date').val('');
            } else {
                $('#inter_date').css('display', 'none');
                $('#int_lable').css('display', 'none');
            }

        });

        $(document).on('click', '#updateButton', function() {
            var apply_id = $(this).data('app-id');
            

            $.ajax({
                url: 'interview_man.php',
                type: 'POST',
                data: {
                    apply_id: apply_id
                    
                },
                success: function(data) {
                    $('#update').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + " - " + error);
                    alert("Error: " + xhr.responseText);
                }

            });
        });


        $(document).on('click', '#submit', function(e) {
            e.preventDefault();    
        if (!validateForm()) {
            return;
        }
        else{
            var app_id = $(this).data('app-id');
            var status = $('#status').val().trim();
            var hire_date = $('#hire_date').val();
            var inter_date = $('#inter_date').val();
           

        $.ajax({
            url: 'interview_man.php',
            type: 'POST',
            data: {
                app_id: app_id,
                status: status,
                hire_date: hire_date,
                inter_date: inter_date
            },
            success: function(data) {
                $('#table_data').html(data);
                $('#status_update').modal('hide');
                alert('Record updated sucessfully.'); 
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
                alert("Error: " + xhr.responseText);
            }

        });
        }
        });

    
     // Reject
     $(document).on('click','#rejectButton',function(){
            var rej_id = $(this).data('rej-id');
            if(confirm("Are you sure! you want to reject the application?")){
                $.ajax({
                url: 'interview_man.php',
                type: 'POST',
                data: {
                    rej_id: rej_id
                },
                success: function(data) {
                    $("#table_data").html(data);
                },
                
            });
        }
        });   



    });

    
</script>

<?php include_once("footer.php"); ?>