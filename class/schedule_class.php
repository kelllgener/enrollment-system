<?php 

require_once "subject_class.php";

class ScheduleConfig extends SubjectConfig {

    public function display_schedule() {

        // get page number
		if(isset($_GET["page_no"]) && $_GET["page_no"] !== "") {
			$page_no = $_GET["page_no"];
		}
		else {
			$page_no = 1;
		}
		// total rows or records to display 
		$total_records_per_page = 10;
		// get the page offset for the LIMIT query 
		$offset = ($page_no - 1) *$total_records_per_page;

		$previous_page = $page_no - 1;
		$next_page = $page_no + 1;

		$result_count = mysqli_query($this->conn, "SELECT COUNT(*) AS total_records FROM vw_schedule") or die($this->conn);
		$records = mysqli_fetch_array($result_count);
		$total_records = $records["total_records"];
		$total_no_of_pages = ceil($total_records / $total_records_per_page);


        $sql = "SELECT * FROM vw_schedule  LIMIT $offset, $total_records_per_page";
        $result = $this->conn->query($sql);
        
        if (!$result) {
			die("Invalid Query: " . $this->getConnection()->connect_error);
		}

        $_SESSION['page_no'] = $page_no;
        $_SESSION['total_records_per_page'] = $total_records_per_page;
        $_SESSION['offset'] = $offset;

		$_SESSION['prev_page'] = $previous_page;
        $_SESSION['next_page'] = $next_page;
        $_SESSION['result_count'] = $result_count;
		$_SESSION['records'] = $records;
        $_SESSION['total_records'] = $total_records;
        $_SESSION['total_no_of_pages'] = $total_no_of_pages;

        
		return $result;

        $this->conn->close();
    }
	
    
    public function search_schedule() {

        $search = $_POST["txtSearch"];

        if(isset($_GET["page_no"]) && $_GET["page_no"] !== "") {
			$page_no = $_GET["page_no"];
		}
		else {
			$page_no = 1;
		}
		// total rows or records to display 
		$total_records_per_page = 10;
		// get the page offset for the LIMIT query 
		$offset = ($page_no - 1) *$total_records_per_page;

        $sql = "SELECT * from vw_schedule 
		where concat(CLASS_ID, SUBJECT_NAME, SUBJECT_CODE, START_TIME, END_TIME, SECTION)
		like '%$search%'
		LIMIT $offset, $total_records_per_page";

		$result = $this->getConnection()->query($sql);
	
		if (!$result) {
			die("Invalid Query: " . $this->getConnection()->connect_error);
		}
		return $result;
    }

	public function display_schedule_row_count() {
		$sql = "SELECT * from tbl_class";
		$result = mysqli_query($this->getConnection(), $sql);
	
		if ($total_row = mysqli_num_rows($result)) {
			echo $total_row;
		} else {
			echo " No data";
		}
		

	}

    public function select_section() {
        $sql = "SELECT * FROM tbl_section WHERE SECTION != 'Pending'";
        $result = $this->conn->query($sql);
        
        if (!$result) {
			die("Invalid Query: " . $this->getConnection()->connect_error);
		}
		return $result;

        $this->conn->close();
    }

    private function convertTo12HourFormat($time) {
        $dateTime = new DateTime($time);
        return $dateTime->format("h:i A");
    }

	function convertTo24HourFormat($time12Hour) {
		$dateTime = DateTime::createFromFormat('h:i A', $time12Hour);
		
		if ($dateTime === false) {
			// Invalid input format
			return false;
		}
	
		return $dateTime->format('H:i');
	}

	public function sqlValidation($week_of_day, $formatted_start_time, $formatted_end_time) {
		$sqlValidation = "SELECT * 
			FROM tbl_class 
			WHERE DAY_OF_WEEK = ? 
			AND 
			(
				(? BETWEEN START_TIME AND END_TIME - 1)
				OR 
				(? BETWEEN START_TIME AND END_TIME)
			)
		";
	
		$stmtValidation = $this->conn->prepare($sqlValidation);
		$stmtValidation->bind_param("sss", $week_of_day, $formatted_start_time, $formatted_end_time);
		$stmtValidation->execute();
		$resultValidation = $stmtValidation->get_result();
	
		if (mysqli_num_rows($resultValidation) > 0) {
			// Overlapping schedule exists
			return 1;
		} else {
			// No overlapping schedule
			return 0;
		}
	}

