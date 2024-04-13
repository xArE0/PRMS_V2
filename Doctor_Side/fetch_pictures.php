<?php
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "prms_db");

// Check if the POST request contains the appointmentID parameter
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointmentID'])) {
    $appointmentID = $_POST['appointmentID'];

    // Query to fetch images for the appointment
    $query_images = "SELECT picture FROM image WHERE ID = $appointmentID";
    $result_images = mysqli_query($con, $query_images);

    if ($result_images) {
        // Array to store the base64-encoded images
        $image_data = array();

        while ($row_image = mysqli_fetch_assoc($result_images)) {
            // Add each image to the array
            $image_data[] = $row_image['picture'];
        }

        // Return the array as JSON response
        echo json_encode($image_data);
    } else {
        // If there are no images, return an empty array
        echo json_encode(array());
    }
} else {
    // If the request is invalid, return an error message
    echo "Invalid request!";
}
?>