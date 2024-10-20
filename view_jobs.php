<?php
include_once "header.php";
require_once "dbconnection.php";
$num = 1;
$query = "SELECT jt.title_name, jo.*
FROM job_opportunity jo, job_title jt
where jo.title_id = jt.title_id  
AND jo.status in('Active', 'Hold')";


$stmt = $conn->query($query);
$result = $stmt->fetchall();
// echo"<pre>";print_r($result);echo"</pre>";
?>



<div class="min_wid">
    <div class="container-fluid mx-0 px-0">
        <div class="row mx-0 px-0">
            <div class="col-3 px-0" style="width: 20%;"><?php include_once "sidebar.php"; ?></div>
            <div class="col-9" style="width: 80%;">
                <br>
                <h2>Job Opportunities:</h2>
                <hr>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Sr.No.</th>
                            <th scope="col">Job Id</th>
                            <th scope="col">Position</th>
                            <th scope="col">Opening Date</th>
                            <th scope="col">Closing Date</th>
                            <th scope="col">Number of vacancy</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>


                        </tr>
                    </thead>
                    <tbody id="table_data">

                        <?php
                        foreach ($result as $r) {
                            $date1 = new DateTime($r['date_of_opening']);
                            $open_date = $date1->format("d-m-Y");

                            $date2 = new DateTime($r['date_of_closing']);
                            $close_date = $date2->format("d-m-Y");
                        ?>
                            <tr>
                                <td><?php echo $num;
                                    $num++; ?></td>
                                <td><?php echo $r['job_id']; ?></td>
                                <td><?php echo ucwords($r['title_name']); ?></td>
                                <td><?php echo $open_date ?></td>
                                <td><?php echo $close_date; ?></td>
                                <td><?php echo $r['num_of_vacancy']; ?></td>
                                <td><?php echo ucwords($r['status']); ?></td>
                                <td>
                                    <button id="updateButton" class="btn btn-primary mr-2" data-job-id="<?php echo $r['job_id']; ?>"  data-bs-toggle="modal" data-bs-target="#job_update">Update</button>
                                    
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="job_update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update job opportunity details:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="update">
            <form method="post" >
                <div class="input-text">
                    <label for="s_date">Job Opening Date:</label><br>
                                <input type="date" id="s_date" name="s_date">
                                <span class="err" id="s_dateError"></span>
                                <br>
                                <label for="e_date">Job Closing Date:</label><br>
                                <input type="date" id="e_date" name="e_date" value = "">
                                <span class="err" id="e_dateError"></span>
                                <br>
                                <label for="num_post">Number of Job Vacancy:</label><br>
                                <input type="number" id="num_post" name="num_post" min="1" value = "">
                                <span class="err" id="num_postError"></span>
                                <br>
                                <label for="status">Status:</label><br>
                                <select id = "status" name="status">
                                    <option  value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Hold">Hold</option>
                                </select><br><br>
                                
                                <span class="err" id="num_postError"></span>
                                <label for="desc">Description:</label><br>
                                <textarea class="tarea" id="desc" name="desc"  value = "" maxlength="255"></textarea>
                                <span class="err" id="descError"></span>
                                <br>

                            </div>
                            <button id="submit" class="btn1">Submit</button>
                </form>
                
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
      
        $(document).on('click','#updateButton',function(){
           var job_id = $(this).data('job-id');
           $.ajax({
            url:'view_jobs_man.php',
            type: 'POST',
                data: {
                    job_id: job_id

                },
                success: function(data) {
                    $("#update").html(data);
                },
                error: function(xhr, status, error) {
                    alert('AJAX Error: ' + error);
                }   
           });

        });

        
        $(document).on('click','#submit',function(e){
           
           var job_id = $(this).data('id');
           var s_date = $('input[name="s_date"]').val().trim();
           var e_date = $('input[name="e_date"]').val().trim();
           var num_post = $('input[name="num_post"]').val().trim();
           var status = $('select[name="status"]').val().trim();
           var desc = $('textarea[name="desc"]').val().trim();
           
           $.ajax({
            url:'view_jobs_man.php',
            type: 'POST',
                data: {
                    job_id: job_id,
                    s_date: s_date,
                    e_date: e_date,
                    num_post: num_post,
                    status: status,
                    desc: desc

                },
                success: function(data) {
                    $("#table_data").html(data);
                    alert('Record is updated successfull.');
                },
                error: function(xhr, status, error) {
                alert('AJAX Error: ' + error);
            }   
           });

        });

    });
</script>

<?php include_once "footer.php" ?>