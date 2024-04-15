<!DOCTYPE html>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "../vendor/autoload.php";
require "../vendor/phpmailer/phpmailer/src/Exception.php";
require "../vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "../vendor/phpmailer/phpmailer/src/SMTP.php";
$con = mysqli_connect("localhost", "root", "", "prms_db");

include('newfunc.php');

// Add new doctor
if (isset($_POST['docsub'])) {
  $doctor = $_POST['doctor'];
  $dpassword = $_POST['dpassword'];
  $demail = $_POST['demail'];
  $spec = $_POST['special'];
  $docFees = $_POST['docFees'];

  // Check if email already exists
  $email_check_query = "SELECT * FROM doctb WHERE email='$demail' LIMIT 1";
  $result = mysqli_query($con, $email_check_query);
  $doctor_record = mysqli_fetch_assoc($result);

  if ($doctor_record) {
    // Email already exists, display an error message        
    echo "<script>alert('Email already exists!');window.location.href = 'admin-panel1.php';</script>";
  } else {
    // Email does not exist, proceed with inserting the new doctor record
    $query = "INSERT INTO doctb(username,password,email,spec,docFees) VALUES ('$doctor','$dpassword','$demail','$spec','$docFees')";
    $result = mysqli_query($con, $query);
    if ($result) {
      echo "<script>alert('Doctor added successfully!');window.location.href = 'admin-panel1.php';</script>";
    } else {
      // Failed to insert doctor record
      echo "<script>alert('Failed to add doctor!');window.location.href = 'admin-panel1.php';</script>";
    }
  }
}

// Delete a doctor
if (isset($_POST['docsub1'])) {
  $demail = $_POST['demail'];
  $query = "UPDATE doctb set working_status=0 Where email='$demail';";
  $result = mysqli_query($con, $query);
  if ($result) {
    echo "<script>alert('Doctor removed successfully!');window.location.href = 'admin-panel1.php';</script>";
  } else {
    echo "<script>alert('Unable to delete!');window.location.href = 'admin-panel1.php';</script>";
  }
}

// Delete a patient
if (isset($_POST['pocsub1'])) {
  $pemail = $_POST['pemail'];
  $query = "UPDATE patreg set active_status=0 Where email='$pemail';";
  $result = mysqli_query($con, $query);
  if ($result) {
    echo "<script>alert('Patient removed successfully!');window.location.href = 'admin-panel1.php';</script>";
  } else {
    echo "<script>alert('Unable to delete!');window.location.href = 'admin-panel1.php';</script>";
  }
}
?>

<!-- Code for creating and updating new entries in manage appointment section of sidebar -->
<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "prms_db");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["app-submit"])) {
  // Get current date and time
  $currentDateTime = date("Y-m-d H:i:s");

  // Get form data
  $appointmentID = $_POST["appointmentID"];
  $patientID = $_POST["patientID"];
  $spec = $_POST["spec"];
  $doctor = $_POST["doctor"];
  $docFees = $_POST["docFees"];
  $appdate = $_POST["appdate"];
  $apptime = $_POST["apptime"];

  // Combine date and time
  $combinedDateTime = $appdate . ' ' . $apptime;

  // Check if appointment date and time are not in the past
  if ($combinedDateTime > $currentDateTime) {
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
        echo "<script>alert('Unable to process your request. Please try again!');window.location.href = 'admin-panel1.php';</script>";
      }
    } else {
      echo "<script>alert('Patient data not found. Please check the patient ID!');window.location.href = 'admin-panel1.php';</script>";
    }
  } else {
    echo "<script>alert('Appointment date and time cannot be in the past!');window.location.href = 'admin-panel1.php';</script>";
  }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_entry"])) {
  // Get current date and time
  $currentDateTime = date("Y-m-d H:i:s");

  // Get form data
  $appointmentID = $_POST["appointmentID"];
  $patientID = $_POST["patientID"];
  $spec = $_POST["spec"];
  $doctor = $_POST["doctor"];
  $docFees = $_POST["docFees"];
  $appdate = $_POST["appdate"];
  $apptime = $_POST["apptime"];

  // Combine date and time
  $combinedDateTime = $appdate . ' ' . $apptime;

  // Check if appointment date and time are not in the past
  if ($combinedDateTime > $currentDateTime) {
    // Update appointment data in the database
    $sqlcmd = "UPDATE appointmenttb 
                   SET doctor = '$doctor', docFees = '$docFees', appdate = '$appdate', apptime = '$apptime' 
                   WHERE ID = '$appointmentID' AND pid = '$patientID'";

    $query = mysqli_query($con, $sqlcmd);

    if ($query) {
      echo "<script>alert('Appointment details successfully updated');window.location.href = 'admin-panel1.php';</script>";
      exit();
    } else {
      echo "<script>alert('Failed to update appointment details. Please try again!');window.location.href = 'admin-panel1.php';</script>";
    }
  } else {
    echo "<script>alert('Appointment date and time cannot be in the past!');</script>";
  }
}
?>


