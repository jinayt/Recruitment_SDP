<?php
// Include TCPDF library
require_once ('TCPDF/tcpdf.php');
require_once ("dbconnection.php");

try {

    $query = "SELECT 
                app.*, 
                jt.title_name, 
                per.First_name, 
                per.Last_name, 
                per_int.First_name as int_fname, 
                per_int.Last_name as int_lname
                FROM 
                application app
                JOIN 
                job_opportunity jo ON app.job_id = jo.job_id
                JOIN 
                job_title jt ON jo.title_id = jt.title_id
                JOIN 
                person per ON per.Person_id = app.person_id
                LEFT JOIN 
                person per_int ON app.Interviewer_id = per_int.Person_id
                where 1=1";
                
                
                
    //search
    if(!empty($_POST['search'])){
        $search = $_POST['search'];
        $query .= " and (per.First_name like '%{$search}%' or per.Last_name like '%{$search}%' or jt.title_name like '%{$search}%')";

    }
   
    //position
    if(!empty($_POST['position'])){
        $position = $_POST['position'];    
        $query .= " and jt.title_name = '$position'";
    }

    //from date
    if(!empty($_POST['from_date'])){
        $from_date = $_POST['from_date'];    
        $query .= " and app.date_of_application >= '$from_date'";
    }

    //to date
    if(!empty($_POST['to_date'])){
        $to_date = $_POST['to_date'];    
        $query .= " and app.date_of_application <= '$to_date'";
    }
    if(!empty($_POST['status'])){
        $status = $_POST['status'];    
        $query .= " and app.status in('$status')";
    }
    
    if(!empty($_POST['candidate_id'])){
        $candidate_id = $_POST['candidate_id'];    
        $query .= " and app.person_id =  $candidate_id";
    }

    $query .= " ORDER BY 
    app.date_of_application DESC";

    $stmt = $conn->query($query);
    
    // Create new PDF document
    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', true);
    

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    
    // // Define the width of the cell
    // $cellWidth = 100; // Width in mm

    // // Get the width of the page
    // $pageWidth = $pdf->getPageWidth();

    // // Calculate the x position to center the cell
    // $xPosition = ($pageWidth - $cellWidth) / 2;

    // // Set the x position
    // $pdf->SetX($xPosition);


    $pdf->AddPage();

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 10);

    $pdf->SetMargins(10, 10, 10); // Left, Top, Right

    // Define cell width and height
    $cellWidth = $pdf->getPageWidth(); // Width of the cell in mm
    $cellHeight = 8;
    // Calculate X position to center the cell on the page
    $xPosition = ($pdf->getPageWidth() - $cellWidth) / 2;

    // Set the X position for the cell
    $pdf->SetX($xPosition);
    $currentDateTime = date('d-m-Y h:i A');
    $htmlContent = '
    <h2 style="text-align: center; line-height: 1;">Candidate Report</h2>
    <p style="text-align: right; line-height: 1;">Generated on: '.$currentDateTime.'</p>
    <hr style="width: 100%; border: 1px solid black;">
';

    $pdf->writeHTMLCell($cellWidth,$cellHeight,'','',$htmlContent,0,1,0,true,'C','C',true);
    // $pdf->writeHTMLCell($cellWidth,$cellHeight,'','',"<p>$currentDateTime</p><hr>",1,1,0,'C','C');
    
    
    $html = <<<EOD
    <br>
    <table cellspacing="0" cellpadding="4" border="1">
                    <thead>
                        <tr style="background-color: #FAEBD7;">
                            <th>Sr. No.</th>
                            <th>Person Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Position</th>
                            <th>Date of application</th>
                            <th>Status</th>
                            <th>Interviewer Name</th>
                            <th>Interviewer Date</th>
                        </tr>
                    </thead>
                    <tbody> 
    EOD;
    
    if ($stmt->rowCount() > 0) {
        
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Jinay Tandel');
        $pdf->SetTitle('Candidate Report');
        $pdf->SetSubject('Candidate details');

        // Set font
        $pdf->SetFont('times', '', 12);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $num = 1;
        
        foreach ($rows as $index => $row) {
            
            $person_id = $row['person_id'];
            $First_name = $row['First_name'];
            $Last_name = $row['Last_name'];
            $a_date = new DateTime($row['date_of_application']);
            $date_of_application = $a_date->format("d-m-Y");
            $status = $row['status'];
            $i_date = new DateTime($row['interview_date']);
            $interview_date = $a_date->format("d-m-Y");
            $position = $row['title_name'];
            $int_fname = $row['int_fname'];
            $int_lname = $row['int_lname'];

            $html .= <<<EOD
                            <tr>
                            <td style="text-align:center">$num</td>
                            <td style="text-align:center">$person_id</td>
                            <td>$First_name</td>
                            <td>$Last_name</td>
                            <td>$position</td>
                            <td>$date_of_application</td>
                            <td>$status</td>
                            <td>$int_fname $int_lname</td>
                            <td>$interview_date</td>
                        </tr>
            EOD;
                    
            $num++;
        }
        $html .= <<<EOD
            </tbody>
                </table>
                </body>
                </html>
        EOD;
        
        // Add HTML content to PDF
         $pdf->writeHTML($html, true, false, true, false, '');
         $pdfFilePath = __DIR__.'/download/Candidate_report.pdf';
                
         // Output PDF document
         $pdf->Output($pdfFilePath, 'F');
         header('Content-Type: application/json');
         echo json_encode(array("status"=>"success", "filepath"=>basename($pdfFilePath)));

    } else {
        header('Content-Type: application/json');
        echo json_encode(array("status"=>"error", "message"=>"No Candidate found"));
    }
    
  $conn = null;  
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
