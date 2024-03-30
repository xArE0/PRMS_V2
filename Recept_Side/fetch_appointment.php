<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "prms_db");

// Check if it's a POST request and if appointmentID is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointmentID'])) {
    $appointmentID = mysqli_real_escape_string($con, $_POST['appointmentID']);
    // Query to fetch appointment details
    $query = "SELECT pid, spec, doctor, docFees, appdate, apptime FROM appointmenttb join doctb on doctb.username=appointmenttb.doctor WHERE id = '$appointmentID'";
    $result = mysqli_query($con, $query);

    if ($result) {
        // Fetch the appointment details
        $appointmentData = mysqli_fetch_assoc($result);

        // Echo each value retrieved from the database
        echo "PID: " . $appointmentData['pid'] . "<br>";
        echo "Specialization: " . $appointmentData['spec'] . "<br>";
        echo "Doctor: " . $appointmentData['doctor'] . "<br>";
        echo "Consultancy Fees: " . $appointmentData['docFees'] . "<br>";
        echo "Appointment Date: " . $appointmentData['appdate'] . "<br>";
        echo "Appointment Time: " . $appointmentData['apptime'] . "<br>";
    } else {
        // If query execution fails, return an error message
        echo json_encode(array('error' => 'Failed to fetch appointment details.'));
    }
} else {
    // If it's not a valid POST request or appointmentID is not set, return an error message
    echo json_encode(array('error' => 'Invalid request.'));
}
