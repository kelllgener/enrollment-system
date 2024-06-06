<?php

require_once "../class/schedule_class.php";

$schedule = new ScheduleConfig();

$list_of_subject = $schedule->display_subjects();
$list_of_section = $schedule->select_section();

if (isset($_GET["exportCSV"])) {
    $schedule->convert_to_csv_schedule();
}

$schedule_display = "";

if (isset($_POST["txtSearch"])) {
    $schedule_display = $schedule->search_schedule();
}
else {
    $schedule_display = $schedule->display_schedule();
}

if(isset($_POST["save"])) {
    
    $section_id = $_POST["section"];
    $subject_id = $_POST["subject"];
    $week_of_day = $_POST["day"];
    $start_time = $_POST["starttime"];
    $end_time = $_POST["endtime"];

    $new_start_time = new DateTime($start_time);
    $new_end_time = new DateTime($end_time);

    $formatted_start_time = $new_start_time->format("h:i A");
    $formatted_end_time = $new_end_time->format("h:i A");

    $insertion_result = $schedule->add_schedule($section_id, $subject_id, $week_of_day, $formatted_start_time, $formatted_end_time);

    if ($insertion_result == 1) {
        $_SESSION["alert"] = "The Date and Time is not available";
        $_SESSION["alert_code"] = "error";
    }
    else if ($insertion_result == 2) {
        $_SESSION["alert"] = "Schedule Added Successfully";
        $_SESSION["alert_code"] = "success";
        header("Refresh: 1");
    }
    else if ($insertion_result == 3) {
        $_SESSION["alert"] = "Please Input a Valid Time range";
        $_SESSION["alert_code"] = "error";
    }

}

if (isset($_GET["DELETE_SCHEDULE_BY_ID"]) && !empty($_GET['DELETE_SCHEDULE_BY_ID'])) {

    $class_ID = $_GET["DELETE_SCHEDULE_BY_ID"];
    $schedule->delete_schedule($class_ID);

}   

$page_no = $_SESSION['page_no'];
$total_records_per_page = $_SESSION['total_records_per_page'];
$offset = $_SESSION['offset'];
$previous_page = $_SESSION['prev_page'];
$next_page = $_SESSION['next_page'];
$result_count = $_SESSION['result_count'];
$records = $_SESSION['records'];
$total_records = $_SESSION['total_records'];
$total_no_of_pages = $_SESSION['total_no_of_pages'];


// AUTHENTICATION CHECK
if(!isset($_SESSION["user_ID"])) {
    header("location: ../log/index.php");
}

// Check if the user has the 'admin' role
if ($_SESSION['role'] !== 'Administrator' && $_SESSION['role'] !== 'Teacher') {
    // Redirect to a different page or show an error message
    header('HTTP/1.1 403 Forbidden');
    die('Forbidden - Insufficient Permissions');
}


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
    <script src="../sweetalert/sweetalert2.all.js"></script>
    <script src="../js/index.js" defer></script>
    <script src="../js/print.js" defer></script>
    <title>Document</title>
