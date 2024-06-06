<?php

require_once "../class/schedule_class.php";

$schedule = new ScheduleConfig();

$list_of_subject = $schedule->display_subjects();
$list_of_section = $schedule->select_section();


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET["UPDATE_SCHEDULE_BY_ID"]) && empty($_GET["UPDATE_SCHEDULE_BY_ID"])) {
        header("location: ../main/subject.php");
        exit;
    }

    $class_id = $_GET["UPDATE_SCHEDULE_BY_ID"];

    $row = $schedule->select_schedule_to_update($class_id);

    // USER INFORMATION FROM DATABASE
    $class_id = $row["CLASS_ID"];
    $section_id = $row["SECTION_ID"];
    $section_name = $row["SECTION"];
    $subject_id = $row["SUBJECT_ID"];
    $subject_name = $row["SUBJECT_NAME"];
    $day_of_week = $row["DAY_OF_WEEK"];
    $start_time = $row["START_TIME"];
    $end_time = $row["END_TIME"];

    $new_start_time = new DateTime($start_time);
    $new_end_time = new DateTime($end_time);

    $formatted_start_time = $new_start_time->format('H:i');
    $formatted_end_time = $new_end_time->format('H:i');
} else {
    if (isset($_POST["save"])) {

        $class_id = $_POST["class_id"];
        $section_id = $_POST["section_id"];
        $subject_id = $_POST["subject"];
        $day_of_week = $_POST["day"];
        $start_time = $_POST["starttime"];
        $end_time = $_POST["endtime"];
        $result = $schedule->update_schedule($section_id, $subject_id, $day_of_week, $start_time, $end_time, $class_id);

        if ($result == 1) {
            $_SESSION["alert"] = "The Date and Time is not available";
            $_SESSION["alert_code"] = "error";
        } else if ($result == 2) {
            $_SESSION["alert"] = "Schedule Updated Successfully";
            $_SESSION["alert_code"] = "success";
            // Redirect the user after a successful update
            header("location: ../admin/schedule.php");
            exit;
        } else if ($result == 3) {
            $_SESSION["alert"] = "Please Input a Valid Time range";
            $_SESSION["alert_code"] = "error";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/update.css">
    <link rel="stylesheet" href="../icons/css/all.min.css">
    <link rel="stylesheet" href="../fonts/fonts.css">

    <!-- JAVASCRIPT -->
    <script src="../icons/js/all.js" defer></script>
    <script src="../mdb/js/mdb.min.js" defer></script>
    <script src="../sweetalert/sweetalert2.all.js"></script>
    <script src="../js/index.js" defer></script>
    <title>Document</title>
</head>

<body>
    <header>
        <?php include "../includes/navbar.php"; ?>
    </header>

    <div class="container m-auto">
        <div class="appointment-form bg-light h-100 p-5">
            <div class="update-header">
                <p class="btn" onclick="close_update_for_schedule()">&times;</p>
                <h3>UPDATE SCHEDULE</h3>
            </div>
            <br><br>
            <form action="" method="post">
                <!-- SECTION -->
                <input type="hidden" id="class_id" name="class_id" class="form-control" value="<?= $class_id; ?>" required />
                <div class="input-sched p-0">
                    <label for="section">Section</label>
                    <select class="form-select mb-4" name="section_id" id="section" required>

                        <?php if ($list_of_section->num_rows > 0) : ?>
                            <?php while ($row_section = $list_of_section->fetch_assoc()) :  ?>

                                <option value="<?= $row_section["SECTION_ID"]; ?>" <?= ($section_id == $row_section["SECTION_ID"]) ? "selected" : ""; ?>><?= $row_section["SECTION"]; ?>
                                </option>

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

                        <?php if ($list_of_subject->num_rows > 0) : ?>
                            <?php while ($row = $list_of_subject->fetch_assoc()) :  ?>

                                <option value="<?= $row["SUBJECT_ID"]; ?>" <?= ($subject_id) == $row["SUBJECT_ID"] ? "selected" : ""; ?>><?= $row["SUBJECT_NAME"]; ?>
                                </option>

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

                        <option value="Monday" <?= ($day_of_week == "Monday") ? "selected" : ""; ?>>Monday</option>
                        <option value="Tuesday" <?= ($day_of_week == "Tuesday") ? "selected" : ""; ?>>Tuesday</option>
                        <option value="Wednesday" <?= ($day_of_week == "Wednesday") ? "selected" : ""; ?>>Wednesday</option>
                        <option value="Thursday" <?= ($day_of_week == "Thursday") ? "selected" : ""; ?>>Thursday</option>
                        <option value="Friday" <?= ($day_of_week == "Friday") ? "selected" : ""; ?>>Friday</option>

                    </select>
                </div>
                <!-- START AND END TIME -->
                <div class="row p-0 m-auto">
                    <div class="col p-0">
                        <label for="starttime">Start Time</label>
                        <div class="cs-form cs-form-start">
                            <input type="time" id="starttime" name="starttime" class="form-control" value="<?= $formatted_start_time; ?>" />
                        </div>
                    </div>
                    <div class="col p-0">
                        <label for="starttime">End Time</label>
                        <div class="cs-form cs-form-end">
                            <input type="time" id="endtime" name="endtime" class="form-control" value="<?= $formatted_end_time; ?>" />
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary btn-lg btn-block mb-4 mt-4" value="Save Schedule" name="save">
            </form>
        </div>
    </div>
    <?php include "../includes/footer.php"; ?>
</body>

</html>