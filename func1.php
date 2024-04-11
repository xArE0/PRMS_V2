<?php
	session_start();
	$con = mysqli_connect("localhost", "root", "", "prms_db");

	if (isset($_POST['docsub1'])) {
		$dname = $_POST['username3'];
		$dpass = $_POST['password3'];

		$query = "SELECT * FROM prms_db.doctb WHERE username=? AND password=? AND working_status=1";
		$stmt = mysqli_prepare($con, $query);
		mysqli_stmt_bind_param($stmt, "ss", $dname, $dpass);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$_SESSION['dname'] = $row['username'];
			$_SESSION['docid'] = $row['docid'];
			header("Location: ./Doctor_Side/doctor-panel1.php");
			exit();
		} else {
			echo "<script>alert('Invalid Username or Password. Try Again!'); window.location.href = 'index.php';</script>";
			exit();
		}
	}
?>
