<?php
include_once "header.php";
require_once "dbconnection.php";

$query = "SELECT *
        FROM job_title";
        
$stmt = $conn->query($query);
$result = $stmt->fetchall();
// echo "<pre>".$query; print_r($result); exit();

if($_SERVER['REQUEST_METHOD']=="POST"){

    $s_date = $_POST['s_date'];
    $e_date = $_POST['e_date'];
    $num_post = $_POST['num_post'];
    $desc = $_POST['desc'];
      
    
    if(isset($_POST['title']) && $_POST['title'] == "Other"){
        $new_title =  $_POST['new_title'];
      
        $query2 = "insert into job_title (title_name)
        VALUES (:new_title)";
        
        $stmt2 = $conn->prepare( $query2);
        $result2 = $stmt2->execute([':new_title'=>$new_title]);

        $title_id = $conn->lastInsertId();
        
    }
    else{
        $title_id =  $_POST['title'];
    }

    $query3="insert into job_opportunity (title_id, date_of_opening, date_of_closing, num_of_vacancy, job_discription)
    VALUES (:title_id,:s_date,:e_date,:num_post,:desc)";
    $stmt3 = $conn->prepare( $query3);
    $result3 = $stmt3->execute([':title_id'=>$title_id,
                                ':s_date'=>$s_date,
                                ':e_date'=>$e_date,
                                ':num_post'=>$num_post,
                                ':desc'=>$desc    
                                ]);
    
     if($result3 == 1){
         echo "<script>alert('Record added sucessfully.');</script>";
     }


}

?>



<div class="min_wid">
    <div class="container-fluid mx-0 px-0">
        <div class="row mx-0 px-0">
            <div class="col-3 px-0" style="width: 20%;"><?php include_once "sidebar.php"; ?></div>
            
            <div class="col-9" style="width: 80%;">
                
                        <br>
                        <h2> Create Job Opportunity:</h2><hr>
                        <form id="createjob" method="post">
                            <div class="cont1">
                                
                                <label for="title">Job Title:</label><br>
                                <select  class="select-op1" id="title" name="title" onchange="addTittle()">
                                    <option value="">Please select title</option>
                                    <?php foreach($result as $r){ echo "<option value='".$r['title_id']."'>".ucwords($r['title_name'])."</option>";}?>
                                    <option value="Other">Other</option>
                                </select>
                                <span id='hideninput'></span>
                                <span class="err" id="titleError"></span>
                                <br>
                                <label for="s_date">Job Opening Date</label><br>
                                <input type="date" id="s_date" name="s_date">
                                <span class="err" id="s_dateError"></span>
                                <br>
                                <label for="e_date">Job Closing Date</label><br>
                                <input type="date" id="e_date" name="e_date">
                                <span class="err" id="e_dateError"></span>
                                <br>
                                <label for="num_post">Number of Job Vacancy</label><br>
                                <input type="number" id="num_post" name="num_post" min="1" placeholder="Enter Number of job Vacancy">
                                <span class="err" id="num_postError"></span>
                                <br>
                                <label for="desc">Description:</label><br>
                                <textarea class="tarea" id="desc" name="desc"  maxlength="255"></textarea>
                                <span class="err" id="descError"></span>
                                <br>
                            </div>
                            <button type="submit" class="btn1">Submit</button>
                            
                        </form>
                
            </div>
        </div>
    
    </div>
</div>



<script src="<?php echo getSiteURL(); ?>/javascript/admindashboard.js?<?php echo time(); ?>"></script>
<?php include_once "footer.php";
$conn=null;
?>