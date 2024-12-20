<!DOCTYPE html>
<?php
session_start();
include("newfunc.php");
$con = mysqli_connect("localhost", "root", "", "prms_db");

$pid = $_SESSION['pid'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$fname = $_SESSION['fname'];
$gender = $_SESSION['gender'];
$lname = $_SESSION['lname'];
$contact = $_SESSION['contact'];

if (isset($_POST['app-submit'])) {
  $pid = $_SESSION['pid'];
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $gender = $_SESSION['gender'];
  $contact = $_SESSION['contact'];
  $doctor = $_POST['doctor'];
  $email = $_SESSION['email'];
  # $fees=$_POST['fees'];
  $docFees = $_POST['docFees'];

  $appdate = $_POST['appdate'];
  $apptime = $_POST['apptime'];


  $query = mysqli_query($con, "insert into appointmenttb(pid,fname,lname,gender,email,contact,doctor,docFees,appdate,apptime,userStatus,doctorStatus) values($pid,'$fname','$lname','$gender','$email','$contact','$doctor','$docFees','$appdate','$apptime','1','1')");

  if ($query) {
    echo "<script>alert('Your appointment successfully booked');</script>";
  } else {
    echo "<script>alert('Unable to process your request. Please try again!');</script>";
  }
}

if (isset($_GET['cancel'])) {
  $query = mysqli_query($con, "update appointmenttb set userStatus='0' where ID = '" . $_GET['ID'] . "'");
  if ($query) {
    echo "<script>alert('Your appointment successfully cancelled');</script>";
  }
}

function get_specs()
{
  $con = mysqli_connect("localhost", "root", "", "prms_db");
  $query = mysqli_query($con, "select username,spec from doctb");
  $docarray = array();
  while ($row = mysqli_fetch_assoc($query)) {
    $docarray[] = $row;
  }
  return json_encode($docarray);
}

?>

<!-- Insert Image into the database -->
<?php
if (isset($_POST['upload'])) {
  $userID = $_SESSION['pid'];

  // Check if file is selected
  if ($_FILES['photo']['name'] != '') {
    $file_name = $_FILES['photo']['name'];
    $file_size = $_FILES['photo']['size'];
    $file_tmp = $_FILES['photo']['tmp_name'];
    $file_type = $_FILES['photo']['type'];

    // Specify the directory where the file will be stored
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file_name);

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "<script>alert('This Photo Already Exists! '); window.location.href = 'admin-panel.php';</script>";
    } else {
      // Move the uploaded file to the specified directory
      move_uploaded_file($file_tmp, $target_file);

      // Update the user's photo path in the database
      $con = mysqli_connect("localhost", "root", "", "prms_db");
      $query = "UPDATE patreg SET picture='$target_file' WHERE pid=$userID";
      mysqli_query($con, $query);

      // Close the database connection
      mysqli_close($con);

      echo "<script>alert('Photo Uploaded Successfully!'); window.location.href = 'admin-panel.php';</script>";
    }
  } else {
    echo "<script>alert('Please Choose a Photo! '); window.location.href = 'admin-panel.php';</script>";
  }
}
?>



