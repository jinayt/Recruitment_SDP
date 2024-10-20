<?php
require_once "dbconnection.php";


if(isset($_POST['job_id']) && isset($_POST['s_date']) && isset($_POST['e_date']) && isset($_POST['num_post']) && isset($_POST['status'])&& isset($_POST['desc'])){
    $job_id = $_POST['job_id'];
    $s_date = $_POST['s_date'];
    $e_date = $_POST['e_date'];
    $num_post = $_POST['num_post'];
    $status = $_POST['status'];
    $desc = $_POST['desc'];
    try{
        $query = "update job_opportunity
        set date_of_opening = :s_date,
        date_of_closing = :e_date,
        num_of_vacancy = :num_post,
        job_discription = :desc,
        status = :status
        where job_id = :job_id";


    $stmt = $conn->prepare($query);
    $stmt->execute([':job_id'=>$job_id,
        ':s_date'=>$s_date,
        ':e_date'=>$e_date,
        ':num_post'=>$num_post,
        ':status'=>$status,
        ':desc'=>$desc,
        ]);
    }
    catch(PDOException $e){
        echo "Error".$e->getMessage();
    }
    

    //reloading data    
        $query1 = "SELECT jt.title_name, jo.*
        FROM job_opportunity jo, job_title jt
        where jo.title_id = jt.title_id  
        AND jo.status in('Active', 'Hold')";


        $stmt1 = $conn->query($query1);
        $result1 = $stmt1->fetchall();

        foreach ($result1 as $r) {
            $date1 = new DateTime($r['date_of_opening']);
            $open_date = $date1->format("d-m-Y");

            $date2 = new DateTime($r['date_of_closing']);
            $close_date = $date2->format("d-m-Y");
        
            echo "<tr>
                <td><?php echo $num;
                    $num++; ?></td>
                <td>".$r['job_id']."</td>
                <td>".$r['title_name']."</td>
                <td>".$open_date."</td>
                <td>".$close_date."</td>
                <td>".$r['num_of_vacancy']."</td>
                <td>".$r['status']."</td>
                <td>
                    <button id='updateButton' class='btn btn-primary mr-2' data-job-id='".$r['job_id']."' data-bs-toggle='modal' data-bs-target='#job_update'>Update</button>
                    
                </td>
            </tr>
            ";
            
        }


}



//update job opportunity
if(isset($_POST['job_id'])){

        $job_id = $_POST['job_id'];
        $query = "SELECT jt.title_name, jo.*
        FROM job_opportunity jo, job_title jt
        where jo.title_id = jt.title_id  
        AND jo.status in ('Active', 'Hold')
        AND jo.job_id = $job_id";


        $stmt = $conn->query($query);
        $result = $stmt->fetch();
        if(count($result)>0){
            // echo"<pre>";print_r($result);echo"</pre>";
            echo "<form method='post'>
            <div class='input-text'>
                <h5 mt-5 mb-5>Position: ".$result['title_name']."</h5>
                <label for='s_date'>Job Opening Date:</label><br>
                <input type='date' id='s_date' name='s_date' value='".$result['date_of_opening']."' required>
                <br>

                <label for='e_date'>Job Closing Date:</label><br>
                <input type='date' id='e_date' name='e_date' value='".$result['date_of_closing']."' required>
                <br>

                <label for='num_post'>Number of Job Vacancy</label><br>
                <input type='number' id='num_post' name='num_post' min='1' value='".$result['num_of_vacancy']."' required>
                <br>

                <label for='status'>Status:</label><br>
                <select class='select-op' id='status' name='status' required>
                    <option value='Active' ".($result['status'] == 'Active' ? 'selected' : '').">Active</option>
                    <option value='Inactive' ".($result['status'] == 'Inactive' ? 'selected' : '').">Inactive</option>
                    <option value='Hold' ".($result['status'] == 'Hold' ? 'selected' : '').">Hold</option>
                </select>
                <br>
                <label for='desc'>Description:</label><br>
                <textarea class='tarea' id='desc' name='desc' maxlength='255' required>".$result['job_discription']."</textarea>
                
                <br>
            </div>
            <button type='submit' id='submit' data-id='".$job_id."' class='btn1'>Submit</button>
        </form>";
        }
        else{
            echo "No record found";
            
        }


}

$conn=null;

?>