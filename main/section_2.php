<?php

require_once "../class/enrolled_students_class.php";
$section = new EnrolledStudentsConfig();

$display_section = $section->display_section_two_student();

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
    <title>Document</title>
</head>
<body>
    <header>
        <?php include "../includes/navbar.php"; ?>
    </header>
    <div class="container-fluid">
        <div class="column">
            <div class="section-column">
                <?php include "../includes/sidebar.php"; ?>
            </div>
            <div class="section-column main-container">
                <div class="cols-title title-show">
                    <h4><i class="fa-solid fa-users fa-fw me-2"></i><?= ($_SESSION["role"] == "Administrator" || $_SESSION["role"] == "Teacher") ? "Section 2" : "My Class"; ?></h4>
                </div>
                <div class="section-content">
                    <?php if($display_section->num_rows > 0): ?>
                        <?php while($row = $display_section->fetch_assoc()): ?>
                            <div class="student">
                                <img src="../profiles/<?= $row["PROFILE"]; ?>" alt="">
                                <p><?= $row["LASTNAME"] . " " . $row["FIRSTNAME"]; ?></p>
                            </div>
                        <?php endwhile; ?>

                    <?php else: ?>
                            <h1>0 Student</h1>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include "../includes/footer.php"; ?>
</body>
</html>