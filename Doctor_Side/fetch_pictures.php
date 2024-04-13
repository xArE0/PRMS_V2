<?php
include('../func1.php');

if (isset($_POST['appointmentID'])) {
    $appointmentID = $_POST['appointmentID'];

    // Query the image table to fetch pictures associated with the given appointment ID
    $query = "SELECT picture FROM image WHERE ID = $appointmentID";
    $result = mysqli_query($con, $query);

    $pictures = array();

    // Fetch each picture and store them in an array
    while ($row = mysqli_fetch_assoc($result)) {
        $pictures[] = base64_encode($row['picture']);
    }

    // Return the array of base64-encoded images as JSON
    echo json_encode($pictures);
} else {
    echo "Error: No appointment ID provided";
}

mysqli_close($con);
?>