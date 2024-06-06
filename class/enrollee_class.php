<?php 

require_once "user_account_class.php";

class EnrolleConfig extends UserAccount {


    public function display_new_enrollees() {
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

		$result_count = mysqli_query($this->conn, "SELECT COUNT(*) AS total_records FROM vw_student_info_1") or die($this->conn);
		$records = mysqli_fetch_array($result_count);
		$total_records = $records["total_records"];
		$total_no_of_pages = ceil($total_records / $total_records_per_page);

        $sql = "SELECT  * FROM vw_student_info_1 ORDER BY CASE WHEN STATUS = 'Pending' THEN 1 WHEN STATUS = 'Enrolled' THEN 2 ELSE 3 END, STATUS LIMIT $offset, $total_records_per_page";
		$result = $this->getConnection()->query($sql);
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
    }

    public function search_new_enrollees() {

		$search = $_POST["txtSearch"];
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
	
		$sql = "SELECT * from vw_student_info_1 
		where concat(STUDENT_ID, FIRSTNAME, LASTNAME, MIDDLENAME, SEX, AGE, ADDRESS, CONTACT_NO, STATUS)
		like '%$search%'
		LIMIT $offset, $total_records_per_page";

		$result = $this->getConnection()->query($sql);
	
		if (!$result) {
			die("Invalid Query: " . $this->getConnection()->connect_error);
		}
		return $result;

		
	}

	public function display_new_enrollees_row_count() {
		
		$sql = "SELECT * from vw_new_enrollees";
		$result = mysqli_query($this->getConnection(), $sql);
	
		if ($total_row = mysqli_num_rows($result)) {
			echo $total_row;
		} else {
			echo " No data";
		}

	}

    public function select_from_student() {

        $user_ID = $_SESSION["user_ID"];

        $sql = "SELECT * FROM vw_new_enrollees WHERE USER_ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row;

    }

    public function display_my_profile() {

        $user_ID = $_SESSION["user_ID"];

        $sql = "SELECT * FROM vw_student_info WHERE USER_ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row;

    }

	public function drop_student($student_id) {
		$status_id = 303;
        $sql = "UPDATE tbl_student_info SET STATUS_ID = ? WHERE USER_ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status_id, $student_id);

        if ($stmt->execute()) {

            header("location: ../admin/enrolled_students.php?drop_student_by_id=success");
            exit;
        }
        else {
            echo "ERROR: " . $stmt->error;
        }

        $this->conn->close();
    }

	public function review_student($student_ID) {
        $student_ID = $_GET["REVIEW_BY_STUDENT_ID"];

        $sql = "SELECT * FROM vw_student_info WHERE STUDENT_ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $student_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row;

    }

	public function approve_student($lrn) {
		
		$this->conn->begin_transaction();
		
		// Fetch student ID from the request (ensure it's sanitized)
		$student_ID = $_GET["REVIEW_BY_STUDENT_ID"];
	
		// Fetch the number of students in each section, excluding "pending"
		$section_counts = [];
		$sections_query = "SELECT SECTION_ID, COUNT(*) AS student_count FROM tbl_student_info WHERE SECTION_ID IN (1, 2) GROUP BY SECTION_ID";
		$sections_result = $this->conn->query($sections_query);
		if ($sections_result->num_rows > 0) {
			while ($row = $sections_result->fetch_assoc()) {
				$section_counts[$row['SECTION_ID']] = $row['student_count'];
			}
		}
	
		// Check if there are at least 1 student in both section 1 and section 2
		if (isset($section_counts[1]) && isset($section_counts[2])) {
			// Find the section with the fewest students
			$min_student_count = min($section_counts);
			$min_student_section = array_search($min_student_count, $section_counts);
		} else {
			// No students in at least one section, assign to a default section
			$default_section = mt_rand(1, 2); // Randomly choose 1 or 2
			$min_student_section = $default_section;
		}
	
		// Update the student's section in the database
		$status_id = 302; // Assuming this is a predefined status ID
		$approve_query = "UPDATE tbl_student_info SET LRN = ?, STATUS_ID = ?, SECTION_ID = ? WHERE STUDENT_ID = ?";
		$stmt = $this->conn->prepare($approve_query);
		$stmt->bind_param("iiii", $lrn, $status_id, $min_student_section, $student_ID);
		
		if (!$stmt->execute()) {
			// Handle update failure
			echo "Error updating student section: " . $stmt->error;
			$this->conn->rollback();
			return false;
		} 
	
		// Commit the transaction if everything succeeded
		$this->conn->commit();
		return true;
	}

	public function convert_to_csv_enrollees() {

		$sql = "SELECT * FROM vw_student_info";
		$result = $this->getConnection()->query($sql);

		if ($result->num_rows > 0) {
		$delimiter = ",";
		$filename = "List_of_Students_" . date('Y-m-d') . ".csv";

		$f = fopen('php://memory', 'w');

		// STUDENT_ID, FIRSTNAME, LASTNAME, MIDDLENAME, SEX, AGE, ADDRESS, CONTACT_NO, STATUS

		$fields = array('STUDENT_ID', 'FIRSTNAME', 'LASTNAME', 'MIDDLENAME', 'SEX', 'AGE', 'ADDRESS', 'CONTACT_NO', 'STATUS');
		fputcsv($f, $fields, $delimiter);

		while ($row = $result->fetch_assoc()) {
			$lineData = array($row['STUDENT_ID'], $row['FIRSTNAME'], $row['LASTNAME'], $row['MIDDLENAME'], $row['SEX'], $row['AGE'], $row['ADDRESS'], $row['CONTACT_NO'], $row['STATUS']);
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