<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "prms_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
        // Get image data
        $imageData = addslashes(file_get_contents($_FILES["fileToUpload"]["tmp_name"]));

        // Update picture for pid = 15
        $pid = 11;
        $sql = "UPDATE patreg SET picture = '$imageData' WHERE pid = $pid";

        // Execute query
        if (mysqli_query($conn, $sql)) {
            // Fetch the updated image data
            $sql = "SELECT picture FROM patreg WHERE pid = $pid";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $imageData = $row['picture'];
                // Display the uploaded image immediately after upload
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" alt="Uploaded Image" />';
            } else {
                echo "Error retrieving image.";
            }
        } else {
            echo "Error uploading image: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading image.";
    }
}

// Close connection
mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../vendor/fontawesome/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
</head>


<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
               <img src="./images/user1.png" alt="">
            </div>
            <div class="col">
                <p><strong>Patient ID:</strong></p>
                <p><strong>First Name:</strong></p>
                <p><strong>Last Name:</strong></p>
                <p><strong>Gender:</strong></p>
                <p><strong>Email:</strong></p>
            </div>
        </div>

        <div class="row">
            <!-- Table that contains user all prescription by that doctor -->
            <form action="test.php" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload Image" name="submit">
            </form>
        </div>
    </div>


    <style>
        .row,
        .col {
            border: 3px solid black;
            padding: 3px;
        }
    </style>
</body>

</html>