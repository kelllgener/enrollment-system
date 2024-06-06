<?php

require_once "../class/enrollee_class.php";

$enroll = new EnrolleConfig();

if (isset($_GET["exportCSV"])) {
    $enroll->convert_to_csv_enrollees();
}

$student_display = "";  

if (isset($_POST["txtSearch"])) {
    $student_display = $enroll->search_new_enrollees();
}
else {
    $student_display = $enroll->display_new_enrollees();
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
                    <h4><i class="fa-solid fa-user-group fa-fw me-2"></i><p>Manage Students</p></h4>
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
                        <h5 class="print-hidden">List of Students</h5>
                    </div>
                </div>  
                <div class="cols-table">
                    <div class="function-buttons">
                        <div class="convert-btn">
                            <button id="print" class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa-solid fa-print fa-fw me-2"></i>Print
                            </button>
                            <a href="new_enrollees.php?exportCSV" class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa-solid fa-download fa-fw me-2"></i>CSV
                            </a>
                        </div>
                    </div> 
                </div>
                <div class="cols-table">
                    <div class="table-nav">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-center">
                            <caption><strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong></caption>
                                <thead class="thead table-primary">
                                    <tr class="">
                                        <th>ID</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Sex</th>
                                        <th>Age</th>
                                        <th>Address</th>
                                        <th>Contact</th>
                                        <th>Birth Certificate</th>
                                        <th>Status</th>
                                        <th class='action'>Review</th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">
                                <?php while ($row = $student_display->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row["STUDENT_ID"]; ?></td>
                                        <td><?php echo $row["LASTNAME"]; ?></td>
                                        <td><?php echo $row["FIRSTNAME"]; ?></td>
                                        <td><?php echo $row["MIDDLENAME"]; ?></td>
                                        <td><?php echo $row["SEX"]; ?></td>
                                        <td><?php echo $row["AGE"]; ?></td>
                                        <td><?php echo $row["ADDRESS"]; ?></td>
                                        <td><?php echo $row["CONTACT_NO"]; ?></td>
                                        <td>
                                            <a href="../class/download_image.php?filepath=<?= $row["BIRTH_CERTIFICATE"]; ?>" class="btn btn-outline-black btn-sm">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </td>
                                        <td><span class="badge <?= ($row["STATUS"] == "Pending") ? "badge-warning text-warning" : "badge-success text-success", ($row["STATUS"] == "Dropped")? "badge-danger text-danger" : ""; ?>"><?php echo $row["STATUS"]; ?></span></td>
                                        <td class='action'>
                                            <a href='../admin/review_enrollees.php?REVIEW_BY_STUDENT_ID=<?= $row["STUDENT_ID"]; ?>' class='btn btn-outline-info btn-sm' name='review' title="View Student Details">
                                                <i class='fa-solid fa-eye'></i>
                                            </a>
                                        </td>
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
</body>
</html>