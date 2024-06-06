<?php

require_once "../class/enrolled_students_class.php";

$profile = new EnrolleConfig();

$row_count = new EnrolledStudentsConfig();

$display_section = new ScheduleConfig();

$enrollee = $row_count->select_from_student();
$enrolled_student = $row_count->display_my_profile();

$section_one = $display_section->display_schedule_for_section_one();
$section_two = $display_section->display_schedule_for_section_two();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../icons/css/all.min.css">
    <link rel="stylesheet" href="../fonts/fonts.css">

    <!-- JAVASCRIPT -->
    <script src="../icons/js/all.js" defer></script>
    <script src="../mdb/js/mdb.min.js" defer></script>
    <script src="../js/index.js" defer></script>
    <script src="../js/print.js" defer></script>
    <title>Dashboard</title>

    <!-- JAVASCRIPT CHART START -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        // PIE CHART
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['Role Name', 'Role Count'],
            <?php $profile->display_user_count(); ?>
            ]);

            var options = {     
            is3D: true,
             legend: { position: 'right', alignment: 'center' },
            slices: {  1: {offset: 0.2},
                    2: {offset: 0.1},
                    3: {offset: 0.1},
            },
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>
    <script type="text/javascript">
        // BAR GRAPH
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Section Name', 'Section Count'],
                <?php $profile->display_section_count(); ?>
            ]);

            var options = {
                bar: { groupWidth: '40%' },
                legend: { position: 'top', alignment: 'center' }, // Adjust legend position
                colors: ['#3366CC', '#DC3912', '#FF9900'], // Specify bar colors
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
    <!-- JAVASCRIPT CHART END -->

</head>
<body>
    <header>
        <?php include "../includes/navbar.php"; ?>
    </header>

    <div class="container-fluid">
        <div class="column main-dashboard">

            <div class="dashboard-column">
                <?php include "../includes/sidebar.php"; ?>
            </div>
            <div class="dashboard-column main-container">
                <div class="cols-title title-show">
                    <h4><i class="fa-solid fa-tachometer-alt fa-fw me-2"></i>Dashboard</h4>
                </div>
                <!-- ADMIN ROLE -->
                <?php if ($_SESSION["role"] == "Administrator" || $_SESSION["role"] == "Teacher"): ?>
                    <div class="dashboard-main-body">

                        <div class="cols dashboard-body">
                            <a href="../admin/new_enrollees.php" class="text-light dashboard-item bg-warning ripple">
                                <div class="">
                                    <h3>
                                        <?php $row_count->display_new_enrollees_row_count(); ?>
                                    </h3>
                                    <p><i class="fa-solid fa-user-group fa-fw me-2"></i>New Enrollees</p>
                                </div>
                            </a>
                                                        
                            <a href="../admin/enrolled_students.php" class="text-light dashboard-item bg-success ripple">
                                    <div class="">
                                        <h3>
                                            <?php $row_count->display_enrolled_student_row_count(); ?>
                                        </h3>
                                        <p><i class="fa-solid fa-user-check fa-fw me-2"></i>Enrolled Students</p>
                                    </div>
                                </a>
                            
                        </div>
                        <div class="cols dashboard-body">

                                <a href="../admin/new_enrollees.php" class="text-light dashboard-item bg-danger ripple ">
                                    <div>
                                        <h3>
                                            <?php $row_count->display_dropped_student_row_count(); ?>
                                        </h3>
                                        <p><i class="fa-solid fa-user fa-fw me-2"></i>Dropped Students</p>
                                    </div>
                                </a>
                            
                                
                                <a href="../admin/schedule.php" class="text-light dashboard-item bg-secondary ripple">
                                    <div class="">
                                        <h3>
                                            <?php $row_count->display_schedule_row_count(); ?>
                                        </h3>
                                        <p><i class="fa-solid fa-calendar-check fa-fw me-2"></i>Schedules</p>
                                    </div>
                                </a>
                                
                            </div>
                        </div>
                        <div class="charts">
                            <div>
                                <h4>System Users</h4>
                                <div id="piechart_3d" class="pie-chart"></div>
                            </div>
                            <div>
                                <h4>Section</h4>
                                <div id="columnchart_material" class="bar-graph"></div>
                            </div>
                        </div>
                        
                        <div class="table-responsive dashboard-table-div">
                            <h4 class="">Class Schedule</h4>
                            <table class="table table-hover dashboard-table table-sm text-center">
                                <thead>
                                    <tr>
                                        <th><b>Section</b></th>
                                        <th><b>Subject Name</b></th>
                                        <th><b>Subject Code</b></th>
                                        <th><b>Day and Time</b></th>
                                    </tr>
                                </thead>
                                <tbody class="schedule-table">
                                <?php while ($row = $section_one->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row["SECTION"]; ?></td>
                                        <td><?= $row["SUBJECT_NAME"]; ?></td>
                                        <td><?= $row["SUBJECT_CODE"]; ?></td>
                                        <td><?= $row["DAY_AND_TIME"]; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive dashboard-table-div">
                            <table class="table table-hover dashboard-table table-sm text-center">
                                <thead>
                                    <tr>
                                        <th><b>Section</b></th>
                                        <th><b>Subject Name</b></th>
                                        <th><b>Subject Code</b></th>
                                        <th><b>Day and Time</b></th>
                                    </tr>
                                </thead>
                                <tbody class="schedule-table">
                                <?php while ($row = $section_two->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row["SECTION"]; ?></td>
                                        <td><?= $row["SUBJECT_NAME"]; ?></td>
                                        <td><?= $row["SUBJECT_CODE"]; ?></td>
                                        <td><?= $row["DAY_AND_TIME"]; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                           
                    </div>

                <!-- STUDENT ROLE -->   
                <?php elseif ($_SESSION["role"] == "Student"): ?>

                    <?php if ($enrolled_student["SECTION"] == 'Section 1'): ?>
                        <div class="table-responsive dashboard-table-div schedule-table">
                            <button id="print" class="btn schedule-button btn-outline-dark btn-sm mb-2">
                                <i class="fa-solid fa-print fa-fw me-2"></i>Print Schedule
                            </button>
                            <table class="table dashboard-table table-sm text-center">
                                <caption class="dashboard-caption"> <h5>Class Schedules</h5> </caption>
                                <thead>
                                    <tr>
                                        <th><b>Section</b></th>
                                        <th><b>Subject Name</b></th>
                                        <th><b>Subject Code</b></th>
                                        <th><b>Day and Time</b></th>
                                    </tr>
                                </thead>
                                <tbody class="schedule-table">
                                <?php while ($row = $section_one->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row["SECTION"]; ?></td>
                                        <td><?= $row["SUBJECT_NAME"]; ?></td>
                                        <td><?= $row["SUBJECT_CODE"]; ?></td>
                                        <td><?= $row["DAY_AND_TIME"]; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php elseif ($enrolled_student["SECTION"] == 'Section 2'):  ?>
                        
                        <div class="table-responsive dashboard-table-div">
                        <button id="print" class="btn schedule-button btn-outline-dark btn-sm mb-2">
                            <i class="fa-solid fa-print fa-fw me-2"></i>Print Schedule
                        </button>
                            <table class="table dashboard-table table-sm text-center">
                                <caption class="dashboard-caption"> <h5>Class Schedules</h5> </caption>
                                <thead>
                                    <tr>
                                        <th><b>Section</b></th>
                                        <th><b>Subject Name</b></th>
                                        <th><b>Subject Code</b></th>
                                        <th><b>Day and Time</b></th>
                                    </tr>
                                </thead>
                                <tbody class="schedule-table">
                                <?php while ($row = $section_two->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row["SECTION"]; ?></td>
                                        <td><?= $row["SUBJECT_NAME"]; ?></td>
                                        <td><?= $row["SUBJECT_CODE"]; ?></td>
                                        <td><?= $row["DAY_AND_TIME"]; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive dashboard-table-div">
                        <table class="table dashboard-table table-sm text-center">
                            <caption class="dashboard-caption"> <h5>Application Details</h5> </caption>
                            <thead>
                                <tr>
                                    <th><b>Enrollment Date</b></th>
                                    <th><b>Enrollee's Name</b></th>
                                    <th><b>Status</b></th>
                                </tr>
                            </thead>
                            <tbody class="schedule-table">
                                <tr>
                                    <td><?= $_SESSION["entrydate"]; ?></td>
                                    <td><?= $enrolled_student["FIRSTNAME"] . " " . $enrolled_student["MIDDLENAME"] . " " . $enrolled_student["LASTNAME"]; ?></td>
                                    <td><span class="badge <?= ($enrolled_student["STATUS"] == "Pending") ? "badge-warning text-warning" : "badge-success text-success", ($enrolled_student["STATUS"] == "Dropped") ? "badge-danger text-danger" : ""; ?>"><?= $enrolled_student["STATUS"]; ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    
                    <?php if ($enrolled_student["STATUS"] == "Pending") : ?>

                    <div class="notice-text m-3">
                        <small><span class="notice badge badge-success text-success">PLEASE BE PATIENT. AS WE PROCESS YOUR REQUEST.</span></small>
                    </div>


                    <?php endif; ?>

                <?php endif; ?>
                
            
            </div>
        </div>
    </div>
    <?php include "../includes/footer.php"; ?>
</body>
</html>