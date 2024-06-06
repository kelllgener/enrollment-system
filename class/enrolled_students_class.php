<?php 

require_once "schedule_class.php";

class EnrolledStudentsConfig extends ScheduleConfig {

    public function display_enrolled_students() {

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

		$result_count = mysqli_query($this->conn, "SELECT COUNT(*) AS total_records FROM vw_enrolled_students") or die($this->conn);
		$records = mysqli_fetch_array($result_count);
		$total_records = $records["total_records"];
		$total_no_of_pages = ceil($total_records / $total_records_per_page);

        $sql = "SELECT  * FROM vw_enrolled_students LIMIT $offset, $total_records_per_page";
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


    public function search_enrolled_students() {

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
	
		$sql = "SELECT * from vw_enrolled_students 
		where concat(STUDENT_ID, FIRSTNAME, LASTNAME, MIDDLENAME, SEX, AGE, ADDRESS, CONTACT_NO, STATUS)
		like '%$search%'
		LIMIT $offset, $total_records_per_page";

		$result = $this->getConnection()->query($sql);
	
		if (!$result) {
			die("Invalid Query: " . $this->getConnection()->connect_error);
		}
		return $result;

		
	}

	public function display_enrolled_student_row_count() {
		$sql = "SELECT * from vw_student_info WHERE STATUS = 'Enrolled'";
		$result = mysqli_query($this->getConnection(), $sql);
	
		if ($total_row = mysqli_num_rows($result)) {
			echo $total_row;
		} else {
			echo " No data";
		}


	}

	public function display_dropped_student_row_count() {
		$sql = "SELECT * from vw_student_info WHERE STATUS = 'Dropped'";
		$result = mysqli_query($this->getConnection(), $sql);
	
		if ($total_row = mysqli_num_rows($result)) {
			echo $total_row;
		} else {
			echo " No data";
		}


	}

	public function display_section_one_student() {
		// Fetch products from the database
		$sql = "SELECT * FROM vw_section_one";
		$result = $this->conn->query($sql);

		return $result;
	}

	public function display_section_two_student() {
		// Fetch products from the database
		$sql = "SELECT * FROM vw_section_two";
		$result = $this->conn->query($sql);

		return $result;
	}

	public function convert_to_csv_enrolled_student() {

		$sql = "SELECT * FROM vw_enrolled_students";
		$result = $this->getConnection()->query($sql);

		if ($result->num_rows > 0) {
		$delimiter = ",";
		$filename = "Enrolled_Students_" . date('Y-m-d') . ".csv";

		$f = fopen('php://memory', 'w');

		//CLASS_ID, SUBJECT_NAME, SUBJECT_CODE, START_TIME, END_TIME, SECTION

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