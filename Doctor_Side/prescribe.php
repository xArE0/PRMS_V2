<!DOCTYPE html>
<?php
// This block throws error but works somehow so......
include('../func1.php');

$doctor = $_SESSION['dname'];
$fname = $_GET['fname'];
$lname = $_GET['lname'];

if (isset($_POST['prescribe'])) {
  $disease = $_POST['disease'];
  $allergy = $_POST['allergy'];
  $prescription = $_POST['prescription'];
  $pid = $_POST['pid'] ?? '';
  $ID = $_POST['ID'] ?? '';
  $fname = $_POST['fname'] ?? '';
  $lname = $_POST['lname'] ?? '';
  $appdate = $_POST['appdate'] ?? '';
  $apptime = $_POST['apptime'] ?? '';

  $query = "INSERT INTO prestb (doctor, pid, ID, fname, lname, appdate, apptime, disease, allergy, prescription) 
              VALUES ('$doctor', '$pid', '$ID', '$fname', '$lname', '$appdate', '$apptime', '$disease', '$allergy', '$prescription')";
  $result = mysqli_query($con, $query);

  if ($result) {
    echo "<script>alert('Done');window.location.href = 'doctor-panel1.php';</script>";
  }
}
?>

<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
  <meta name="viewport" content="width=device-width, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <!-- Bootstrap CSS -->

  <link rel="stylesheet" href="../vendor/fontawesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i>PRMS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <style>
      .bg-primary {
        background: -webkit-linear-gradient(left, #6358ba, #005c76);
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

      .btn-primary {
        background-color: #3c50c1;
        border-color: #3c50c1;
      }
    </style>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="../Doctor_Side/logout1.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>

        </li>
        <li class="nav-item">
          <a class="nav-link" href="../Doctor_Side/doctor-panel1.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Back</a>
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
    <h3 style="margin-left: 40%;  padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> Prescribe <?php echo $fname . ' ';
                                                                                                              echo $lname; ?>
    </h3>

    <div class="tab-pane" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
      <form class="form-group" name="prescribeform" method="post" action="../Doctor_Side/prescribe.php">

        <div class="row">
          <div class="col-md-4"><label>Disease:</label></div>
          <div class="col-md-8">
            <textarea id="disease" cols="86" rows="5" name="disease" required></textarea>
          </div><br><br><br>

          <div class="col-md-4"><label>Allergies:</label></div>
          <div class="col-md-8">
            <textarea id="allergy" cols="86" rows="5" name="allergy" required></textarea>
          </div><br><br><br>
          <div class="col-md-4"><label>Prescription:</label></div>
          <div class="col-md-8">
            <textarea id="prescription" cols="86" rows="10" name="prescription" required></textarea>
          </div><br><br><br>
          <input type="hidden" name="pid" value="<?php echo htmlspecialchars($_GET['pid']); ?>">
          <input type="hidden" name="ID" value="<?php echo htmlspecialchars($_GET['ID']); ?>">
          <input type="hidden" name="fname" value="<?php echo htmlspecialchars($_GET['fname']); ?>">
          <input type="hidden" name="lname" value="<?php echo htmlspecialchars($_GET['lname']); ?>">
          <input type="hidden" name="appdate" value="<?php echo htmlspecialchars($_GET['appdate']); ?>">
          <input type="hidden" name="apptime" value="<?php echo htmlspecialchars($_GET['apptime']); ?>">

          <br><br><br><br>
          <button type="submit" name="prescribe" value="prescribe" class="btn btn-success" style="margin-left: 40pc;">Prescribe</button>
      </form>
      <br>
    </div>
  </div>
  </div>