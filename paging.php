<?php
require_once 'dbconnection.php';
$query = "SELECT app.*,jt.title_name,per.First_name, per.Last_name
from application app, job_opportunity jo, job_title jt, person per
where app.job_id = jo.job_id
and jo.title_id = jt.title_id
and app.status = 'Applied'
and per.Person_id = app.person_id
ORDER by app.person_id, jt.title_name
limit 0,5";


$stmt = $conn->query($query);
$result = $stmt->fetchall(); 


$total_records = $stmt->rowCount();
$limit = 5;
$total_page = ceil($total_records / $limit);

echo "<ul class='pagination'>";
for($i=1;$i<=$total_page;$i++){
    echo "<li class='page-item'><a class='page-link' href='application_list.php?page=".$i."'>".$i."</a></li>";
}
echo "</ul>";
?>