<?php
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "prms_db");
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointmentID'])) {
  // Sanitize the input to prevent SQL injection
  $appointmentID = mysqli_real_escape_string($con, $_POST['appointmentID']);

  // Fetch appointment details from the database
  $query = "SELECT * FROM appointmenttb WHERE ID = '$appointmentID'";
  $result = mysqli_query($con, $query);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Extract appointment details
    $pid = $row['pid'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $gender = $row['gender'];
    $contact = $row['contact'];
    $appdate = $row['appdate'];
    $apptime = $row['apptime'];

    // Prepare email body with appointment details
    $emailBody = "Your Appointment Has Been Approved!<br><br>";
    $emailBody .= "<strong>Details:</strong><br>";
    $emailBody .= "<strong>Name:</strong> $fname $lname<br>";
    $emailBody .= "<strong>Appointment Date:</strong> $appdate<br>";
    $emailBody .= "<strong>Appointment Time:</strong> $apptime<br>";

    // Send email using PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->Username = 'prmsofficialgg@gmail.com';
    $mail->Password = 'muxhlnzfrmmjerky';
    $mail->setFrom('prmsofficialgg@gmail.com');
    $mail->addAddress($_SESSION["email"]);
    $mail->isHTML(true);
    $mail->Subject = "Appointment Status";
    $mail->Body = $emailBody;

    // Send email and update appointment status
    if ($mail->send()) {
      $update_query = "UPDATE appointmenttb SET approve_status = 1 WHERE ID = '$appointmentID'";
      mysqli_query($con, $update_query);
      echo "Email sent and appointment status updated successfully.";
    } else {
      echo "Error sending email: " . $mail->ErrorInfo;
    }
  } else {
    echo "No appointment found with ID: $appointmentID";
  }

  mysqli_close($con);
}
?>