    public function add_schedule($section_id, $subject_id, $week_of_day, $start_time, $end_time) {

        // Convert 24-hour time to 12-hour format with AM/PM
        $formatted_start_time = $this->convertTo12HourFormat($start_time);
        $formatted_end_time = $this->convertTo12HourFormat($end_time);

		$validationResult = $this->sqlValidation($week_of_day, $formatted_start_time, $formatted_end_time);

		if ($validationResult !== 0) {
			// Validation failed
			return $validationResult;
		}

		$formatted_24_start_time = $this->convertTo24HourFormat($start_time); 
		$formatted_24_end_time = $this->convertTo24HourFormat($end_time); 

		if ($formatted_24_start_time < $formatted_24_end_time) {

			$sql_insert_schedule = "INSERT INTO tbl_class (SUBJECT_ID, DAY_OF_WEEK, START_TIME, END_TIME, SECTION_ID) VALUES (?, ?, ?, ?, ?)";
			$stmt_insert_schedule = $this->conn->prepare($sql_insert_schedule);
			$stmt_insert_schedule->bind_param("isssi", $subject_id, $week_of_day, $formatted_start_time, $formatted_end_time, $section_id);

			if ($stmt_insert_schedule->execute()) {
				// Schedule added successfully
				return 2;
			} else {
				// Failed to add schedule
				die("Invalid Query: " . $this->conn->connect_error);
			}
			$this->conn->close();

		}
		else {
			return 3;
		}
        
    }

    public function delete_schedule($class_ID) {

        $stmt = $this->conn->prepare("DELETE FROM tbl_class WHERE CLASS_ID = ?");
		$stmt->bind_param("i", $class_ID);
	
		if ($stmt->execute()) {
			$stmt->close();
			
			header("location: ../admin/schedule.php?delete_schedule_by_id=success");
			exit; 
			
		} else {
			echo "Error: " . $stmt->error;
		}
	
		$this->conn->close();
    }

    public function select_schedule_to_update($class_id) {

        $sqlSelect = "SELECT * FROM vw_schedule WHERE CLASS_ID = ?";
		$stmtSelect = $this->conn->prepare($sqlSelect);
		$stmtSelect->bind_param("i", $class_id);
		$stmtSelect->execute();
		$resultSelect = $stmtSelect->get_result();

		while ($rowSelect = $resultSelect->fetch_assoc()) {
			if(!$rowSelect) {
				header("location: ../admin/user_account.php");
				exit;
			}

			return $rowSelect;

		}
    }

	public function update_schedule($section_id, $subject_id, $week_of_day, $start_time, $end_time, $class_id) {

			$this->conn->begin_transaction();
			
			$sql_update_schedule = "UPDATE tbl_class SET SECTION_ID = ?, SUBJECT_ID = ?, DAY_OF_WEEK = ?, START_TIME = ?, END_TIME = ? WHERE CLASS_ID = ?";
			$stmt_update_schedule = $this->conn->prepare($sql_update_schedule);
			$stmt_update_schedule->bind_param("iisssi", $section_id, $subject_id, $week_of_day, $start_time, $end_time, $class_id);

			if (!$stmt_update_schedule->execute()) {
				// Rollback the transaction if info insertion fails
				$this->conn->rollback();
				return false;
			}

			// Commit the transaction after each role update
			$this->conn->commit();
			echo "success";
			return 2;

	}

	public function display_schedule_for_section_one() {
		$sql = "SELECT * from vw_section_one_schedule";

		$result = $this->getConnection()->query($sql);
	
		if (!$result) {
			die("Invalid Query: " . $this->getConnection()->connect_error);
		}
		
		return $result;
	}

	public function display_schedule_for_section_two() {
		$sql = "SELECT * from vw_section_two_schedule";
		$result = $this->getConnection()->query($sql);
	
		if (!$result) {
			die("Invalid Query: " . $this->getConnection()->connect_error);
		}

		return $result;
	}

	public function convert_to_csv_schedule() {

		$sql = "SELECT * FROM vw_schedule";
		$result = $this->getConnection()->query($sql);

		if ($result->num_rows > 0) {
		$delimiter = ",";
		$filename = "Class_Schedule_" . date('Y-m-d') . ".csv";

		$f = fopen('php://memory', 'w');

		//CLASS_ID, SUBJECT_NAME, SUBJECT_CODE, START_TIME, END_TIME, SECTION

		$fields = array('CLASS_ID', 'SUBJECT_NAME', 'SUBJECT_CODE', 'START_TIME', 'END_TIME', 'SECTION');
		fputcsv($f, $fields, $delimiter);

		while ($row = $result->fetch_assoc()) {
			$lineData = array($row['CLASS_ID'], $row['SUBJECT_NAME'], $row['SUBJECT_CODE'], $row['START_TIME'], $row['END_TIME'], $row['SECTION']);
			fputcsv($f, $lineData, $delimiter);
		}

		fseek($f, 0);

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename ="' . $filename . '";');

		fpassthru($f);
		}
		exit;
	}	

}

?>