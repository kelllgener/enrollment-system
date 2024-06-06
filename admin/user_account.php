<?php

require_once "../class/user_account_class.php";

$useracc = new UserAccount();

if (isset($_GET["exportCSV"])) {
    $useracc->convert_to_csv_system_users();
}

$display = "";

if (isset($_POST["txtSearch"])) {
    $display = $useracc->searchUserAccount();
}
else {
    $display = $useracc->displayUserAccount();
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


$firstname = $lastname = $middlename = $username = $email = $password = $confirm_password = "";

if (isset($_POST["save"])) {

    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $middlename = $_POST["mname"];
    $username = $_POST["uname"];
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $confirm_password = $_POST["cpass"];
    $roles = array($_POST["role"]);

    $result = $useracc->registerUser($firstname, $lastname, $middlename, $username, $password, $confirm_password, $email, $roles);

    if ($result == 1) {
        $_SESSION["alert"] = "Username or Email Unavailable";
        $_SESSION["alert_code"] = "error";
    } elseif ($result == 2) {
        $_SESSION["alert"] = "Account Created Successfully";
        $_SESSION["alert_code"] = "success";
        header("Refresh: 1");

    } elseif ($result == 3) {
        $_SESSION["alert"] = "Please Input a Valid First Name";
        $_SESSION["alert_code"] = "error";
    } elseif ($result == 4) {
        $_SESSION["alert"] = "Please Input a Valid Last Name";
        $_SESSION["alert_code"] = "error";
    } elseif ($result == 5) {
        $_SESSION["alert"] = "Please Input a Valid Email";
        $_SESSION["alert_code"] = "error";
    } elseif ($result == 6) {
        $_SESSION["alert"] = "Password does not Match";
        $_SESSION["alert_code"] = "error";
    }
    elseif ($result == 7) {
        $_SESSION["alert"] = "Please Input a Valid Middle Name";
        $_SESSION["alert_code"] = "error";
    }
    }

    if (isset($_GET["DELETE_BY_ID"]) && !empty($_GET['DELETE_BY_ID'])) {

        $userID = $_GET["DELETE_BY_ID"];
        $useracc->deleteUseraccount($userID);

    }   

// AUTHENTICATION CHECK
if(!isset($_SESSION["user_ID"])) {
    header("location: ../log/index.php");
}

// Check if the user has the 'admin' role
if ($_SESSION['role'] !== 'Administrator') {
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
                    <h4><i class="fa-solid fa-user-gear fa-fw me-2"></i><p>System Users</p></h4>
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
                        <h5 class="print-hidden">System Users</h5>
                    </div>
                </div>  
                <div class="cols-table">
                    <div class="function-buttons">
                        <button type="button" class="btn add btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
                            <i class="fa-solid fa-user-plus fa-fw me-2"></i>Account
                        </button>
                        <div class="convert">
                        <button id="print" class="btn btn-outline-dark btn-sm mb-2">
                            <i class="fa-solid fa-print fa-fw me-2"></i>Print
                        </button>
                        <a href="user_account.php?exportCSV" class="btn btn-outline-dark btn-sm mb-2">
                            <i class="fa-solid fa-download fa-fw me-2"></i>CSV
                        </a>
                    </div>
                        
                    </div>
                    <form action="" method="post">
                    <div class="modal fade modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary mb-2">
                                    <h5 class="modal-title text-light" id="exampleModalLabel">CREATE ACCOUNT</h5>
                                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="row mb-4 p-2">
                                        <div class="col p-0">
                                            <!-- Text input -->
                                            <div class="form-outline mb-4">
                                                <input type="text" id="lname" name="lname" class="form-control" required />
                                                <label class="form-label" for="lname">Last Name</label>
                                            </div>
                                        </div>
                                        <div class="col p-0">
                                            <div class="form-outline mb-4">
                                                <input type="text" id="form6Example1" name="fname" class="form-control" value="" required />
                                                <label class="form-label" for="form6Example1">First Name</label>
                                            </div>
                                        </div>
                                        <div class="col p-0">
                                            <div class="form-outline mb-4">
                                                <input type="text" id="form6Example1" name="mname" class="form-control" value="" />
                                                <label class="form-label" for="form6Example1">Middle Name</label>
                                            </div>
                                        </div>

                                        <!-- Text input -->
                                        <div class="form-outline mb-4">
                                            <input type="text" id="uname" name="uname" class="form-control" required />
                                            <label class="form-label" for="uname">Username</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="email" id="email" name="email" class="form-control" required />
                                            <label class="form-label" for="email">Email</label>
                                        </div>
                                        <!-- Text input -->
                                        <div class="form-outline mb-4">
                                            <input type="password" id="pass" name="pass" class="form-control" required />
                                            <label class="form-label" for="pass">Password</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="password" id="cpass" name="cpass" class="form-control" required />
                                            <label class="form-label" for="cpass">Re-enter Password</label>
                                        </div>
                                        <select name="role" id="" class="form-select" required>
                                            <option value="" active>Choose Role</option>
                                            <option value="Administrator">Administrator</option>
                                            <option value="Teacher">Teacher</option>
                                        </select>
                                        <!-- Submit button -->
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
                                    <tr class="">
                                        <th>User ID</th>
                                        <th>Profile</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Sign-up Date</th>
                                        <th class="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">
                                <?php while ($row = $display->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row["USER_ID"]; ?></td>
                                        <td><img src='../profiles/<?= $row["PROFILE"]; ?>' class='rounded-circle shadow-4-strong' alt=''></td>
                                        <td><?= $row["LASTNAME"]; ?></td>
                                        <td><?= $row["FIRSTNAME"]; ?></td>
                                        <td><?= $row["USERNAME"]; ?></td>
                                        <td><?= $row["EMAIL"]; ?></td>
                                        <td><?= $row["ROLE"]; ?></td>
                                        <td><?= $row["ENTRY_DATETIME"]; ?></td>
                                        <td class='action'>
                                            <a href='../update/user_update.php?UPDATE_BY_ID=<?= $row["USER_ID"]; ?>' class='btn btn-outline-success btn-sm' name='UPDATE' title="Update User Details">
                                            <i class='fa-regular fa-pen-to-square'></i>
                                            </a>
                                            <a href='../admin/user_account.php?DELETE_BY_ID=<?= $row["USER_ID"]; ?>' class='delete btn btn-outline-danger btn-sm' id='delete' name='delete' title="Delete User">
                                                <i class='fa-solid fa-trash delete'></i>
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

    <?php if(isset($_GET['delete_by_id'])) : ?>  

    <div class="flash-data" data-flashdata="<?= $_GET['delete_by_id']; ?>"></div>

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
                    document.location.href = "../admin/user_account.php";  
                }
            })
        
        }
    </script>
</body>
</html>