<!-- Code for Cancel Mechanism in Appointment Details Section of the Sidebar -->
<?php
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "prms_db");
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancelAppointmentID'])) { // Change the parameter name here
  $appointmentID = mysqli_real_escape_string($con, $_POST['cancelAppointmentID']);
  $update_query = "UPDATE appointmenttb SET receptStatus = 0 WHERE ID = '$appointmentID'";
  $mail = new PHPMailer(true);

  // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

  $mail->isSMTP();
  $mail->SMTPAuth = true;

  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;

  $mail->Username = 'prmsofficialgg@gmail.com';
  $mail->Password = 'muxhlnzfrmmjerky';

  $mail->setFrom('prmsofficialgg@gmail.com');
  $mail->addAddress($_SESSION["email"]); //modifiable 
  $mail->isHTML(true);
  $mail->Subject = "Appointment Status"; //is this the syntax, modifiable
  $mail->Body = "Your Appointment has been cancelled. Please Contact Us for Detailed Information"; //is this the syntax ,modifiable

  $mail->send();
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
        background: -webkit-linear-gradient(left, #242121, #5a5c5d);
      }

      .col-md-4 {
        max-width: 20% !important;
      }

      .list-group-item.active {
        z-index: 2;
        color: #fff;
        background-color: #1e9cd6;
        border-color: #00ffdb;
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

      .navbar-brand {
        font-size: 1.4rem;
        position: relative;
        left: 15px;
      }

      .nav-link {
        position: relative;
        left: 40px;
        top: 3px;
      }

      .card {
        width: 110%;
      }

      .card-body {
        background: -webkit-linear-gradient(left, #D5E9E8, #94a6ad);
      }

      .table {
        width: 900px;
        color: #0c3e6f;
      }

      .list-group {
        line-height: 2.1;
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
    <h2 style="margin-left: 40%; padding-bottom:0px;font-family: 'IBM Plex Sans', sans-serif;"> WELCOME RECEPTIONIST </h2>
    <div class="row">
      <div class="col-md-4" style="max-width:25%;margin-top: 3%;">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
          <a class="list-group-item list-group-item-action" href="#list-doc" id="list-doc-list" role="tab" aria-controls="home" data-toggle="list">Doctor List</a>
          <a class="list-group-item list-group-item-action" href="#list-pat" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">Patient List</a>
          <a class="list-group-item list-group-item-action" href="#list-app-manage" id="list-app-manage-list" role="tab" data-toggle="list" aria-controls="home">Manage Appointments</a>
          <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list" role="tab" data-toggle="list" aria-controls="home">Appointment Details</a>
          <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">Prescription List</a>
          <a class="list-group-item list-group-item-action" href="#list-settings" id="list-adoc-list" role="tab" data-toggle="list" aria-controls="home">Doctor</a>
          <a class="list-group-item list-group-item-action" href="#list-settings1" id="list-ddoc-list" role="tab" data-toggle="list" aria-controls="home">Delete Doctor/Patient</a>
          <a class="list-group-item list-group-item-action" href="#list-mes" id="list-mes-list" role="tab" data-toggle="list" aria-controls="home">Queries</a>

        </div><br>
      </div>

      <div class="col-md-9" style="margin-top: 3%;">
        <div class="tab-content" id="nav-tabContent" style="width: 950px;">
          <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
            <div class="container-fluid container-fullw bg-black">

              <div>
                <div class="counters">
                  <h3>
                    <div class="counter" id="doctorCounter">0</div>Doctors<br><br>
                  </h3>

                  <h3>
                    <div class="counter" id="patientCounter">0</div>Patients
                  </h3>
                </div>
              </div>

              <div class="welcome">
                <img src="../assets/images/welcome.jpg" class="welcome-img" alt="Welcome Image">
              </div>

            </div>
          </div>

          <style>
            .counters {
              margin-top: 20px;
            }

            .counter {
              display: inline-block;
              color: black;
              font-size: 28px;
              margin: 0 20px;
            }

            .welcome-img {
              position: absolute;
              top: -40px;
              width: 1190px;
              max-width: 200%;
              height: auto;
              display: block;
              margin: 0 auto;
              opacity: 80%;
              z-index: -1;
            }

            body {
              background: -webkit-linear-gradient(left, #e7fffe, #9a9a9a);
            }

            .bg-primary {
              background: -webkit-linear-gradient(left, #242121, #89665082);
            }
          </style>

          <!-- Script for The Count in Dashboard -->
          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const doctorCounter = document.getElementById("doctorCounter");
              const patientCounter = document.getElementById("patientCounter");

              // Function to update counters with transition effect
              function updateCounters(doctors, patients) {
                let currentDoctors = parseInt(doctorCounter.textContent);
                let currentPatients = parseInt(patientCounter.textContent);

                // Calculate increment step
                let doctorStep = Math.ceil((doctors - currentDoctors) / 100);
                let patientStep = Math.ceil((patients - currentPatients) / 100);

                // Update counters with transition effect
                let doctorInterval = setInterval(function() {
                  currentDoctors += doctorStep;
                  doctorCounter.textContent = currentDoctors;

                  if (currentDoctors >= doctors) {
                    clearInterval(doctorInterval);
                  }
                }, 90);

                let patientInterval = setInterval(function() {
                  currentPatients += patientStep;
                  patientCounter.textContent = currentPatients;

                  if (currentPatients >= patients) {
                    clearInterval(patientInterval);
                  }
                }, 90);
              }
              <?php
              $conn = mysqli_connect("localhost", "root", "", "prms_db");
              if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
              }
              $doctorCountQuery = "SELECT COUNT(*) AS doctor_count FROM doctb";
              $doctorResult = mysqli_query($conn, $doctorCountQuery);
              $doctorCount = mysqli_fetch_assoc($doctorResult)['doctor_count'];

              $patientCountQuery = "SELECT COUNT(*) AS patient_count FROM patreg";
              $patientResult = mysqli_query($conn, $patientCountQuery);
              $patientCount = mysqli_fetch_assoc($patientResult)['patient_count'];

              echo "updateCounters($doctorCount, $patientCount);";

              mysqli_close($conn);
              ?>
            });
          </script>

          <!-- Doctor List section of the sidebar -->
          <div class="tab-pane fade" id="list-doc" role="tabpanel" aria-labelledby="list-home-list">

            <div class="col-md-8">
              <form class="form-group" action="doctorsearch.php" method="post">
                <div class="row">
                  <div class="col-md-10"><input type="text" name="doctor_contact" placeholder="Enter Email ID" class="form-control"></div>
                  <div class="col-md-2"><input type="submit" name="doctor_search_submit" class="btn btn-info" value="Search"></div>
                </div>
              </form>
            </div>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Doctor ID</th>
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
                $query = "select * from prms_db.doctb where working_status=1";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                  $did = $row['docid'];
                  $username = $row['username'];
                  $spec = $row['spec'];
                  $email = $row['email'];
                  $password = $row['password'];
                  $docFees = $row['docFees'];

                  echo "<tr>
                        <td>$did</td>
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

          <!-- Patient List section of the Sidebar -->
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

                  echo "<tr onclick=\"displayPatientDetails($pid)\">
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
                    $query = "select * from prestb ORDER BY appdate DESC LIMIT 5";
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
                  <div class="col-md-2"><input type="submit" name="app_search_submit" class="btn btn-info" value="Search"></div>
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
                  <th scope="col">Appointment Date</th>
                  <th scope="col">Appointment Time</th>
                  <th scope="col">Approve Appointment</th>
                  <th scope="col">Cancel</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $con = mysqli_connect("localhost", "root", "", "prms_db");
                global $con;

                $query = "select * from appointmenttb where approve_status=0 AND receptStatus=1 ORDER BY appdate DESC;";
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
                    <td><?php echo $row['appdate']; ?></td>
                    <td><?php echo $row['apptime']; ?></td>
                    <td>
                      <!-- Approve button -->
                      <?php if ($row['approve_status'] == 0) { ?>
                        <button id="approveBtn_<?php echo $row['ID']; ?>" class="btn btn-success" onclick="approveAppointment('<?php echo $row['ID']; ?>')">Approve</button>
                      <?php } else { ?>
                        <!-- Disable the button if appointment is already approved -->
                        <button class="btn btn-secondary" disabled>Approved</button>
                      <?php } ?>
                    </td>
                    <td>
                      <!-- Cancel button -->
                      <?php if ($row['receptStatus'] == 1) { ?>
                        <button id="cancelBtn_<?php echo $row['ID']; ?>" class="btn btn-danger" onclick="cancelAppointment('<?php echo $row['ID']; ?>')">Cancel</button>
                      <?php } else { ?>
                        <!-- Display "Cancelled" if appointment is already cancelled -->
                        <button class="btn btn-secondary" disabled>Cancelled</button>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <br>
          </div>

          <script>
            // Function to handle approve button click
            function approveAppointment(appointmentID) {
              // Disable the approve button to prevent multiple clicks
              var approveButton = document.getElementById('approveBtn_' + appointmentID);
              approveButton.disabled = true;

              // Disable the cancel button to prevent further actions
              var cancelButton = document.getElementById('cancelBtn_' + appointmentID);
              cancelButton.disabled = true;

              // Send an AJAX request to update the database
              var xhr = new XMLHttpRequest();
              xhr.open("POST", "admin-panel1.php", true);
              xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
              xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                  // Update button appearance and status on success
                  approveButton.innerText = 'Approved';
                  approveButton.classList.remove('btn-success');
                  approveButton.classList.add('btn-secondary');
                }
              };
              xhr.send("appointmentID=" + appointmentID);
            }

            // Function to handle cancel button click
            function cancelAppointment(appointmentID) {
              // Disable the cancel button to prevent multiple clicks
              var cancelButton = document.getElementById('cancelBtn_' + appointmentID);
              cancelButton.disabled = true;

              // Disable the approve button to prevent further actions
              var approveButton = document.getElementById('approveBtn_' + appointmentID);
              approveButton.disabled = true;

              // Send an AJAX request to update the database
              var xhr = new XMLHttpRequest();
              xhr.open("POST", "admin-panel1.php", true);
              xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
              xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                  // Update button appearance and status on success
                  cancelButton.innerText = 'Cancelled';
                  cancelButton.classList.remove('btn-danger');
                  cancelButton.classList.add('btn-secondary');
                }
              };
              xhr.send("cancelAppointmentID=" + appointmentID);
            }
          </script>

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

                <div class="col-md-4"><label>Doctor Email ID:</label></div>
                <div class="col-md-8"><input type="email" class="form-control" name="demail"></div><br><br>

              </div>

              <div class="row">
                <div class="col-md-4"><label>Patient Email ID:</label></div>
                <div class="col-md-8"><input type="email" class="form-control" name="pemail"></div><br><br>
              </div>

              <input type="submit" name="docsub1" value="Delete Doctor" class="btn btn-danger" onclick="confirm('do you really want to delete?')">
              <input type="submit" name="pocsub1" value="Delete Patient" class="btn btn-info" onclick="confirm('do you really want to delete?')">
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
                  <form class="form-group" method="post" action="admin-panel1.php" id="appointmentForm">
                    <div class="row">
                      <div class="col-md-4">
                        <label for="appointmentID">Appointment ID</label>
                      </div>
                      <div class="col-md-7">
                        <input type="text" class="form-control" name="appointmentID" id="appointmentID">
                      </div><br><br>

                      <div class="col-md-4">
                        <input type="button" id="findButton" value="Search Here" class="btn btn-info" name="searchAppointment" disabled>
                      </div>

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
                          var selectedOption = document.querySelector(`option[value="${this.value}"]`);
                          var selection = selectedOption.getAttribute('data-value');
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
                        <input type="date" class="form-control datepicker" name="appdate" id="appdate" min="<?php echo date('Y-m-d'); ?>" required>
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

          <!-- Script to autofill the contents.-->
          <script>
            document.getElementById('appointmentID').addEventListener('input', function() {
              var appointmentID = this.value;

              // Make AJAX request to fetch appointment data
              $.ajax({
                url: 'search_appointment.php', // URL of the server-side script
                type: 'POST',
                data: {
                  appointmentID: appointmentID
                },
                dataType: 'json',
                success: function(response) {
                  document.getElementById('patientID').value = response.pid;
                  document.getElementById('spec').value = response.spec;
                  document.getElementById('doctor').value = response.doctor;
                  document.getElementById('docFees').value = response.docFees;
                  document.getElementById('appdate').value = response.appdate;
                  document.getElementById('apptime').value = response.apptime;
                },
                error: function(xhr, status, error) {
                  console.error('Error fetching appointment data:', error);
                }
              });
            });
          </script>

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

                $query = "select * from contact ORDER BY cid DESC LIMIT 10;";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
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

  <!-- Testing the user detail popup thing -->
  <div class="modal fade" id="patientDetailsModal" tabindex="-1" role="dialog" aria-labelledby="patientDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content" style="background: linear-gradient(to right, #b4b4b4, #c5f6f6);">
        <div class="modal-header">
          <h4 class="modal-title" id="patientDetailsModalLabel">Patient Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="patientDetails">
            <!-- Content goes here -->
          </div>
        </div>
      </div>
    </div>
  </div>


  <script>
    // JavaScript function to fetch and display patient details in the modal
    function displayPatientDetails(patientID) {
      console.log('Fetching patient details for ID:', patientID);
      // AJAX request to fetch patient details from server
      $.ajax({
        url: 'patient_details.php',
        method: 'POST',
        data: {
          patientID: patientID
        },
        success: function(response) {
          // Display patient details in the modal
          console.log('Response from server:', response);
          $('#patientDetails').html(response);
          $('#patientDetailsModal').modal('show'); // Show the modal
          console.log('Modal shown');
        },
        error: function(xhr, status, error) {
          // Handle error
          console.error('Error:', xhr.responseText);
        }
      });
    }
  </script>




  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
</body>

</html>