<?php 
require_once "../class/subject_class.php";

$subject = new SubjectConfig();
$enrolled_student = $subject->display_my_profile();


if (isset($_GET["exportCSV"])) {
    $subject->convert_to_csv_subjects();
}

$display = "";

if (isset($_POST["txtSearch"])) {
    $display = $subject->search_subject();
}
else {
    $display = $subject->display_subjects();
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

if (isset($_POST["save"])) {
    $subject_name = $_POST["subject-name"];
    $subject_code = $_POST["subject-code"];

    $result = $subject->add_subject($subject_name, $subject_code);

    if ($result == 1) {
        $_SESSION["alert"] = "Subject Created Successfully";
        $_SESSION["alert_code"] = "success";
        header("Refresh: 1");
    }
}

if (isset($_GET["DELETE_SUBJECT_BY_ID"]) && !empty($_GET['DELETE_SUBJECT_BY_ID'])) {

    $subject_id = $_GET["DELETE_SUBJECT_BY_ID"];
    $subject->delete_subject($subject_id);

}  

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
                    <h4><i class="fa-solid fa-book-open-reader fa-fw me-2"></i><p>List of Subjects</p></h4>
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
                        <h5 class="print-hidden">List of Subjects</h5>
                    </div>
                </div>  
                <div class="cols-table">
                    <div class="function-buttons <?php echo ($_SESSION["role"] == "Administrator") ? "" : "d-flex justify-content-end"; ?>">

                    <?php if ($_SESSION["role"] == "Administrator"): ?>

                        <button type="button" class="btn add btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
                            <i class="fa-solid fa-plus fa-fw me-2"></i></i>Subject
                        </button>
                        
                    <?php endif; ?>
                        <div class="convert">
                            <button id="print" class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa-solid fa-print fa-fw me-2"></i>Print
                            </button>
                            <a href="subject.php?exportCSV" class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa-solid fa-download fa-fw me-2"></i>CSV
                            </a>
                        </div>
                    </div>
                    <form action="" method="post">
                        <div class="modal fade modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary mb-2">
                                        <h5 class="modal-title text-light" id="exampleModalLabel"><i class="fa-solid fa-plus"></i></i>&nbsp;SUBJECT</h5>
                                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-outline mb-4">
                                            <textarea class="form-control" id="form6Example7" name="subject-name" rows="4" required></textarea>
                                            <label class="form-label" for="form6Example7">Subject Name</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="text" id="subject-code" name="subject-code" class="form-control" required />
                                            <label class="form-label" for="subject-code">Subject Code</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-primary" value="Create Now" name="save">
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
                                    <tr>
                                        <?php if ($_SESSION["role"] == "Administrator"): ?>
                                            <th>Subject ID</th>
                                            <th>Subject Name</th>
                                            <th>Subject Code</th>
                                            <th class='action'>Action</th>

                                        <?php elseif ($_SESSION["role"] == "Teacher"): ?>
                                            <th>Subject ID</th>
                                            <th>Subject Name</th>
                                            <th>Subject Code</th>

                                        <?php elseif ($_SESSION["role"] == "Student"):?>
                                            <th>Subject ID</th>
                                            <th>Subject Name</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody class=" table-light">
                                <?php while ($row = $display->fetch_assoc()): ?>    
                                    <tr>
                                    <?php if ($_SESSION["role"] == "Administrator" || $_SESSION["role"] == "Teacher"): ?>
                                        <td><?= $row["SUBJECT_ID"]; ?></td>
                                    <?php endif; ?>

                                        <td><?= $row["SUBJECT_NAME"]; ?></td>
                                        <td><?= $row["SUBJECT_CODE"]; ?></td>
                                    <?php if ($_SESSION["role"] == "Administrator"): ?>
                                        <td class='action'>
                                            <a href='../update/subject_update.php?UPDATE_SUBJECT_BY_ID=<?= $row["SUBJECT_ID"]; ?>' class='btn btn-outline-success btn-sm' name='UPDATE' title="Update subject details">
                                            <i class='fa-regular fa-pen-to-square'></i>
                                            </a>
                                            <a href='../admin/subject.php?DELETE_SUBJECT_BY_ID=<?= $row["SUBJECT_ID"]; ?>' class='delete btn btn-outline-danger btn-sm' id='delete' name='delete' title="Delete subject">
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

    <?php if(isset($_GET['delete_subject_by_id'])) : ?>  

    <div class="flash-data" data-flashdata="<?= $_GET['delete_subject_by_id']; ?>"></div>

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
                    document.location.href = "../admin/subject.php";  
                }
            })
        
        }
    </script>

</body>
</html>