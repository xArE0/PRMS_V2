<?php
$con=mysqli_connect("localhost","root","","prms_db");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["find"])) {
    $app_id = filter_input(INPUT_POST, "appointmentId", FILTER_SANITIZE_SPECIAL_CHARS);
    $checkQuery = "SELECT * FROM appointmenttb WHERE ID = '$app_id'";
    $result = mysqli_query($con, $checkQuery);
    $row = mysqli_fetch_assoc($result);
    $hisname = isset($row['fname']) ? $row['fname'] : ''; 

    if (!$result) {
        echo "Error in query: " . mysqli_error($con);
    } 
    elseif (mysqli_num_rows($result) > 0)
    {
        echo $hisname;
    }
    else
    {
        echo "Not found";
    }           

    mysqli_close($con);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
</head>
<body>
        <label for="appointmentId">AppointmentId</label>
        <input type="text" id="appointmentId" name="appointmentId"> 
        <br><br>
        <label for="patientId">Name</label>
        <input type="text" id="patientId" name="patientId">    
    
        <button type="button" onclick="populateNameField()">Go</button>

    <script>
    function populateNameField() {
        var app_id = document.getElementById("appointmentId").value;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "test.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("patientId").value = xhr.responseText;
            }
        };
        xhr.send("find=&appointmentId=" + encodeURIComponent(app_id));
    }
    </script>
</body>
</html>
