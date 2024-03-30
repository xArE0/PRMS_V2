<!DOCTYPE html>
<?php
$con = mysqli_connect("localhost", "root", "", "prms_db");

include('newfunc.php');

// Add new doctor
if (isset($_POST['docsub'])) {
  $doctor = $_POST['doctor'];
  $dpassword = $_POST['dpassword'];
  $demail = $_POST['demail'];
  $spec = $_POST['special'];
  $docFees = $_POST['docFees'];
  $query = "insert into doctb(username,password,email,spec,docFees)values('$doctor','$dpassword','$demail','$spec','$docFees')";
  $result = mysqli_query($con, $query);
  if ($result) {
    echo "<script>alert('Doctor added successfully!');</script>";
  }
}

// Delete a doctor
if (isset($_POST['docsub1'])) {
  $demail = $_POST['demail'];
  $query = "delete from doctb where email='$demail';";
  $result = mysqli_query($con, $query);
  if ($result) {
    echo "<script>alert('Doctor removed successfully!');</script>";
  } else {
    echo "<script>alert('Unable to delete!');</script>";
  }
}
?>

<!-- Code for creating and updating new entries in manage appointment section of sidebar -->
<?php
$con = mysqli_connect("localhost", "root", "", "prms_db");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["app-submit"])) {
  $appointmentID = $_POST["appointmentID"];
  $patientID = $_POST["patientID"];
  $spec = $_POST["spec"];
  $doctor = $_POST["doctor"];
  $docFees = $_POST["docFees"];
  $appdate = $_POST["appdate"];
  $apptime = $_POST["apptime"];

  // Fetch patient data based on patientID
  $patient_query = mysqli_query($con, "SELECT * FROM patreg WHERE pid = '$patientID'");
  $patient_data = mysqli_fetch_assoc($patient_query);

  // Checking if patient data is found
  if ($patient_data) {
    $_SESSION['pid'] = $patient_data['pid'];
    $_SESSION['email'] = $patient_data['email'];
    $_SESSION['fname'] = $patient_data['fname'];
    $_SESSION['lname'] = $patient_data['lname'];
    $_SESSION['gender'] = $patient_data['gender'];
    $_SESSION['contact'] = $patient_data['contact'];

    // Insert appointment data into the database
    $sqlcmd = "INSERT INTO appointmenttb(pid, fname, lname, gender, email, contact, doctor, docFees, appdate, apptime, userStatus, doctorStatus) 
                   VALUES ('{$_SESSION['pid']}', '{$_SESSION['fname']}', '{$_SESSION['lname']}', '{$_SESSION['gender']}', '{$_SESSION['email']}', '{$_SESSION['contact']}', '$doctor', '$docFees', '$appdate', '$apptime', '1', '1')";

    $query = mysqli_query($con, $sqlcmd);

    if ($query) {
      // Redirect to a different page to prevent form resubmission
      header("Location: admin-panel1.php");
      exit(); // Stop further execution
    } else {
      echo "<script>alert('Unable to process your request. Please try again!');</script>";
    }
  } else {
    echo "<script>alert('Patient data not found. Please check the patient ID!');</script>";
  }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_entry"])) {
  $appointmentID = $_POST["appointmentID"];
  $patientID = $_POST["patientID"];
  $spec = $_POST["spec"];
  $doctor = $_POST["doctor"];
  $docFees = $_POST["docFees"];
  $appdate = $_POST["appdate"];
  $apptime = $_POST["apptime"];

  $sqlcmd = "UPDATE appointmenttb 
              SET doctor = '$doctor', docFees = '$docFees', appdate = '$appdate', apptime = '$apptime' 
              WHERE ID = '$appointmentID' AND pid = '$patientID'";

  $query = mysqli_query($con, $sqlcmd);

  if ($query) {
    echo "<script>alert('Appointment details successfully updated');</script>";
    header("Location: admin-panel1.php");
    exit();
  } else {
    echo "<script>alert('Failed to update appointment details. Please try again!');</script>";
  }
}
?>


<!-- Code to Approve Mechanism in Appointment Details Section of Sidebar -->
<?php
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "prms_db");
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointmentID'])) {
  // Sanitizing the input to prevent SQL injection
  $appointmentID = mysqli_real_escape_string($con, $_POST['appointmentID']);

  // Update the appointment status in the database
  $update_query = "UPDATE appointmenttb SET approve_status = 1 WHERE ID = '$appointmentID'";
  mysqli_query($con, $update_query);
  mysqli_close($con);
}
?>

<html lang="en">

