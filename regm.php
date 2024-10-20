<?php
    require_once 'dbconnection.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    # Registration data storing
    try {

        //person table

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $dob = $_POST['dob'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        

        $query1 = "INSERT INTO Person(first_name,last_name,gender,date_of_birth,mobile_no,email)
            VALUES(:fname, :lname, :gender, :dob, :mobile, :email )";
        $stmt = $conn->prepare($query1);
        $stmt->execute([
            ':fname' => $fname,
            ':lname' => $lname,
            ':dob' => $dob,
            ':mobile' => $mobile,
            ':email' => $email,
            ':gender' => $gender
            
        ]);

        $person_id = $conn->lastInsertId();

        // login details
        $login_id = $_POST['username'];
        $login_pass = $_POST['paswrd'];
        $hashedPassword = password_hash($login_pass, PASSWORD_DEFAULT);

        $queryl = "INSERT INTO login_details(login_id,log_pass, person_id)
            VALUES( :username, :login_pass, :personid)";
        $stmtl = $conn->prepare($queryl);
        $stmtl->execute([
            ':username' => $login_id,
            ':login_pass' => $hashedPassword,
            ':personid' => $person_id
        ]);


        //family details
        $f_fname = $_POST['ffname'];
        $f_lname = $_POST['fflname'];
        $f_rel = $_POST['frel'];
        $f_age = $_POST['fage'];

        $query2 = "INSERT INTO family_info(first_name,last_name,relationship,Date_of_birth,person_id)
            VALUES(:ffname, :flname,:frel,:fage,:personid)";
        $stmtf = $conn->prepare($query2);
        $stmtf->execute([
            ':ffname' => $f_fname,
            ':flname' => $f_lname,
            ':frel' => $f_rel,
            ':fage' => $f_age,
            ':personid' => $person_id

        ]);

        //address details
        $line1 = $_POST['aline1'];
        $line2 = $_POST['aline2'];
        $line3 = $_POST['aline3'];
        $city = $_POST['city'];
        $pincode = $_POST['pincode'];
        $state = $_POST['state'];

        $query2 = "INSERT INTO address(line1,line2,line3,city,pincode,stat,person_id)
        VALUES(:line1,:line2,:line3,:city,:pincode,:stat,:personid)";
        $stmta = $conn->prepare($query2);
        $stmta->execute([
            ':line1' => $line1,
            ':line2' => $line2,
            ':line3' => $line3,
            ':city' => $city,
            ':pincode' => $pincode,
            ':stat' => $state,
            ':personid' => $person_id

        ]);


        //file upload
        if (isset($_FILES['profilePic'])) {
            $upload_path = "profile/";
            $profilePic = $_FILES['profilePic']['name'];
            $fileType = strtolower(pathinfo($profilePic, PATHINFO_EXTENSION));
            $customName = 'profile_'.$person_id.'.'.$fileType;
            $targetDir = $upload_path . $customName;
           
            // Move the uploaded files to the target directory
            move_uploaded_file($_FILES['profilePic']['tmp_name'], $targetDir);

            $queryf = "INSERT INTO document(doc_name,doc_path,person_id)
            VALUES('profile',:targetDir,:personid)";
            $stmtf = $conn->prepare($queryf);
            $stmtf->execute([
                ':targetDir' => $targetDir,
                ':personid' => $person_id
    
            ]);

        }
        if (isset($_FILES['otherDoc'])) {
            $upload_path = "other_doc/";
            $otherDoc = $_FILES['otherDoc']['name'];
            $fileType = strtolower(pathinfo($otherDoc, PATHINFO_EXTENSION));
            $customName = 'other_'.$person_id.'.'.$fileType;
            $targetDir = $upload_path . $customName;
           

            // Move the uploaded files to the target directory
            move_uploaded_file($_FILES['otherDoc']['tmp_name'], $targetDir);
            
            $queryf = "INSERT INTO document(doc_name,doc_path,person_id)
            VALUES('other',:targetDir,:personid)";
            $stmtf = $conn->prepare($queryf);
            $stmtf->execute([
                ':targetDir' => $targetDir,
                ':personid' => $person_id
    
            ]);
        }

        echo "<script>
                alert('Form submit successfully.');
                window.location.href='login.php';
             </script>";
             
    } 
    catch (PDOException $e) {
        
        
        echo "error" . $e->getMessage();
    }
}
$conn = null;