<html lang="en">
<title>Patient-Dashboard</title>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="../font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="style.css">
  <!-- Bootstrap CSS -->

  <link rel="stylesheet" href="../vendor/fontawesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> <b>Patient Record Management System</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <style>
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
    </style>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
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
    <h3 style="margin-left: 40%;  padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $username ?>
    </h3>
    <div class="row">
      <div class="col-md-4" style="max-width:25%; margin-top: 3%">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
          <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Your Profile</a>
          <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Book Appointment</a>
          <a class="list-group-item list-group-item-action" href="#app-hist" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">Appointment History</a>
          <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">Prescriptions</a>

        </div><br>
      </div>
      <div class="col-md-9" style="margin-top: 3%;">
        <div class="tab-content" id="nav-tabContent" style="width: 90%;">
          <style>
            body {
              background: -webkit-linear-gradient(left, #e7fffe, #9a9a9a);
            }
          </style>

          <!-- Dashboard Content -->
          <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-profile-list">
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

          $userID = $_SESSION['pid'];
          $query = "SELECT * FROM patreg WHERE pid = $userID";
          $result = mysqli_query($con, $query);

          if (mysqli_num_rows($result) > 0) {
            $userData = mysqli_fetch_assoc($result);
            $firstName = $userData['fname'];
            $lastName = $userData['lname'];
            $gender = $userData['gender'];
            $email = $userData['email'];
            $contact = $userData['contact'];
            $picture = !empty($userData['picture']) ? $userData['picture'] : '../assets/images/default-user.png';
          ?>
            <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
              <div class="container-fluid container-fullw bg-white">
                <div class="row" style="padding: 20px; text-align:center; background: -webkit-linear-gradient(left, #b8d9ff, #c4b2b2);">
                  <h2>Your Profile:</h2>
                </div>
                <div class="row" style="padding: 10px;  background: -webkit-linear-gradient(left, #a3aad9, #b7b0b6);">
                  <div class="col-md-3" style="padding: 10px;">
                    <img src="<?php echo $picture; ?>" alt="User Photo" style="width: 100%; border: 1px solid #ccc;">
                    <form method="post" action="admin-panel.php" enctype="multipart/form-data">
                      <div class="form-group">
                        <input type="file" class="form-control-file" id="photo" name="photo">
                      </div>
                      <button type="submit" class="btn btn-info" name="upload">Upload</button>
                    </form>

                  </div>
                  <div class="col">
                    <div class="row" style="padding: 10px;">
                      <div class="col-5" style="padding-top: 40px;">
                        <h4>General Information:</h4>
                      </div>
                      <div class="col" style="border: 2px solid black; border-radius:10px; padding:10px 10px; font-family: monospace;font-size: 20px;">
                        <ul>
                          <li>First Name: <?php echo $firstName; ?></li>
                          <li>Last Name: <?php echo $lastName; ?></li>
                          <li>Gender: <?php echo $gender; ?></li>
                        </ul>
                      </div>
                    </div>
                    <div class="row" style="padding: 19px;">
                      <div class="col-5" style="padding-top: 40px;">
                        <h4>Additional Information:</h4>
                      </div>
                      <div class="col" style="border: 2px solid black; border-radius:10px; padding:10px 10px; font-family: monospace;font-size: 20px;">
                        <ul>
                          <li>ID: <?php echo $userID; ?></li>
                          <li>Email: <?php echo $email; ?></li>
                          <li>Contact: <?php echo $contact; ?></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php
          } else {
            echo "Failed to Load User Information!.";
          }

          mysqli_close($con);
          ?>


          <div class="tab-pane fade" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
            <div class="container-fluid">
              <div class="card">
                <div class="card-body">
                  <center>
                    <h4>Create an appointment</h4>
                  </center><br>
                  <form class="form-group" method="post" action="admin-panel.php">
                    <div class="row">

                      <!-- <?php

                            $con = mysqli_connect("localhost", "root", "", "prms_db");
                            $query = mysqli_query($con, "select username,spec from doctb");
                            $docarray = array();
                            while ($row = mysqli_fetch_assoc($query)) {
                              $docarray[] = $row;
                            }
                            echo json_encode($docarray);

                            ?> -->


                      <div class="col-md-4">
                        <label for="spec">Specialization:</label>
                      </div>
                      <div class="col-md-8">
                        <select name="spec" class="form-control" id="spec">
                          <option value="" disabled selected>Select Specialization</option>
                          <?php
                          display_specs();
                          ?>
                        </select>
                      </div>

                      <br><br>

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

                      <div class="col-md-4"><label for="doctor">Doctors:</label></div>
                      <div class="col-md-8">
                        <select name="doctor" class="form-control" id="doctor" required="required">
                          <option value="" disabled selected>Select Doctor</option>

                          <?php display_docs(); ?>
                        </select>
                      </div><br /><br />

                      <script>
                        document.getElementById('doctor').onchange = function updateFees(e) {
                          var selection = document.querySelector(`[value=${this.value}]`).getAttribute('data-value');
                          document.getElementById('docFees').value = selection;
                        };
                      </script>
                      <div class="col-md-4"><label for="consultancyfees">
                          Consultancy Fees
                        </label></div>
                      <div class="col-md-8">
                        <!-- <div id="docFees">Select a doctor</div> -->
                        <input class="form-control" type="text" name="docFees" id="docFees" readonly="readonly" />
                      </div><br><br>

                      <div class="col-md-4"><label>Date</label></div>
                      <div class="col-md-8"><input type="date" class="form-control datepicker" name="appdate"></div><br><br>

                      <div class="col-md-4"><label>Time</label></div>
                      <div class="col-md-8">
                        <input type="time" class="form-control" name="apptime">
                      </div><br><br>

                      <div class="col-md-4">
                        <input type="submit" name="app-submit" value="Create new entry" class="btn btn-primary" id="inputbtn">
                      </div>
                      <div class="col-md-8"></div>
                    </div>
                  </form>
                </div>
              </div>
            </div><br>
          </div>

          <div class="tab-pane fade" id="app-hist" role="tabpanel" aria-labelledby="list-pat-list">

            <table class="table table-hover">
              <thead>
                <tr>

                  <th scope="col">Doctor Name</th>
                  <th scope="col">Consultancy Fees</th>
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

                $query = "select ID,doctor,docFees,appdate,apptime,userStatus,doctorStatus from appointmenttb where fname ='$fname' and lname='$lname'";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                  <tr>
                    <td><?php echo $row['doctor']; ?></td>
                    <td><?php echo $row['docFees']; ?></td>
                    <td><?php echo $row['appdate']; ?></td>
                    <td><?php echo $row['apptime']; ?></td>

                    <td>
                      <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) {
                        echo "Active";
                      }
                      if (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) {
                        echo "Cancelled by You";
                      }

                      if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) {
                        echo "Cancelled by Doctor";
                      }
                      ?></td>
                    <td>
                      <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { ?>

                        <a href="admin-panel.php?ID=<?php echo $row['ID'] ?>&cancel=update" onClick="return confirm('Are you sure you want to cancel this appointment ?')" title="Cancel Appointment" tooltip-placement="top" tooltip="Remove"><button class="btn btn-danger">Cancel</button></a>
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

          <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Doctor Name</th>
                  <th scope="col">Appointment ID</th>
                  <th scope="col">Appointment Date</th>
                  <th scope="col">Appointment Time</th>
                  <th scope="col">Diseases</th>
                  <th scope="col">Allergies</th>
                  <th scope="col">Prescriptions</th>
                  <th scope="col">Bill Payment</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $con = mysqli_connect("localhost", "root", "", "prms_db");
                global $con;

                $query = "select doctor,ID,appdate,apptime,disease,allergy,prescription from prestb where pid='$pid';";

                $result = mysqli_query($con, $query);
                if (!$result) {
                  echo mysqli_error($con);
                }


                while ($row = mysqli_fetch_array($result)) {
                ?>
                  <tr>
                    <td><?php echo $row['doctor']; ?></td>
                    <td><?php echo $row['ID']; ?></td>
                    <td><?php echo $row['appdate']; ?></td>
                    <td><?php echo $row['apptime']; ?></td>
                    <td><?php echo $row['disease']; ?></td>
                    <td><?php echo $row['allergy']; ?></td>
                    <td><?php echo $row['prescription']; ?></td>
                    <td>
                      <form method="get">
                        <a href="admin-panel.php?ID=<?php echo $row['ID'] ?>">
                          <input type="hidden" name="ID" value="<?php echo $row['ID'] ?>" />
                          <input type="submit" onclick="alert('Bill Paid Successfully');" name="generate_bill" class="btn btn-success" value="Pay Bill" />
                        </a>
                    </td>
                    </form>
                  </tr>
                <?php }
                ?>
              </tbody>
            </table>
            <br>
          </div>

          <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
          <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
            <form class="form-group" method="post" action="func.php">
              <label>Doctors name: </label>
              <input type="text" name="name" placeholder="Enter doctors name" class="form-control">
              <br>
              <input type="submit" name="doc_sub" value="Add Doctor" class="btn btn-primary">
            </form>
          </div>
          <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js">
  </script>
</body>

</html>