</head>
<body>
    <header>
        <?php include "../includes/navbar.php"; ?>
    </header>

    <div class="container-fluid">
        <div class="main-section">
            <div class="columns">
                <?php include "../includes/sidebar.php"; ?>
            </div>

            <div class="columns main-section-article">
                <div class="cols-title">
                    <h4><i class="fa-solid fa-calendar-check fa-fw me-2"></i><p>Schedules</p></h4>
                    <form action="" method="post" class="search-div">
                        <br>
                        <div class="input-group">
                            <input type="search" name="txtSearch" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                            <button type="submit" name="search" class="btn btn-primary btn-lg"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
                <div class="">
                    <div class="section-title">
                        <img class="logo" src="../images/logo.jpg" alt="">
                        <h5 class="text-dark">Brgy. Burol Elementary School</h5>
                        <h5 class="print-hidden">List of Schedules</h5>
                    </div>
                </div>  
                <div class="cols-table">
                    <div class="function-buttons <?php echo ($_SESSION["role"] == "Administrator") ? "" : "d-flex justify-content-end"; ?>">

                    <?php if ($_SESSION["role"] == "Administrator"): ?>

                        <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
                            <i class="fa-regular fa-calendar-plus fa-fw me-2"></i>Schedule
                        </button>

                    <?php endif; ?>

                        <div class="convert ">
                            <button id="print" class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa-solid fa-print fa-fw me-2"></i>Print
                            </button>
                            <a href="schedule.php?exportCSV" class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa-solid fa-download fa-fw me-2"></i>CSV
                            </a>
                        </div>
                    </div>

                    <form action="" method="post">
                        <div class="modal fade modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary mb-2">
                                        <h5 class="modal-title text-light" id="exampleModalLabel">Create New Schedule</h5>
                                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-4 p-2">
                                            <!-- SECTION -->
                                            <div class="input-sched p-0">
                                                <label for="section">Section</label>
                                                <select class="form-select mb-4" name="section" id="section" required>
                                                    <option value="">Select Section</option>
                                                    <?php if ($list_of_section->num_rows > 0): ?>
                                                    <?php   while ($row = $list_of_section->fetch_assoc()):  ?>
                                                            <option value="<?= $row["SECTION_ID"]; ?>"><?= $row["SECTION"]; ?></option>
                                                        <?php endwhile; ?>
                                                    <?php  
                                                    else : ?>
                                                        <option value="">No Section Available</option>
                                                        <?php endif; ?>
                                                </select>
                                            </div>
                                            <!-- SUBJECTS -->
                                            <div class="col p-0">
                                                <label for="subject">Subject</label>

                                                <select class="form-select mb-4" name="subject" id="subject" required>
                                                    <option value="">Select Subject</option>
                                                    <?php if ($list_of_subject->num_rows > 0): ?>
                                                    <?php   while ($row = $list_of_subject->fetch_assoc()):  ?>
                                                            <option value="<?= $row["SUBJECT_ID"]; ?>"><?= $row["SUBJECT_NAME"]; ?></option>
                                                        <?php endwhile; ?>
                                                    <?php  
                                                    else : ?>
                                                        <option value="">No Subject Available</option>
                                                        <?php endif; ?>
                                                </select>

                                            </div>
                                            <!-- WEEK OF THE DAY -->
                                            <div class="input-sched p-0">
                                                <label for="day">Day</label>
                                                <select class="form-select mb-4" name="day" id="day" required>
                                                    <option value="">Select Day</option>
                                                    <option value="Monday">Monday</option>
                                                    <option value="Tuesday">Tuesday</option>
                                                    <option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                </select>   
                                            </div>
                                            <!-- START AND END TIME -->
                                            <div class="row p-0 m-auto">
                                                <div class="col p-0">
                                                    <label for="starttime">Start Time</label>
                                                    <div class="cs-form cs-form-start">
                                                        <input type="time" id="starttime" name="starttime" class="form-control" value="" />
                                                    </div>
                                                </div>
                                                <div class="col p-0">
                                                    <label for="starttime">End Time</label>
                                                    <div class="cs-form cs-form-end">
                                                        <input type="time" id="endtime" name="endtime" class="form-control" value="" />
                                                    </div>
                                                </div>
                                            </div>
                        
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-primary" value="Save Schedule" name="save">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="cols-table">
                    <div class="table-nav">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-center">
                            <caption><strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong></caption>
                                <thead class="thead table-primary">
                                    <tr class="">
                                    <?php if ($_SESSION["role"] == "Administrator"): ?>
                                        <th>Schedule ID</th>
                                        <?php endif; ?>
                                        <th>Section</th>
                                        <th>Subject Name</th>
                                        <th>Subject Code</th>
                                        <th>Day of Week</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <?php if ($_SESSION["role"] == "Administrator"): ?>
                                        <th class="action">Action</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody class=" table-light">
                                <?php while ($row = $schedule_display->fetch_assoc()): ?>
                                    <tr>

                                    <?php if ($_SESSION["role"] == "Administrator"): ?>
                                        <td><?= $row["CLASS_ID"]; ?></td>
                                    <?php endif; ?>
                                        <td><?= $row["SECTION"]; ?></td>
                                        <td><?= $row["SUBJECT_NAME"]; ?></td>
                                        <td><?= $row["SUBJECT_CODE"]; ?></td>
                                        <td><?= $row["DAY_OF_WEEK"]; ?></td>
                                        <td><?= $row["START_TIME"]; ?></td>
                                        <td><?= $row["END_TIME"]; ?></td>
                                        

                                    <?php if ($_SESSION["role"] == "Administrator"): ?>
                                        <td class='action'>
                                            <a href='../update/schedule_update.php?UPDATE_SCHEDULE_BY_ID=<?= $row["CLASS_ID"]; ?>' class='btn btn-outline-success btn-sm' name='UPDATE' title="Update Schedule Details">
                                                <i class='fa-regular fa-pen-to-square'></i>
                                            </a>
                                            <a href='../admin/schedule.php?DELETE_SCHEDULE_BY_ID=<?= $row["CLASS_ID"]; ?>' class='delete btn btn-outline-danger btn-sm' id='delete' name='delete' title="Delete Schedule">
                                                <i class='fa-solid fa-trash delete'></i>
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                            
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination pagination-circle justify-content-end">
    
                                <li class="page-item">
                                <a class="page-link <?= ($page_no <= 1) ? 'disabled' : '';  ?>" 
                                <?= ($page_no > 1) ? "href=?page_no=" . $previous_page : ""; ?>>Previous</a>
                                </li>
    
                                <?php for ($counter = 1; $counter <= $total_no_of_pages; $counter++): ?>
    
                                    <?php if ($page_no !== $counter) { ?>
    
                                        <li class="page-item">
                                            <a class="page-link" href="?page_no=<?= $counter; ?>"> <?= $counter; ?> </a>
                                        </li>
    
                                    <?php } else { ?>
    
                                        <li class="page-item">
                                            <a class="page-link active"> <?= $counter; ?> </a>
                                        </li>
                                        
                                    <?php } ?>
    
                                <?php endfor; ?>
    
                                <li class="page-item">
                                <a class="page-link <?= ($page_no >= $total_no_of_pages) ? 'disabled' : '';  ?>" 
                                href=" <?= ($page_no < $total_no_of_pages) ? "?page_no=" . $next_page : ""; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "../includes/footer.php"; ?>

    <?php if(isset($_GET['delete_schedule_by_id'])) : ?>  

    <div class="flash-data" data-flashdata="<?= $_GET['delete_schedule_by_id']; ?>"></div>

    <?php endif; ?> 


    <script>
        $('.delete').on('click',function(e) {
            e.preventDefault();
            const href = $(this).attr('href')

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if(result.isConfirmed) {
                document.location.href = href;  
                }
            })
        })

        const flashdata = $('.flash-data').data('flashdata')
        if(flashdata){
        Swal.fire({
            title: 'Success',
            text: 'Record has been deleted',
            icon: 'success'
        })
        .then((result) => {
                if(result.isConfirmed) {
                    document.location.href = "../admin/schedule.php";  
                }
            })
        
        }
    </script>
</body>
</html>