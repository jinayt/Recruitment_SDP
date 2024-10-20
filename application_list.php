<?php
include_once "header.php";
require_once "dbconnection.php";

//query for list
$query = "SELECT app.*,jt.title_name,per.First_name, per.Last_name
from application app, job_opportunity jo, job_title jt, person per
where app.job_id = jo.job_id
and jo.title_id = jt.title_id
and app.status = 'Applied'
and per.Person_id = app.person_id
ORDER by app.person_id, jt.title_name";


$stmt = $conn->query($query);
$result = $stmt->fetchall();
// echo "<pre>".$query; print_r($result); exit();
$num = 1;


//query for filter
$query2 = "SELECT jt.title_name, jo.*
FROM job_opportunity jo, job_title jt
where jo.title_id = jt.title_id  
AND jo.status in('Active')";


$stmt2 = $conn->query($query2);
$result2 = $stmt2->fetchall();
?>



<div class="min_wid">
    <div class="container-fluid mx-0 px-0">
        <div class="row mx-0 px-0">
            <div class="col-3 px-0" style="width: 20%;"><?php include_once "sidebar.php"; ?></div>
            <div class="col-9" style="width: 80%;">
                <br>
                <h2>List of Application</h2>
                <hr>
                <lable>Search</lable>
                <input type="text" class='search' id="live_search" autocomplete="off">
                <label class="ms-5">Position:</label>
                <select class='select-op' style="width: 200px;" id="position" name='position'>
                    <option value=''>Please select Position</option>
                    <?php foreach ($result2 as $r2) {
                        echo "<option value='" . $r2['title_name'] . "'>" . $r2['title_name'] . "</option>";
                    } ?>


                </select>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Sr. No.</th>
                            <th scope="col">Person Id</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Position</th>
                            <th scope="col">Date of application</th>
                            <th scope="col">Action</th>


                        </tr>
                    </thead>
                    <tbody id="table_data">

                        <?php if (count($result) > 0) {
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

                                    <td>
                                        <a id="viewButton" class="btn btn-primary mr-2" href="profile.php?id=<?php echo $r['person_id']; ?>">View</a>
                                        <button id="approveButton" class="btn btn-success mr-2" data-bs-toggle="modal" data-bs-target="#approval" data-app-id="<?php echo $r['application_id']; ?>">Approve</button>
                                        <button id="rejectButton" class="btn btn-warning mr-2" data-rej-id="<?php echo $r['application_id']; ?>">Reject</button>
                                        <button id='deleteButton' class="btn btn-danger" data-del-id="<?php echo $r['application_id']; ?>">Delete</button>
                                    </td>
                                </tr>

                        <?php }
                        } else {
                            echo "<td colspan=3><h4>No record Found.</h4></td>";
                        } ?>

                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="approval" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Approval:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="approveApp">
                <form id="aprovalForm" onsubmit="return validateForm()">
                    <div class='input-text'>
                        <label for="interviewer">Interviewer</label>
                        <select class='select-op' id="interviewer" name='interviewer'>
                            <option value=''>Please select interviewer</option>
                        </select>
                        <span class='err' id='interError'></span>
                        <label for="interview_date">Interview Date</label>
                        <input type="date" id="interview_date" name="interview_date">
                        <span class='err' id='dateError'></span>
                    </div>
                    <button type='submit' id='submit' data-id='' class='btn1'>Submit</button>
                </form>

            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    function validateForm() {
        var valid = true;
        var interviewer = $('#interviewer').val();
        interviewer = interviewer ? interviewer.trim() : '';
        // alert(interviewer);
        
        var i_date = $('#interview_date').val();
        var inter_date = new Date(i_date);
        inter_date.setHours(0, 0, 0, 0);

        var current_date = new Date();
        current_date.setHours(0, 0, 0, 0);


        $('#dateError').html('');
        $('#interError').html('');

        if (!interviewer) {
            $('#interError').html('<br>Please select interviewer.<br>');
            valid = false;
        } 
        

       if(current_date > inter_date) {
            $('#dateError').html('Interview date cannot be in the past.<br>');
            valid = false;
        }
        else if(!i_date){
            $('#dateError').html('Please enter interview date.<br>');
            valid = false;  
        }

        return valid;
    }


    //search
    $(document).ready(function() {


        $(document).on("keyup", "#live_search", function(e)

            {
                var search_term = $(this).val().trim();
                var position = $('select[name="position"]').val().trim();
                $.ajax({
                    url: 'application_list_man.php',
                    type: 'POST',
                    data: {
                        search: search_term,
                        position: position
                    },
                    success: function(data) {
                        $("#table_data").html(data);
                    },
                    error: function(xhr, status, error) {
                        alert('AJAX Error: ' + error);
                    }

                });
            });


        //filter

        $(document).on("change", "#position", function(e) {
            var position = $('select[name="position"]').val().trim();
            $.ajax({
                url: 'application_list_man.php',
                type: 'POST',
                data: {
                    position: position
                },
                success: function(data) {
                    $("#table_data").html(data);
                },
                error: function(xhr, status, error) {
                        alert('AJAX Error: ' + error);
                    }

            });
        });

        //aproval
        $(document).on('click', '#approveButton', function() {
            var app_id = $(this).data('app-id');

            $.ajax({
                url: 'application_list_man.php',
                type: 'POST',
                data: {
                    app_id: app_id
                },
                success: function(data) {
                    $("#approveApp").html(data);
                },
                error: function(xhr, status, error) {
                        alert('AJAX Error: ' + error);
                    }

            });


        });


        $(document).on('click', '#submit', function(e) {
            e.preventDefault();
            if (!validateForm()) {
                return;
            } 
            else {
                var app_id = $(this).data('id');
                var interviewer = $('select[name="interviewer"]').val().trim();
                var iw_date = $('input[name="interview_date"]').val().trim();
                // alert (app_id +","+interviewer+","+iw_date);

                $.ajax({
                    url: 'application_list_man.php',
                    type: 'POST',
                    data: {
                        app_id: app_id,
                        interviewer: interviewer,
                        iw_date: iw_date
                    },
                    success: function(data) {
                        $("#table_data").html(data);
                        alert("Application Approved.");
                        $('#approval').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        alert('AJAX Error: ' + error);
                    }
                });


            }
        });

        // Reject
        $(document).on('click', '#rejectButton', function() {
            var rej_id = $(this).data('rej-id');

            if (confirm("Are you sure! you want to reject the application?")) {
                $.ajax({
                    url: 'application_list_man.php',
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






        // Delete
        $(document).on('click', '#deleteButton', function() {
            var del_id = $(this).data('del-id');
            if (confirm("Are you sure! you sure you want to delete the application?")) {
                $.ajax({
                    url: 'application_list_man.php',
                    type: 'POST',
                    data: {
                        del_id: del_id
                    },
                    success: function(data) {
                        $("#table_data").html(data);
                    },

                });
            }
        });



    });
</script>

<?php include_once "footer.php" ?>