<head>
  <title>Admin - Dashboard</title>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../vendor/fontawesome/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Patient Record Management System </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <script>
      var check = function() {
        if (document.getElementById('dpassword').value ==
          document.getElementById('cdpassword').value) {
          document.getElementById('message').style.color = '#5dd05d';
          document.getElementById('message').innerHTML = 'Matched';
        } else {
          document.getElementById('message').style.color = '#f55252';
          document.getElementById('message').innerHTML = 'Not Matching';
        }
      }

      function alphaOnly(event) {
        var key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8 || key == 32);
      };
    </script>

    <style>
      .bg-primary {
        background: -webkit-linear-gradient(left, #177F9C, #90EDDB);
      }

      .col-md-4 {
        max-width: 20% !important;
      }

      .list-group-item.active {
        z-index: 2;
        color: #fff;
        background-color: #342ac1;
        border-color: #007bff;
      }

      .text-primary {
        color: #342ac1 !important;
      }

      #cpass {
        display: -webkit-box;
      }

      #list-app {
        font-size: 15px;
      }

      .btn-primary {
        background-color: #3c50c1;
        border-color: #3c50c1;
      }
    </style>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"></a>
        </li>
      </ul>
    </div>
  </nav>
</head>
<style type="text/css">
  button:hover {
    cursor: pointer;
  }

  #inputbtn:hover {
    cursor: pointer;
  }
</style>

