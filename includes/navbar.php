<?php
require_once "../class/enrollee_class.php";
$profile = new EnrolleConfig();

// AUTHENTICATION CHECK
if(!isset($_SESSION["user_ID"])) {
    header("location: ../log/index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../mdb/css/mdb.min.css"/>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../fonts/fonts.css" />
    <link rel="stylesheet" href="../icons/css/all.min.css"/>
    <script src="../icons/js/all.min.js" defer></script>
    <title>navigation bar</title>
</head>

<body>
    <div class="container-fluid container-nav">
        <div class="site-title">
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" 
                aria-expanded="false" aria-label="Toggle navigation">

                <i class="fas fa-bars"></i>

            </button>

            <img src="../images/logo.jpg" alt="" />
            <!-- Toggle button -->
            <h1>Burol Elementary School Enrollment System</h1>

        </div>
        <nav>
            <ul class="navbar-nav ms-auto ms-md0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a href="" class="" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                        <img src="<?= $profile->displayProfile(); ?>" alt="">
                        <p><?= $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?></p>
                    </a>
                    <ul class="dropdown-menu dropdown-menu end" aria-labelledby="navbarDropdown">
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a href="../main/edit_profile.php" class="dropdown-item text-center">
                                <i class="fa-solid fa-circle-user fa-fw me-2"></i>Profile
                            </a>
                        </li>

                        <li>
                            <a href="../log/logout.php" class="dropdown-item text-center">
                                <i class="fa-solid fa-right-from-bracket fa-fw me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

</body>

</html>