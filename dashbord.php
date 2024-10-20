<?php include_once "header.php"; ?>

<div class="min_wid">
    <div class="user-menu">
        
            <a class="link-icon" href="profile.php">
                <div class="menu1">
                    <i class="fa-solid fa-address-card" style="color: black; font-size:100px;"></i><br>
                    <span>Profile</span>
                </div>
            </a>
        

            <?php if($_SESSION['role']=='U'){?>
            <a class="link-icon" href="job_apply.php">
               <div class="menu1">
                    <i class="fa-solid fa-user-tie" style="color: black; font-size:100px;"></i><br>
                    <span>Job Opportunity</span>
                </div>
            </a>

            <a class="link-icon" href="job_status.php">
               <div class="menu1">
                    <i class="fa-solid fa-user-doctor" style="color: black; font-size:100px;"></i><br>
                    <span>My Application</span>
                </div>
            </a>
            <?php }?>

        <?php if($_SESSION['role']=='E'){?>
            <a class="link-icon" href="interview.php">
                <div class="menu1">
                        <i class="fa-solid fa-person-circle-question" style="color: black; font-size:100px;"></i>    
                        <br>
                    <span>Interview</span>
                </div>
            </a>

            <a class="link-icon" href="report.php">
                <div class="menu1">
                    <i class="fa-solid fa-file" style="color: black; font-size:100px;"></i><br>
                    <span>Report</span>
                </div>
            </a>
        <?php };?>
    </div>
</div>


<?php include "footer.php" ?>