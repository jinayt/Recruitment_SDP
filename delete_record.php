<?php
require_once "dbconnection.php";
try{
    
    $person_id = intval($_GET['personid']);
    
    //delete file
    $queryf = "select * from document where person_id = $person_id";
    $stmt2 = $conn->query($queryf);
    $resultf = $stmt2->fetchall();
       
    
    
    //delete record from database
   
    $query="delete from person where person_id = :person_id";
    
    $stmt=$conn->prepare($query);
    $result=$stmt->execute([":person_id"=> $person_id]);
    
    if($result == 1)
    {
        echo "<script> aler(Record deleted sucessfully.)</script>";
        foreach ($resultf as $r)
        {
            $fileToDelete=$r['doc_path'];
            
            if (file_exists($fileToDelete))
            {
                unlink($fileToDelete);
               
            }
    
        }
        echo '<script type="text/javascript">
                window.location.href = "candidate_list.php";
        </script>';
        exit;     
    
    }


}
catch(PDOException $e)
{
    $conn->rollBack();
    die("Record not deleted." . $e->getMessage()); 
}


?>