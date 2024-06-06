<?php

require_once "../class/enrollee_class.php";

$student = new EnrolleConfig();

$enrollee = $student->select_from_student();
$enrolled_student = $student->display_my_profile();

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
    <link rel="stylesheet" href="../mdb/css/mdb.min.css" />
    <link rel="stylesheet" href="../icons/css/all.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../fonts/fonts.css" />
    <script src="../icons/js/all.min.js" defer></script>
    <title>sidebar</title>
</head>

<body>
    <div class="container-fluid">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse">
            <div class="profile text-center">
                <img class="profile-img shadow-5-strong" src="<?php echo $profile->displayProfile(); ?>" alt="">
                <h6><?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?></h6>
                <h6><?php echo $_SESSION["role"]; ?></h6>
            </div>
            <div class="position-sticky" id="sidebar-button">
                <div class="list-group list-group-flush">

                <?php if($_SESSION["role"] == "Administrator"): ?>
                    <a href="../admin/dashboard.php" data-page="../admin/dashboard" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-tachometer-alt fa-fw me-3"></i>
                        <span>DASHBOARD</span>
                    </a>
                    <a href="../admin/new_enrollees.php" data-page="../admin/new_enrollees" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-user-group fa-fw me-3"></i>
                        <span>MANAGE STUDENTS</span>
                    </a>
                    <a href="../admin/enrolled_students.php" data-page="../admin/enrolled_students" class="list-group-item list-group-item-action py-2 ripple ">
                        <i class="fa-solid fa-user-check fa-fw me-3"></i>
                        <span>ENROLLED STUDENTS</span>
                    </a>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h1 class="accordion-header">
                                <button class="accordion-button collapsed bg-success text-white show py-3 ripple" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                                    <i class="fa-solid fa-chalkboard-user fa-fw me-3"></i><span>CLASS</span>
                                </button>
                            </h1>
                            <div id="flush-collapseZero" class="accordion-collapse show" data-mdb-parent="#accordionFlushExample">
                                <div class="accordion-body py-1">
                                    <a href="../main/section_1.php" data-page="../admin/section_1"  class="accordion-anchor ripple py-2"><i class="fa-solid fa-users-line fa-fw me-2"></i><span>SECTION 1</span></a>
                                </div>
                                <div class="accordion-body py-1">
                                    <a href="../main/section_2.php" data-page="../admin/section_2" class="accordion-anchor ripple py-2"><i class="fa-solid fa-users-line fa-fw me-2"></i><span>SECTION 2</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="../admin/schedule.php" data-page="../admin/schedule" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-calendar-check fa-fw me-3"></i>
                        <span>SCHEDULES</span>
                    </a>
                    <a href="../admin/subject.php" data-page="../admin/subject" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-book-open-reader fa-fw me-3"></i>
                        <span>LIST OF SUBJECTS</span>
                    </a>
                    <a href="../admin/user_account.php" data-page="../admin/user_account" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-user-gear fa-fw me-3"></i>
                        <span>SYSTEM USERS</span>
                    </a>
                    <a href="../main/about_us.php" data-page="../main/about_us" class="aboutus list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-circle-info fa-fw me-3"></i>
                        <span>ABOUT US</span>
                    </a>

                <?php elseif($_SESSION["role"] == "Teacher"): ?>

                    <a href="../admin/dashboard.php" data-page="../admin/dashboard" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-tachometer-alt fa-fw me-3"></i>
                        <span>DASHBOARD</span>
                    </a>
                    <a href="../admin/new_enrollees.php" data-page="../admin/new_enrollees" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-user-group fa-fw me-3"></i>
                        <span>MANAGE STUDENTS</span>
                    </a>
                    <a href="../admin/enrolled_students.php" data-page="../admin/enrolled_students" class="list-group-item list-group-item-action py-2 ripple ">
                        <i class="fa-solid fa-user-check fa-fw me-3"></i>
                        <span>ENROLLED STUDENTS</span>
                    </a>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h1 class="accordion-header">
                                <button class="accordion-button  collapsed show py-2 ripple" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseZero">
                                    <i class="fa-solid fa-school fa-fw me-3"></i><span>CLASS</span>
                                </button>
                            </h1>
                            <div id="flush-collapseZero" class="accordion-collapse show" data-mdb-parent="#accordionFlushExample">
                                <div class="accordion-body py-1">
                                    <a href="../main/section_1.php" data-page="../main/section_1"  class="accordion-anchor"><i class="fa-solid fa-users-line fa-fw me-2"></i><span>SECTION 1</span></a>
                                </div>
                                <div class="accordion-body py-1">
                                    <a href="../main/section_2.php" data-page="../main/section_2" class="accordion-anchor"><i class="fa-solid fa-users-line fa-fw me-2"></i><span>SECTION 2</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="../admin/schedule.php" data-page="../admin/schedule" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-calendar-check fa-fw me-3"></i>
                        <span>SCHEDULES</span>
                    </a>
                    <a href="../admin/subject.php" data-page="../admin/subject" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-book-open-reader fa-fw me-3"></i>
                        <span>LIST OF SUBJECTS</span>
                    </a>
                    <a href="../main/about_us.php" data-page="../main/about_us" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-circle-info fa-fw me-3"></i>
                        <span>ABOUT US</span>
                    </a>

                <?php elseif($_SESSION["role"] == "Student"): ?>

                        <a href="../admin/dashboard.php" data-page="../admin/dashboard" class="list-group-item list-group-item-action py-2 ripple">
                            <i class="fas fa-tachometer-alt fa-fw me-3"></i>
                            <span>DASHBOARD</span>
                        </a>
                        <a href="../main/personal_information.php" data-page="../main/personal_information" class="list-group-item list-group-item-action py-2 ripple">
                            <i class="fas fa-user fa-fw me-3"></i>
                            <span>MY PROFILE</span>
                        </a>
    
                    <?php if($enrolled_student["STATUS"] == "Enrolled"): ?>
                        
                        <?php if($enrolled_student["SECTION"] == "Section 1"): ?>

                            <a href="../main/section_1.php" data-page="../main/section_2" class="list-group-item list-group-item-action py-2 ripple ">
                                <i class="fa-solid fa-users fa-fw me-3"></i>
                                <span>MY CLASS</span>
                            </a>

                        <?php elseif($enrolled_student["SECTION"] == "Section 2"): ?>

                            <a href="../main/section_2.php" data-page="../main/section_2" class="list-group-item list-group-item-action py-2 ripple ">
                                <i class="fa-solid fa-users fa-fw me-3"></i>
                                <span>MY CLASS</span>
                            </a>

                        <?php endif; ?>

                    <?php endif; ?>
                        <a href="../main/about_us.php" data-page="../main/about_us" class="list-group-item list-group-item-action py-2 ripple">
                            <i class="fa-solid fa-circle-info fa-fw me-3"></i>
                            <span>ABOUT US</span>
                        </a>

                <?php endif; ?>
                    
                </div>
            </div>
        </nav>
        <!-- Sidebar -->
    </div>

    <script>
        // Event delegation to handle click events on the entire sidebar
        document.getElementById('sidebar-button').addEventListener('click', function(event) {
            if (event.target.tagName === 'A') {
                event.preventDefault();

                // Remove active class from all sidebar items
                var sidebarItems = document.querySelectorAll('#sidebar-button a');
                sidebarItems.forEach(item => item.classList.remove('active'));

                // Add active class to the clicked item
                event.target.classList.add('active');

                // Save the active page in sessionStorage
                var activePage = event.target.getAttribute('data-page');
                sessionStorage.setItem('activePage', activePage);

                // Redirect to the clicked page
                window.location.href = event.target.href;
            }
        });

        // Set the active class based on the stored active page
        var storedActivePage = sessionStorage.getItem('activePage');
        if (storedActivePage) {
            var activeLink = document.querySelector('#sidebar-button a[data-page="' + storedActivePage + '"]');

            if (activeLink) {
                activeLink.classList.add('active');
                
            }
        }
    </script>
    
</body>

</html>