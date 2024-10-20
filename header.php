<?php
/*headre file*/

session_start();
$current_page = basename($_SERVER['PHP_SELF']);
    
function getSiteURL() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $path = dirname($script);

    return $protocol . $host . $path;
}


// Example usage



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo getSiteURL(); ?>/css/style1.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo getSiteURL(); ?>/assets/bootstrap/css/bootstrap.min.css">
    <script src="<?php echo getSiteURL(); ?>/javascript/jquery.min.js?<?php echo time(); ?>" crossorigin="anonymous"></script>

</head>
<body>
    <nav class="navbar navbar-expand-lg nav-heder" >
        <div class="container-fluid">
            <div class="logo">
                <img class="heder-logo" src="img\HR.png">
            </div>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['personid'])) { ?>
                        <?php if ($_SESSION['role'] == "A") { ?>
                            <li class="nav-item ms-2">
                                <a class="nav-link"  aria-current="page" href="dashboard_admin.php">Home</a>
                            </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                            <li class="nav-item ms-auto">
                                <a class="nav-link" href="logout.php">LOGOUT</a>
                            </li>
                        <?php } else { ?>
                </ul>
                <ul class="navbar-nav">
                            <li class="nav-item ms-2">
                                <a class="nav-link" aria-current="page" href="dashbord.php">Home</a>
                            </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                            <li class="nav-item text-right">
                                <a class="nav-link" href="logout.php">LOGOUT</a>
                            </li>
                        <?php }} else { ?>
                </ul>
                <ul class="navbar-nav">
                        <li class="nav-item ms-2">
                            <a class="nav-link" href="home.php">HOME</a>
                        </li>
                        <?php if ($current_page != "registration.php") { ?>
                            <li class="nav-item ms-2">
                                <a class="nav-link" href="registration.php">REGISTER</a>
                            <?php } ?>
                            </li>
                </ul>
                <?php if ($current_page != "login.php") { ?>
                <ul class="navbar-nav ms-auto">
                            <li class="nav-item text-right">
                                <a class="nav-link" href="login.php">LOGIN</a>
                            </li>
                        <?php } }; ?>
                </ul>
            </div>
        </div>
    </nav>
    
