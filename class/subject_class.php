<?php 

require_once "enrollee_class.php";

class SubjectConfig extends EnrolleConfig {

    public function display_subjects() {
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

        $result_count = mysqli_query($this->conn, "SELECT COUNT(*) AS total_records FROM tbl_subjects") or die($this->conn);
		$records = mysqli_fetch_array($result_count);
		$total_records = $records["total_records"];
		$total_no_of_pages = ceil($total_records / $total_records_per_page);

        $sql = "SELECT  * FROM tbl_subjects LIMIT $offset, $total_records_per_page";
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

    public function search_subject() {

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
	
		$sql = "SELECT * from tbl_subjects 
		where concat(SUBJECT_ID, SUBJECT_NAME, SUBJECT_CODE)
		like '%$search%'
		LIMIT $offset, $total_records_per_page";

		$result = $this->getConnection()->query($sql);
	
		if (!$result) {
			die("Invalid Query: " . $this->getConnection()->connect_error);
		}
		return $result;

		
	}

    function display_subject_row_count() {
		$sql = "SELECT * from tbl_subjects";
		$result = mysqli_query($this->getConnection(), $sql);
	
		if ($total_row = mysqli_num_rows($result)) {
			echo $total_row;
		} else {
			echo " No data";
		}

        $this->conn->close();
	}

    public function add_subject($subject_name, $subject_code) {
        $sql = "INSERT INTO tbl_subjects (SUBJECT_NAME, SUBJECT_CODE) VALUES (?,?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $subject_name, $subject_code);

        if (!$stmt->execute()) {
            die("Invalid Query: " . $this->getConnection()->connect_error);
        }

        
        return 1;
        $this->conn->close();
    }

    public function delete_subject($subject_id) {
        $sql = "DELETE FROM tbl_subjects WHERE SUBJECT_ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $subject_id);

        if ($stmt->execute()) {
            $stmt->close();

            header("location: ../admin/subject.php?delete_subject_by_id=success");
            exit;
        }
        else {
            echo "ERROR: " . $stmt->error;
        }

        $this->conn->close();
    }

    public function select_subject_to_update($subject_id) {

        $sqlSelect = "SELECT * FROM tbl_subjectS WHERE SUBJECT_ID = ?";
		$stmtSelect = $this->conn->prepare($sqlSelect);
		$stmtSelect->bind_param("i", $subject_id);
		$stmtSelect->execute();
		$resultSelect = $stmtSelect->get_result();

		while ($rowSelect =$resultSelect->fetch_assoc()) {
			if(!$rowSelect) {
				header("location: ../admin/user_account.php");
				exit;
			}

			return $rowSelect;

		}
    }

    public function update_subject($subject_name, $subject_code, $subject_id) {
        $this->conn->begin_transaction();

        $sqlUpate = "UPDATE tbl_subjects SET SUBJECT_NAME = ?, SUBJECT_CODE = ? WHERE SUBJECT_ID = ?";
		$stmt_update_subject = $this->conn->prepare($sqlUpate);
		$stmt_update_subject->bind_param("ssi", $subject_name, $subject_code, $subject_id);

        if (!$stmt_update_subject->execute()) {
            // Rollback the transaction if info insertion fails
            $this->conn->rollback();
            return false;
        }

        // Commit the transaction after each role update
        $this->conn->commit();
        return 1;

    }

	public function convert_to_csv_subjects() {

		$sql = "SELECT * FROM tbl_subjects";
		$result = $this->getConnection()->query($sql);

		if ($result->num_rows > 0) {
		$delimiter = ",";
		$filename = "List_of_Subjects_" . date('Y-m-d') . ".csv";

		$f = fopen('php://memory', 'w');

		$fields = array('SUBJECT_ID', 'SUBJECT_NAME', 'SUBJECT_CODE');
		fputcsv($f, $fields, $delimiter);

		while ($row = $result->fetch_assoc()) {
			$lineData = array($row['SUBJECT_ID'], $row['SUBJECT_NAME'], $row['SUBJECT_CODE']);
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