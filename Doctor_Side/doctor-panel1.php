<!DOCTYPE html>
<?php
include('../func1.php');
$con = mysqli_connect("localhost", "root", "", "prms_db");
$doctor = $_SESSION['docid'];
$docname = $_SESSION['dname'];
if (isset($_GET['cancel'])) {
  $query = mysqli_query($con, "update appointmenttb set doctorStatus='0' where ID = '" . $_GET['ID'] . "'");
  if ($query) {
    echo "<script>alert('Your appointment successfully cancelled');window.location.href = 'doctor-panel1.php';</script>";
  }
}
?>

<!-- Insert Image into the database -->
<?php
if (isset($_POST['upload'])) {
  $userID = $_SESSION['docid'];

  // Check if file is selected
  if ($_FILES['photo']['name'] != '') {
    $file_name = $_FILES['photo']['name'];
    $file_size = $_FILES['photo']['size'];
    $file_tmp = $_FILES['photo']['tmp_name'];
    $file_type = $_FILES['photo']['type'];

    // Specify the directory where the file will be stored
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($file_name);

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "<script>alert('This Photo Already Exists! '); window.location.href = 'doctor-panel1.php';</script>";
    } else {
      // Move the uploaded file to the specified directory
      move_uploaded_file($file_tmp, $target_file);

      // Update the user's photo path in the database
      $con = mysqli_connect("localhost", "root", "", "prms_db");
      $query = "UPDATE doctb SET picture='$target_file' WHERE docid=$userID";
      mysqli_query($con, $query);

      // Close the database connection
      mysqli_close($con);

      echo "<script>alert('Photo Uploaded Successfully!'); window.location.href = 'doctor-panel1.php';</script>";
    }
  } else {
    echo "<script>alert('Please Choose a Photo! '); window.location.href = 'doctor-panel1.php';</script>";
  }
}
?>

<html lang="en">