<body style="padding-top:50px;">
  <div class="container-fluid" style="margin-top:50px;">
    <h3 style="margin-left: 40%; padding-bottom: 20px;font-family: 'IBM Plex Sans', sans-serif;"> WELCOME RECEPTIONIST </h3>
    <div class="row">
      <div class="col-md-4" style="max-width:25%;margin-top: 3%;">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
          <a class="list-group-item list-group-item-action" href="#list-doc" id="list-doc-list" role="tab" aria-controls="home" data-toggle="list">Doctor List</a>
          <a class="list-group-item list-group-item-action" href="#list-pat" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">Patient List</a>
          <a class="list-group-item list-group-item-action" href="#list-app-manage" id="list-app-manage-list" role="tab" data-toggle="list" aria-controls="home">Manage Appointments</a>
          <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list" role="tab" data-toggle="list" aria-controls="home">Appointment Details</a>
          <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">Prescription List</a>
          <a class="list-group-item list-group-item-action" href="#list-settings" id="list-adoc-list" role="tab" data-toggle="list" aria-controls="home">Add Doctor</a>
          <a class="list-group-item list-group-item-action" href="#list-settings1" id="list-ddoc-list" role="tab" data-toggle="list" aria-controls="home">Delete Doctor</a>
          <a class="list-group-item list-group-item-action" href="#list-mes" id="list-mes-list" role="tab" data-toggle="list" aria-controls="home">Queries</a>

        </div><br>
      </div>

      <div class="col-md-8" style="margin-top: 3%;">
        <div class="tab-content" id="nav-tabContent" style="width: 950px;">
          <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
            <div class="container-fluid container-fullw bg-white">
              <div class="row">
                <div class="col-sm-4">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-users fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Doctor List</h4>

                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script>

                      <p class="links cl-effect-1">
                        <a href="#list-doc" onclick="clickDiv('#list-doc-list')">
                          View Doctors
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: -3%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-users fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Patient List</h4>

                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-pat-list')">
                          View Patients
                        </a>
                      </p>
                    </div>
                  </div>
                </div>


                <div class="col-sm-4">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Appointment Details</h4>

                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-app-list')">
                          View Appointments
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
              </div>



              <div class="row">
                <div class="col-sm-4" style="left: 13%;margin-top: 5%;">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Prescription List</h4>

                      <p class="cl-effect-1">
                        <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                          View Prescriptions
                        </a>
                      </p>
                    </div>
                  </div>
                </div>


                <div class="col-sm-4" style="left: 18%;margin-top: 5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-plus fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Manage Doctors</h4>

                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-adoc-list')">Add Doctors</a>
                        &nbsp|
                        <a href="#app-hist" onclick="clickDiv('#list-ddoc-list')">
                          Delete Doctors
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="list-doc" role="tabpanel" aria-labelledby="list-home-list">

            <div class="col-md-8">
              <form class="form-group" action="doctorsearch.php" method="post">
                <div class="row">
                  <div class="col-md-10"><input type="text" name="doctor_contact" placeholder="Enter Email ID" class="form-control"></div>
                  <div class="col-md-2"><input type="submit" name="doctor_search_submit" class="btn btn-primary" value="Search"></div>
                </div>
              </form>
            </div>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Doctor Name</th>
                  <th scope="col">Specialization</th>
                  <th scope="col">Email</th>
                  <th scope="col">Password</th>
                  <th scope="col">Fees</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $con = mysqli_connect("localhost", "root", "", "prms_db");
                global $con;
                $query = "select * from doctb";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                  $username = $row['username'];
                  $spec = $row['spec'];
                  $email = $row['email'];
                  $password = $row['password'];
                  $docFees = $row['docFees'];

                  echo "<tr>
                        <td>$username</td>
                        <td>$spec</td>
                        <td>$email</td>
                        <td>$password</td>
                        <td>$docFees</td>
                      </tr>";
                }
                ?>
              </tbody>
            </table>
            <br>
          </div>


          <div class="tab-pane fade" id="list-pat" role="tabpanel" aria-labelledby="list-pat-list">
            <div class="col-md-8">
              <form class="form-group" action="patientsearch.php" method="post">
                <div class="row">
                  <div class="col-md-10"><input type="text" name="patient_contact" placeholder="Enter Contact" class="form-control" required></div>
                  <div class="col-md-2"><input type="submit" name="patient_search_submit" class="btn btn-info" value="Search"></div>
                </div>
              </form>
            </div>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Patient ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Gender</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact</th>
                  <th scope="col">Password</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $con = mysqli_connect("localhost", "root", "", "prms_db");
                global $con;
                $query = "select * from patreg";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                  $pid = $row['pid'];
                  $fname = $row['fname'];
                  $lname = $row['lname'];
                  $gender = $row['gender'];
                  $email = $row['email'];
                  $contact = $row['contact'];
                  $password = $row['password'];

                  echo "<tr>
                        <td>$pid</td>
                        <td>$fname</td>
                        <td>$lname</td>
                        <td>$gender</td>
                        <td>$email</td>
                        <td>$contact</td>
                        <td>$password</td>
                      </tr>";
                }

                ?>
              </tbody>
            </table>
            <br>
          </div>


          <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
            <div class="col-md-8">
              <div class="row">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Doctor</th>
                      <th scope="col">Patient ID</th>
                      <th scope="col">Appointment ID</th>
                      <th scope="col">First Name</th>
                      <th scope="col">Last Name</th>
                      <th scope="col">Appointment Date</th>
                      <th scope="col">Appointment Time</th>
                      <th scope="col">Disease</th>
                      <th scope="col">Allergy</th>
                      <th scope="col">Prescription</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $con = mysqli_connect("localhost", "root", "", "prms_db");
                    global $con;
                    $query = "select * from prestb";
                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_array($result)) {
                      $doctor = $row['doctor'];
                      $pid = $row['pid'];
                      $ID = $row['ID'];
                      $fname = $row['fname'];
                      $lname = $row['lname'];
                      $appdate = $row['appdate'];
                      $apptime = $row['apptime'];
                      $disease = $row['disease'];
                      $allergy = $row['allergy'];
                      $pres = $row['prescription'];


                      echo "<tr>
                        <td>$doctor</td>
                        <td>$pid</td>
                        <td>$ID</td>
                        <td>$fname</td>
                        <td>$lname</td>
                        <td>$appdate</td>
                        <td>$apptime</td>
                        <td>$disease</td>
                        <td>$allergy</td>
                        <td>$pres</td>
                      </tr>";
                    }

                    ?>
                  </tbody>
                </table>
                <br>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="list-app" role="tabpanel" aria-labelledby="list-pat-list">
            <div class="col-md-8">
              <form class="form-group" action="appsearch.php" method="post">
                <div class="row">
                  <div class="col-md-10"><input type="text" name="app_contact" placeholder="Enter Contact" class="form-control"></div>
                  <div class="col-md-2"><input type="submit" name="app_search_submit" class="btn btn-primary" value="Search"></div>
                </div>
              </form>
            </div>

            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Appointment ID</th>
                  <th scope="col">Patient ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Gender</th>
                  <th scope="col">Contact</th>
                  <th scope="col">Doctor Name</th>
                  <th scope="col">Consultancy Fees</th>
                  <th scope="col">Appointment Date</th>
                  <th scope="col">Appointment Time</th>
                  <th scope="col">Appointment Status</th>
                  <th scope="col">Modify Appointment</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $con = mysqli_connect("localhost", "root", "", "prms_db");
                global $con;

                $query = "select * from appointmenttb;";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                  <tr>
                    <td><?php echo $row['ID']; ?></td>
                    <td><?php echo $row['pid']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['lname']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td><?php echo $row['doctor']; ?></td>
                    <td><?php echo $row['docFees']; ?></td>
                    <td><?php echo $row['appdate']; ?></td>
                    <td><?php echo $row['apptime']; ?></td>
                    <td>
                      <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) {
                        echo "Active";
                      }
                      if (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) {
                        echo "Cancelled by Patient";
                      }
                      if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) {
                        echo "Cancelled by Doctor";
                      }
                      ?>
                    </td>

                    <td>
                      <!-- Approve button -->
                      <?php if ($row['approve_status'] == 0) { ?>
                        <button id="approveBtn_<?php echo $row['ID']; ?>" class="btn btn-success" onclick="approveAppointment('<?php echo $row['ID']; ?>')">A</button>
                      <?php } else { ?>
                        <!-- Disable the button if appointment is already approved -->
                        <button class="btn btn-secondary" disabled>D</button>
                      <?php } ?>
                      <!-- Update button -->
                      <!-- "U" button with onclick event -->
                      <button class="btn btn-info" onclick="updateAppointment('<?php echo $row['ID']; ?>','<?php echo $row['pid']; ?>','<?php echo $row['fname']; ?>','<?php echo $row['lname']; ?>','<?php echo $row['gender']; ?>','<?php echo $row['contact']; ?>','<?php echo $row['doctor']; ?>','<?php echo $row['docFees']; ?>','<?php echo $row['appdate']; ?>','<?php echo $row['apptime']; ?>')">U</button>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
            <br>
          </div>        

          <!-- Script to change the Buttons from Aprrove to Approved -->
          <script>
            // Function to handle approve button click
            function approveAppointment(appointmentID) {
              // Disable the button to prevent multiple clicks
              document.getElementById('approveBtn_' + appointmentID).disabled = true;

              // Send an AJAX request to update the database
              var xhr = new XMLHttpRequest();
              xhr.open("POST", "admin-panel1.php", true);
              xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
              xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                  // Update button appearance and status on success
                  document.getElementById('approveBtn_' + appointmentID).innerText = 'D';
                  document.getElementById('approveBtn_' + appointmentID).classList.remove('btn-success');
                  document.getElementById('approveBtn_' + appointmentID).classList.add('btn-secondary');
                }
              };
              xhr.send("appointmentID=" + appointmentID);
            }
          </script>

          <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>

          <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
            <form class="form-group" method="post" action="admin-panel1.php">
              <div class="row">
                <div class="col-md-4"><label>Doctor Name:</label></div>
                <div class="col-md-8"><input type="text" class="form-control" name="doctor" onkeydown="return alphaOnly(event);" required></div><br><br>
                <div class="col-md-4"><label>Specialization:</label></div>
                <div class="col-md-8">
                  <select name="special" class="form-control" id="special" required="required">
                    <option value="head" name="spec" disabled selected>Select Specialization</option>
                    <option value="General" name="spec">General</option>
                    <option value="Cardiologist" name="spec">Cardiologist</option>
                    <option value="Neurologist" name="spec">Neurologist</option>
                    <option value="Pediatrician" name="spec">Pediatrician</option>
                  </select>
                </div><br><br>
                <div class="col-md-4"><label>Email ID:</label></div>
                <div class="col-md-8"><input type="email" class="form-control" name="demail" required></div><br><br>
                <div class="col-md-4"><label>Password:</label></div>
                <div class="col-md-8"><input type="password" class="form-control" onkeyup='check();' name="dpassword" id="dpassword" required></div><br><br>
                <div class="col-md-4"><label>Confirm Password:</label></div>
                <div class="col-md-8" id='cpass'><input type="password" class="form-control" onkeyup='check();' name="cdpassword" id="cdpassword" required>&nbsp &nbsp<span id='message'></span> </div><br><br>


                <div class="col-md-4"><label>Consultancy Fees:</label></div>
                <div class="col-md-8"><input type="text" class="form-control" name="docFees" required></div><br><br>
              </div>
              <input type="submit" name="docsub" value="Add Doctor" class="btn btn-primary">
            </form>
          </div>

          <div class="tab-pane fade" id="list-settings1" role="tabpanel" aria-labelledby="list-settings1-list">
            <form class="form-group" method="post" action="admin-panel1.php">
              <div class="row">

                <div class="col-md-4"><label>Email ID:</label></div>
                <div class="col-md-8"><input type="email" class="form-control" name="demail" required></div><br><br>

              </div>
              <input type="submit" name="docsub1" value="Delete Doctor" class="btn btn-primary" onclick="confirm('do you really want to delete?')">
            </form>
          </div>

          <!--The dashboard content of manage appointment tab in the sidebar-->
          <div class="tab-pane fade" id="list-app-manage" role="tabpanel" aria-labelledby="home">
            <div class="container-fluid">
              <div class="card">
                <div class="card-body">
                  <center>
                    <h4>Manage appointments</h4>
                  </center><br>
                  <form class="form-group" method="post" action="admin-panel1.php">
                    <div class="row">
                      <div class="col-md-4">
                        <label for="appointmentID">Appointment ID</label>
                      </div>
                      <div class="col-md-7">
                        <input type="text" class="form-control" name="appointmentID" id="appointmentID">
                      </div><br><br>

                      <div class="col-md-4">
                        <input type="button" id="findButton" value="Find me this man" class="btn btn-info">
                      </div>>

                      <div class="col-md-4">
                        <label for="patientID">Patient ID</label>
                      </div>
                      <div class="col-md-8">
                        <input type="text" class="form-control" name="patientID" id="patientID" required>
                      </div><br><br>

                      <div class="col-md-4">
                        <label for="spec">Specialization:</label>
                      </div>

                      <div class="col-md-8">
                        <select name="spec" class="form-control" id="spec" required>
                          <option value="" disabled selected>Select Specialization</option>
                          <?php
                          display_specs();
                          ?>
                        </select>
                      </div>
                      <br><br>

                      <!-- Script to limit doctor selection according to specialization-->
                      <script>
                        document.getElementById('spec').onchange = function foo() {
                          let spec = this.value;
                          console.log(spec)
                          let docs = [...document.getElementById('doctor').options];

                          docs.forEach((el, ind, arr) => {
                            arr[ind].setAttribute("style", "");
                            if (el.getAttribute("data-spec") != spec) {
                              arr[ind].setAttribute("style", "display: none");
                            }
                          });
                        };
                      </script>

                      <div class="col-md-4">
                        <label for="doctor">Doctors:</label>
                      </div>
                      <div class="col-md-8">
                        <select name="doctor" class="form-control" id="doctor" required>
                          <option value="" disabled selected>Select Doctor</option>
                          <?php display_docs(); ?>
                        </select>
                      </div><br><br>

                      <!-- Script to update Consultancy fees according to doctor selected -->
                      <script>
                        document.getElementById('doctor').onchange = function updateFees(e) {
                          var selection = document.querySelector(`[value=${this.value}]`).getAttribute('data-value');
                          document.getElementById('docFees').value = selection;
                        };
                      </script>

                      <div class="col-md-4">
                        <label>Consultancy Fees</label>
                      </div>

                      <div class="col-md-8">
                        <input class="form-control" type="text" name="docFees" id="docFees" readonly="readonly">
                      </div><br><br>
                      <div class="col-md-4">
                        <label>Date</label>
                      </div>
                      <div class="col-md-8">
                        <input type="date" class="form-control datepicker" name="appdate" id="appdate" required>
                      </div><br><br>
                      <div class="col-md-4">
                        <label>Time</label>
                      </div>
                      <div class="col-md-8">
                        <input type="time" class="form-control" name="apptime" id="apptime" required>
                      </div><br><br>
                      <div class="col-md-4">
                        <input type="submit" name="app-submit" value="Create new entry" class="btn btn-primary" id="inputbtn">
                      </div>
                      <div class="col-md-4">
                        <input type="submit" name="update_entry" value="Update entry" class="btn btn-secondary" id="updatebtn">
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
          <div class="tab-pane fade" id="list-mes" role="tabpanel" aria-labelledby="list-mes-list">

            <div class="col-md-8">
              <form class="form-group" action="messearch.php" method="post">
                <div class="row">
                  <div class="col-md-10"><input type="text" name="mes_contact" placeholder="Enter Contact" class="form-control"></div>
                  <div class="col-md-2"><input type="submit" name="mes_search_submit" class="btn btn-primary" value="Search"></div>
                </div>
              </form>
            </div>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">User Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact</th>
                  <th scope="col">Message</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $con = mysqli_connect("localhost", "root", "", "prms_db");
                global $con;

                $query = "select * from contact;";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {

                  #$fname = $row['fname'];
                  #$lname = $row['lname'];
                  #$email = $row['email'];
                  #$contact = $row['contact'];
                ?>
                  <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td><?php echo $row['message']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <br>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
</body>
</html>