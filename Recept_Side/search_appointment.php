<?php
if (isset($_POST['appointmentID'])) {
    $con = mysqli_connect("localhost", "root", "", "prms_db");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $appointmentID = mysqli_real_escape_string($con, $_POST['appointmentID']);

    $query = "SELECT * FROM prms_db.appointmenttb AS A JOIN prms_db.doctb AS D ON A.doctor=D. username WHERE ID = '$appointmentID'";

    $result = mysqli_query($con, $query);

    if ($result) {
        // Check if appointment data exists
        if (mysqli_num_rows($result) > 0) {
            // Fetch appointment data
            $appointmentData = mysqli_fetch_assoc($result);

            // Return appointment data as JSON
            echo json_encode($appointmentData);
        } else {
            // No appointment found with the given ID
            echo json_encode(['error' => 'Appointment not found']);
        }
    } else {
        // Error executing the query
        echo json_encode(['error' => 'Error executing query']);
    }

    // Close database connection
    mysqli_close($con);
} else {
    // No appointmentID provided in the POST request
    echo json_encode(['error' => 'No appointmentID provided']);
}
?>