<head>

  <title>Doctor-Dashboard</title>
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
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i>Patient Record Management System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <style>
      .btn-outline-light:hover {
        color: #25bef7;
        background-color: #f8f9fa;
        border-color: #f8f9fa;
      }
    </style>

    <style>
      .bg-primary {
        background: -webkit-linear-gradient(left, #242121, #89665082);
      }

      body {
        background: -webkit-linear-gradient(left, #e7fffe, #9a9a9a);
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
      <form class="form-inline my-2 my-lg-0" method="post" action="search.php">
        <input class="form-control mr-sm-2" type="text" placeholder="Enter contact number" aria-label="Search" name="contact">
        <input type="submit" class="btn btn-outline-light" id="inputbtn" name="search_submit" value="Search">
      </form>
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

  .welcome-img {
    position: absolute;
    right: -10px;
    top: -60px;
    width: 1200px;
    max-width: 100%;
    height: auto;
    margin: 0 auto;
    display: block;
    opacity: 70%;
    z-index: -1;
  }

  .bg-primary {
    background: -webkit-linear-gradient(left, #242121, #89665082);
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

  .btn-primary {
    background-color: #3c50c1;
    border-color: #3c50c1;
  }

  .list-group {
    line-height: 2.1;
  }

  .list-group {
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
    line-height: 2.6;
  }

  .col-md-4 {
    max-width: 20% !important;
  }

  .card-body {
    background: -webkit-linear-gradient(left, #D5E9E8, #94a6ad);
    width: 100%;
  }

  .form-control {
    width: 90%;
  }

  .navbar-dark .navbar-brand {
    font-size: 24px;
  }

  .appointment-row:hover {
    background-color: #f5f5f5;
    cursor: pointer;
  }
</style>

<body style="padding-top:50px;">
  <div class="container-fluid" style="margin-top:50px;">
    <h3 style="margin-left: 40%; padding-bottom: 20px;font-family:'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $_SESSION['dname'] ?> </h3>
    <div class="row">
      <div class="col-md-4" style="max-width:18%;margin-top: 3%;">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" href="#list-dash" role="tab" aria-controls="home" data-toggle="list">Dashboard</a>
          <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Your Profile</a>
          <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list" role="tab" data-toggle="list" aria-controls="home">Appointments</a>
          <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">Prescription List</a>
          <a class="list-group-item list-group-item-action" href="#list-health-checkups" id="list-health-checkups-list" role="tab" data-toggle="list" aria-controls="home">Regular Health Checkups</a>
        </div><br>
      </div>

      <!-- DashBoard Content -->
      <div class="col-md-9" style="margin-top: 3%;">
        <div class="tab-content" id="nav-tabContent" style="width: 950px;">
          <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
            <div class="container-fluid container-fullw bg-white">
              <div class="welcome">
                <img src="../assets/images/hosue.jpg" class="welcome-img" alt="Welcome Image">
              </div>
            </div>
          </div>


          <!-- Your Profile Content-->
          <?php
          $con = mysqli_connect("localhost", "root", "", "prms_db");
          if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
          }

          $doctorID = $_SESSION['docid'];
          $query = "SELECT * FROM doctb WHERE docid = $doctorID";
          $result = mysqli_query($con, $query);

          if (mysqli_num_rows($result) > 0) {
            $doctorData = mysqli_fetch_assoc($result);
            $username = $doctorData['username'];
            $email = $doctorData['email'];
            $specialization = $doctorData['spec'];
            $doctorFees = $doctorData['docFees'];
            $picture = !empty($doctorData['picture']) ? $doctorData['picture'] : '../assets/images/default-user.png';
          ?>
            <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
              <div class="container-fluid container-fullw bg-white">
                <div class="profile" style="width:1100px;">
                  <div class="row" style="padding: 20px; text-align:center; background: -webkit-linear-gradient(left, #b8d9ff, #c4b2b2);">
                    <h2>Your Profile:</h2>
                  </div>
                  <div class="row" style="padding: 10px;  background: -webkit-linear-gradient(left, #a3aad9, #b7b0b6);">
                    <div class="col-md-3" style="padding: 10px;">
                      <div style="width: 200px; height: 200px; overflow: hidden; border: 1px solid #ccc;">
                        <img src="<?php echo $picture; ?>" alt="User Photo" style="width: 100%; height: auto;">
                      </div>
                      <form method="post" action="doctor-panel1.php" enctype="multipart/form-data">
                        <div class="form-group">
                          <input type="file" class="form-control-file" id="photo" name="photo">
                        </div>
                        <button type="submit" class="btn btn-info" name="upload">Upload</button>
                      </form>
                    </div>
                    <div class="col">
                      <div class="row" style="padding: 10px;">
                        <div class="col-4" style="padding-top: 40px;">
                          <h4>General Information:</h4>
                        </div>
                        <div class="col" style="border: 2px solid black; border-radius:10px; padding:10px 10px; font-family: monospace;font-size: 20px;">
                          <ul>
                            <li>Doctor ID: <?php echo  $doctorID; ?></li>
                            <li>Username: <?php echo $username; ?></li>
                            <li>Email: <?php echo $email; ?></li>
                            <li>Specialization: <?php echo $specialization; ?></li>
                            <li>Doctor Fees: <?php echo $doctorFees; ?></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php
          } else {
            echo "Failed to Load Doctor Information!.";
          }

          mysqli_close($con);
          ?>

          <!-- Appointments Section of the Sidebar -->
          <div class="tab-pane fade" id="list-app" role="tabpanel" aria-labelledby="list-home-list">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Patient ID</th>
                  <th scope="col">Appointment ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Gender</th>
                  <th scope="col">Contact</th>
                  <th scope="col">Appointment Date</th>
                  <th scope="col">Appointment Time</th>
                  <th scope="col">Current Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $con = mysqli_connect("localhost", "root", "", "prms_db");
                global $con;
                $dname = $_SESSION['dname'];
                $query = "select pid,ID,fname,lname,gender,email,contact,appdate,apptime,userStatus,doctorStatus from appointmenttb where doctor='$dname' AND approve_status=1 AND userStatus=1 AND doctorStatus=1";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                  <tr class="appointment-row" data-pid="<?php echo $row['pid']; ?>" data-id="<?php echo $row['ID']; ?>" data-fname="<?php echo $row['fname']; ?>" data-lname="<?php echo $row['lname']; ?>" data-gender="<?php echo $row['gender']; ?>" data-contact="<?php echo $row['contact']; ?>" data-appdate="<?php echo $row['appdate']; ?>" data-apptime="<?php echo $row['apptime']; ?>" data-status="<?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) {
                                                                                                                                                                                                                                                                                                                                                                                                                  echo "Active";
                                                                                                                                                                                                                                                                                                                                                                                                                } elseif (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) {
                                                                                                                                                                                                                                                                                                                                                                                                                  echo "Cancelled by Patient";
                                                                                                                                                                                                                                                                                                                                                                                                                } elseif (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) {
                                                                                                                                                                                                                                                                                                                                                                                                                  echo "Cancelled by You";
                                                                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                                                                ?>">

                    <td><?php echo $row['pid']; ?></td>
                    <td><?php echo $row['ID']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['lname']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td><?php echo $row['appdate']; ?></td>
                    <td><?php echo $row['apptime']; ?></td>
                    <td><?php
                        if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) {
                          echo "Active";
                        } elseif (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) {
                          echo "Cancelled by Patient";
                        } elseif (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) {
                          echo "Cancelled by You";
                        }
                        ?></td>
                    <td>
                      <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { ?>
                        <a href="doctor-panel1.php?ID=<?php echo $row['ID']; ?>&cancel=update" onClick="return confirm('Are you sure you want to cancel this appointment ?')" title="Cancel Appointment" tooltip-placement="top" tooltip="Remove">
                          <button class="btn btn-danger">Cancel</button>
                        </a>
                      <?php } else {
                        echo "Cancelled";
                      } ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <br>
          </div>

          <!-- Prescription List Section -->
          <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Patient ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Appointment ID</th>
                  <th scope="col">Appointment Date</th>
                  <th scope="col">Appointment Time</th>
                  <th scope="col">Disease</th>
                  <th scope="col">Allergy</th>
                  <th scope="col">Prescribe</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM prestb WHERE doctor = '$docname'";
                $result = mysqli_query($con, $query);

                if ($result) {
                  while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr data-toggle="modal" data-target="#patientDetailsModal" onclick="displayPatientDetails(<?php echo $row['pid']; ?>)">
                      <td><?php echo $row['pid']; ?></td>
                      <td><?php echo $row['fname']; ?></td>
                      <td><?php echo $row['lname']; ?></td>
                      <td><?php echo $row['ID']; ?></td>
                      <td><?php echo $row['appdate']; ?></td>
                      <td><?php echo $row['apptime']; ?></td>
                      <td><?php echo $row['disease']; ?></td>
                      <td><?php echo $row['allergy']; ?></td>
                      <td><?php echo $row['prescription']; ?></td>
                    </tr>
                <?php
                  }
                } else {
                  echo "Error fetching data: " . mysqli_error($con);
                }
                mysqli_close($con);
                ?>
              </tbody>
            </table>
            <br>
          </div>

          <!-- Regular Health Checkup side of sidebar -->
          <div class="tab-pane fade" id="list-health-checkups" role="tabpanel" aria-labelledby="list-health-checkups-list">
            <div class="container-fluid container-fullw bg-white">
              <div class="row">
                <div class="col-md-6">
                  <form id="searchForm">
                    <div class="form-group" style="padding: 10px;">
                      <label for="patientID">Patient ID:</label>
                      <input type="text" class="form-control" id="patientID" name="patientID" placeholder="Enter Patient ID">
                    </div>
                    <button type="button" class="btn btn-info" onclick="searchAppointments()">Search</button>
                  </form>
                </div>
              </div>
              <div class="row" id="appointmentList">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Pictures in the Regular Health Checkup section of the sidebar-->
  <div class="modal fade" id="pictureModal" tabindex="-1" role="dialog" aria-labelledby="pictureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Adjusted modal-dialog class to modal-lg for a larger modal -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pictureModalLabel">Patient Pictures</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalBody">
          <!-- Images will be displayed here -->
        </div>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $(document).on('click', '.open-modal', function() {
        var appointmentID = $(this).data('appointmentid');
        $('#modalBody').empty();

        // Fetch pictures associated with the appointment ID using AJAX
        $.ajax({
          url: 'fetch_pictures.php',
          type: 'POST',
          data: {
            appointmentID: appointmentID
          },
          dataType: 'json',
          success: function(response) {
            // Append each picture to the modal body
            response.forEach(function(picture) {
              $('#modalBody').append('<img src="data:image/jpeg;base64,' + picture + '" alt="Patient Picture" class="img-fluid">');
            });
          },
          error: function() {
            console.error('Error fetching pictures');
          }
        });

        $('#pictureModal').modal('show');
      });

    });

    function searchAppointments() {
      var patientID = $('#patientID').val();
      $.ajax({
        url: 'fetch_data.php',
        type: 'POST',
        data: {
          patientID: patientID
        },
        success: function(response) {
          $('#appointmentList').html(response);
        },
        error: function() {
          console.error('Error fetching appointments');
        }
      });
    }
  </script>

  <!-- Modal for Showing Patient Details -->
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

  <!-- Modal structure for Appointments section of the sidebar -->
  <div class="modal fade" id="appointmentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="appointmentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="appointmentDetailsModalLabel">Appointment Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="prescriptionForm" method="post" action="prescribe.php" enctype="multipart/form-data">
            <div class="form-group">
              <label for="disease">Disease:</label>
              <input type="text" class="form-control" id="disease" name="disease" required>
            </div>
            <div class="form-group">
              <label for="allergies">Allergies:</label>
              <input type="text" class="form-control" id="allergies" name="allergies" required>
            </div>
            <div class="form-group">
              <label for="prescription">Prescription:</label>
              <textarea class="form-control" id="prescription" name="prescription" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="bloodType">Blood Type:</label>
              <input type="text" class="form-control" id="bloodType" name="bloodType" required>
            </div>
            <div class="form-group">
              <label for="bloodPressure">Blood Pressure:</label>
              <input type="text" class="form-control" id="bloodPressure" name="bloodPressure" required>
            </div>
            <div class="form-group">
              <label for="weight">Weight:</label>
              <input type="text" class="form-control" id="weight" name="weight" required>
            </div>
            <div class="form-group">
              <label for="other">Other:</label>
              <textarea class="form-control" id="other" name="other" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="images">Upload Images:</label>
              <input type="file" class="form-control-file" id="images" name="images[]" multiple accept="image/*">
            </div>
            <input type="hidden" id="pid" name="pid" value="">
            <input type="hidden" id="ID" name="ID" value="">
            <input type="hidden" id="fname" name="fname" value="">
            <input type="hidden" id="lname" name="lname" value="">
            <input type="hidden" id="appdate" name="appdate" value="">
            <input type="hidden" id="apptime" name="apptime" value="">
            <button type="submit" class="btn btn-primary" name="prescribe">Prescribe</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script>
    $(document).ready(function() {
      // Attach click event listener to appointment rows
      $('.appointment-row').click(function() {
        var pid = $(this).data('pid');
        var ID = $(this).data('id');
        var fname = $(this).data('fname');
        var lname = $(this).data('lname');
        var gender = $(this).data('gender');
        var contact = $(this).data('contact');
        var appdate = $(this).data('appdate');
        var apptime = $(this).data('apptime');
        // Call function to display appointment details in modal
        displayAppointmentDetails(pid, ID, fname, lname, gender, contact, appdate, apptime, status);
      });
    });

    // Function to display appointment details in the modal
    function displayAppointmentDetails(pid, ID, fname, lname, gender, contact, appdate, apptime, status) {
      // Set the appointment details in the prescription form
      document.getElementById('pid').value = pid;
      document.getElementById('ID').value = ID;
      document.getElementById('fname').value = fname;
      document.getElementById('lname').value = lname;
      document.getElementById('appdate').value = appdate;
      document.getElementById('apptime').value = apptime;

      // Show the modal
      $('#appointmentDetailsModal').modal('show');
    }
  </script>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- Replaced the jquery for a full version as above -->
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
</body>

</html>