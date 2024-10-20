<?php
include_once "header.php";
require_once "dbconnection.php";

$person_id=$_SESSION['personid'];
$query = "SELECT *
        FROM  job_opportunity jo, job_title jt
        where jo.status = 'Active'
        AND jo.title_id = jt.title_id
        and jo.job_id not in (SELECT a.job_id
        FROM  application a
        where a.person_id = $person_id)";

  

$stmt = $conn->query($query);
$result = $stmt->fetchall();
//echo'<pre>';print_r($result); echo'</pre>';

?>
<div class="min_wid ms-5 me-5">
    <br>
    <h2>Job Opportunities:</h2><hr>
    <br>
    <div id="cards" class="cards">
            <?php
            if(count($result)>0){

            
            foreach ($result as $r){
                $a_date = new DateTime($r['date_of_closing']);
                $last_apply_date = $a_date->format("d-m-Y"); 
                ?>
                
                <div class="card d-flex shadow me-3 mt-3" style="width: 18rem; height:350px;">
                    <div class="card-body">
                        <h6 class="card-title">Profile:</h6>
                        <p class="card-text"><?php echo htmlspecialchars($r['title_name']); ?></p>
                        <p class="card-text"><?php echo htmlspecialchars($r['job_discription']); ?></p>
                        <h6 class="card-title">Number of vacancy:</h6>
                        <p class="card-text"><?php echo htmlspecialchars($r['num_of_vacancy']); ?></p>
                        <h6 class="card-title">Last date to apply:</h6>
                        <p class="card-text"><?php echo htmlspecialchars($last_apply_date); ?></p>
                        <div style="text-align:center;">
                        <form>
                        <input type="hidden" id="personid" name="personid"  value="<?php echo htmlspecialchars($_SESSION['personid']);?>" >  
                        <button type="button" data-job-id="<?php echo htmlspecialchars($r['job_id']); ?>" class="btn btn-primary apply-button">Apply</button>
                        </form>
                                                           
                        </div>
                    </div>
                </div>

            <?php } }else { echo "<h4>No jobs to apply.</h4>";}?>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
    $(document).on('click','.apply-button',function(){
          
        if(confirm('Are you sure you want to apply for this job?'))
        {   var job_id = $(this).data('job-id');
            var personid = $(this).siblings('input[name="personid"]').val();
            $.ajax({
                url: 'job_apply_man.php',
                type: 'POST',
                data: {
                    personid: personid,
                    job_id: job_id
                    

                },
                success: function(data) {
                    $("#cards").html(data);
                    alert('Applied successfully.');
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error('Error occurred: ', error);
                }
            });
        
        }

        
    
    });
    });


</script>


<?php include_once "footer.php" ?>