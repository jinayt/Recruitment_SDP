<?php
    $currentpage = basename($_SERVER['PHP_SELF']);
  
?>


    <nav class="sidebar">
        <div class="menu-content ">
            <ul class="menu-item ps-0">
                <li class="item ps-3" <?php echo $currentpage == 'dashboard_admin.php'? 'style="background: #c2c0c0;"': '';?>>
                    <a class="item-link" href="dashboard_admin.php">
                    <i class="fa-solid fa-user" style="color: black;"></i>
                        <span class="side-name"> Dashbord</span>

                    </a>
                </li>    

                <li class="item ps-3" <?php echo $currentpage == 'profile.php'? 'style="background: #c2c0c0;"': '';?>>
                    <a class="item-link" href="profile.php">
                        <i class="fa-solid fa-address-card" style="color: black;"></i>
                        <span class="side-name"> Profile</span>

                    </a>
                </li>

                <li class="item ps-3" <?php echo $currentpage == 'application_list.php'? 'style="background: #c2c0c0;"': '';?>>
                    <a class="item-link" href="application_list.php" >
                    <i class="fa-solid fa-list-ol" style="color: black;"></i>
                        <span class="side-name"> Application List</span>

                    </a>
                </li>
                <li class="item ps-3" <?php echo $currentpage == 'interview.php'? 'style="background: #c2c0c0;"': '';?>>
                    <a class="item-link" href="interview.php" >
                    <i class="fa-solid fa-person-circle-question" style="color: black;"></i>    
                   
                        <span class="side-name"> Interview</span>

                    </a>
                </li>

                <li class="item submenu-item ps-3" onclick="showMenu()">
                <i class="fa-solid fa-user-tie" style="color: black;"></i>
                    <span class="side-name" > Job Opportunity</span><span id="indic" class="side-name indicate <?php echo $currentpage == "create_job.php"|| $currentpage == 'view_jobs.php'? "hidemenu": "";?>" >+</span>
                    

                </li>
                <ul id = 'submenu' class="menu-item submenu" <?php echo $currentpage == 'create_job.php'|| $currentpage == 'view_jobs.php'? 'style="display:block;"': 'style="display:none;"';?>>
                    <li class="item ps-3" <?php echo $currentpage == 'view_jobs.php'? 'style="background: #c2c0c0;"': '';?>> 
                        <a class="item-link" href="view_jobs.php">
                            <span class="sub-name">View Job opportunity</span>
                        </a>
                    </li>
                
                
                    <li class="item ps-3" <?php echo $currentpage == 'create_job.php'? 'style="background: #c2c0c0;"': '';?>>
                        <a class="item-link" href="create_job.php">
                            <span class="sub-name">Create Job opportunity</span>
                        </a>
                    </li>
                </ul>

                <li class="item ps-3">
                    <a class="item-link" href="report.php">
                        <i class="fa-solid fa-file" style="color: black;"></i>
                        <span class="side-name">Report</span>

                    </a>
                </li>
                
            </ul>
        </div>
    </nav>

    

