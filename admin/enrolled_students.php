<?php

require_once "../class/enrolled_students_class.php";

$enrolled = new EnrolledStudentsConfig();

if (isset($_GET["exportCSV"])) {
    $enrolled->convert_to_csv_enrolled_student();
}

$student_display = "";

if (isset($_POST["txtSearch"])) {
    $student_display = $enrolled->search_enrolled_students();
}
else {
    $student_display = $enrolled->display_enrolled_students();
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

if (isset($_GET["DROP_STUDENT_BY_ID"]) && !empty($_GET['DROP_STUDENT_BY_ID'])) {

    $student_id = $_GET["DROP_STUDENT_BY_ID"];
    $enrolled->drop_student($student_id);

}  

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
    <script src="../sweetalert/sweetalert2.all.js"></script>
    <link rel="stylesheet" href="../fonts/fonts.css">

    <!-- JAVASCRIPT -->
    <script src="../icons/js/all.js" defer></script>
    <script src="../mdb/js/mdb.min.js" defer></script>
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
                    <h4><i class="fa-solid fa-user-check fa-fw me-2"></i><p>Enrolled Students</p></h4>
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
                        <h5 class="print-hidden">Enrolled Students</h5>
                    </div>
                </div>  
                <div class="cols-table">
                    <div class="function-buttons">
                        <div class="convert-btn">
                            <button id="print" class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa-solid fa-print fa-fw me-2"></i>Print
                            </button>
                            <a href="enrolled_students.php?exportCSV" class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa-solid fa-download fa-fw me-2"></i>CSV
                            </a>
                        </div>
                    </div> 
                </div>

                <div class="cols-table">
                    <div class="table-nav">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm text-center">
                            <caption><strong>Page <?= $page_no . " of " . $total_no_of_pages; ?></strong></caption>
                                <thead class="thead table-primary">
                                    <tr class="">
                                        <th>LRN</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Sex</th>
                                        <th>Age</th>
                                        <th>Address</th>
                                        <th>Contact</th>
                                        <th>Status </th> 
                                        <th class='action'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class=" table-light">
                                <?php while ($row = $student_display->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row["LRN"]; ?></td>
                                        <td><?= $row["LASTNAME"]; ?></td>
                                        <td><?= $row["FIRSTNAME"]; ?></td>
                                        <td><?= $row["MIDDLENAME"]; ?></td>
                                        <td><?= $row["SEX"]; ?></td>
                                        <td><?= $row["AGE"]; ?></td>
                                        <td><?= $row["ADDRESS"]; ?></td>
                                        <td><?= $row["CONTACT_NO"]; ?></td>
                                        <td><span class="badge <?= ($row["STATUS"] == "Pending") ? "badge-warning text-warning" : "badge-success text-success" ?>"><?php echo $row["STATUS"]; ?></i></span></td>
                                        <td class='action'>
                                            <a href='../admin/review_enrollees.php?REVIEW_BY_STUDENT_ID=<?= $row["STUDENT_ID"]; ?>' class='btn btn-outline-info btn-sm' name='review' title="View Student Details">
                                                <i class='fa-solid fa-eye'></i>
                                            </a>
                                            <a href='../admin/enrolled_students.php?DROP_STUDENT_BY_ID=<?= $row["USER_ID"]; ?>' class='drop btn btn-outline-warning btn-sm' id="drop" name='drop' title="Drop Student">
                                                <i class="fa-solid fa-user-minus"></i>
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

    <?php if(isset($_GET['drop_student_by_id'])) : ?>  

    <div class="flash-data" data-flashdata="<?= $_GET['drop_student_by_id']; ?>"></div>

    <?php endif; ?> 


    <script>
        $('.drop').on('click',function(e) {
            e.preventDefault();
            const href = $(this).attr('href')

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, drop student!',
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
            text: 'Student has been dropped',
            icon: 'success'
        })
        .then((result) => {
                if(result.isConfirmed) {
                    document.location.href = "../admin/enrolled_students.php";  
                }
            })
        
        }
    </script>
</body>
</html>