<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../icons/css/all.min.css">
    <link rel="stylesheet" href="../fonts/fonts.css">

    <script src="../mdb/js/mdb.min.js" defer></script>
    <title>Document</title>
</head>
<body>
    <header>
        <?php include "../includes/navbar.php"; ?>
    </header>

    <div class="container-fluid">
        <div class="column about-us-main">
            <div class="column">
                <?php include "../includes/sidebar.php"; ?>
            </div>
            <div class="dashboard-column main-container">
                <div class="cols-title title-show">
                    <h4><i class="fa-solid fa-circle-info fa-fw me-2"></i>About us</h4>
                </div>
                <div class="aboutus-col">
                    <img src="../images/logo.jpg" alt="">
                    <div class="vision">
                        <h3>Burol Elementary School</h3>
                        <h5>Purok 5 Brgy. Burol, Calamba City</h5>
                    </div>
                </div>
                <div class="aboutus-col">
                    <img src="../images/vision.png" alt="" class="right-order">
                    <div class="vision">
                            <h3>The DepEd Vision</h3>
                            <p>We dream of Filipinos
                                who passionately love their country
                                and whose values and competencies
                                enable them to realize their full potential
                                and contribute meaningfully to building the nation.
                            </p>
                            <p>
                                As a learner-centered public institution,
                                the Department of Education
                                continuously improves itself
                                to better serve its stakeholders.
                            </p>
                        </div>
                        
                    </div>
                    <div class="aboutus-col">
                        <img src="../images/mission.png" alt="" >
                        <div class="vision">
                            <h3>The DepEd Mission</h3>
                            <p>
                                To protect and promote the right of every Filipino to quality,
                                equitable, culture-based, and complete basic education where:
                            </p>
                            <p>
                                Students learn in a child-friendly, gender-sensitive, safe, and motivating environment.
                                Teachers facilitate learning and constantly nurture every learner.
                                Administrators and staff, as stewards of the institution, ensure an enabling and supportive environment for effective learning to happen.
                                Family, community, and other stakeholders are actively engaged and share responsibility for developing life-long learners.
                            </p>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <?php include "../includes/footer.php"; ?>
</body>
</html>