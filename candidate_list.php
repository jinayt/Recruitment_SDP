<?php
include_once "header.php";
require_once "dbconnection.php";

$query = "SELECT p.*,l.Role
        FROM Person p, login_details l
        where p.Person_id = l.Person_id
        and l.Role = 'U'
        order by p.Person_id";


$stmt = $conn->query($query);
$result = $stmt->fetchall();
// echo "<pre>".$query; print_r($result); exit();
$num=1;
?>



<div class="min_wid">
    <div class="container-fluid mx-0 px-0">
        <div class="row mx-0 px-0">
            <div class="col-3 px-0" style="width: 20%;"><?php include_once "sidebar.php"; ?></div>
            <div class="col-9" style="width: 80%;">
                <br>
                <h2>List of candidate</h2>
                <hr>
                <lable>Search</lable>
                <input type="text" class='search' id="live_search" autocomplete="off">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Sr. No.</th>
                            <th scope="col">Person Id</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Action</th>


                        </tr>
                    </thead>
                    <tbody id="table_data">

                        <?php
                        foreach ($result as $r) { ?>
                            <tr>
                                <td><?php  echo $num; $num++ ?></td>
                                <td><?php echo $r['Person_id']; ?></td>
                                <td><?php echo strtoupper($r['First_name']); ?></td>
                                <td><?php echo strtoupper($r['Last_name']); ?></td>

                                <td>
                                    <a id="editButton" class="btn btn-primary mr-2" href="profile.php?id=<?php echo $r['Person_id']; ?>">View</a>
                                    <a id="editButton" class="btn btn-success mr-2" href="?id=<?php echo $r['Person_id']; ?>">Approve</a>
                                    <a id="editButton" class="btn btn-warning mr-2" href="?id=<?php echo $r['Person_id']; ?>">Reject</a>
                                    <a class="btn btn-danger" name="Recor_delete" href="delete_record.php?personid=<?php echo $r['Person_id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    //search

    $("#live_search").on("keyup", function(e)

        {
            var search_term = $(this).val().trim();
            $.ajax({
                url: 'Data_for_ajax.php',
                type: 'POST',
                data: {
                    search: search_term
                },
                success: function(data) {
                    $("#table_data").html(data);
                },
                
            });
        });
</script>

<?php include_once "footer.php" ?>