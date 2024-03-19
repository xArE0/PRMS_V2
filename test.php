<?php
    $con = mysqli_connect("localhost", "root", "", "prms_db");   

    // Get the appointment ID from the request
    $appointmentID = $_POST['appointmentID'];

    $sql = "SELECT * FROM appointmenttb WHERE ID = $appointmentID";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // Fetch appointment data
        $row = $result->fetch_assoc();
        // Return appointment data as JSON
        echo json_encode($row);
    } else {
        echo "0 results";
    }
    $con->close();
?>