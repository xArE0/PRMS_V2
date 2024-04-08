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
                <!-- User Photo -->
            </div>
            <div class="col">
                <p><strong>Patient ID:</strong> ' . $row['pid'] . '</p>
                <p><strong>First Name:</strong> ' . $row['fname'] . '</p>
                <p><strong>Last Name:</strong> ' . $row['lname'] . '</p>
                <p><strong>Gender:</strong> ' . $row['gender'] . '</p>
                <p><strong>Email:</strong> ' . $row['email'] . '</p>
            </div>
        </div>

        <div class="row">
            <!-- Table that contains user all prescription by that doctor -->
            do
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