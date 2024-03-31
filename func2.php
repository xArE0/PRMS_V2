<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "prms_db");
if (isset($_POST['patsub1'])) {
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $gender = $_POST['gender'];
  $email = $_POST['email'];
  $contact = $_POST['contact'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];

  $check_query = "SELECT * FROM patreg WHERE email='$email'";
  $check_result = mysqli_query($con, $check_query);
  if (mysqli_num_rows($check_result) > 0) {
    echo "<script> alert('An account with this email already exists');window.location.href = 'Patient_Side/admin-panel.php';</script>";
    exit();
  }

  if ($password == $cpassword) {
    $query = "INSERT INTO patreg(fname,lname,gender,email,contact,password,cpassword) VALUES ('$fname','$lname','$gender','$email','$contact','$password','$cpassword')";
    $result = mysqli_query($con, $query);
    if ($result) {
      $_SESSION['username'] = $fname . " " . $lname;
      $_SESSION['fname'] = $fname;
      $_SESSION['lname'] = $lname;
      $_SESSION['gender'] = $gender;
      $_SESSION['contact'] = $contact;
      $_SESSION['email'] = $email;
      header("Location: admin-panel.php");
      exit();
    } else {
      echo "<script> alert('Error Registrating');window.location.href = 'index.php';</script>";
      exit();
    }
  } else {
    echo "<script> alert('Passwords Don't Match. Try Again! ');window.location.href = 'index.php';</script>";
    exit();
  }
}

if (isset($_POST['update_data'])) {
  $contact = $_POST['contact'];
  $status = $_POST['status'];
  $query = "update appointmenttb set payment='$status' where contact='$contact';";
  $result = mysqli_query($con, $query);
  if ($result)
    header("Location:updated.php");
}


if (isset($_POST['doc_sub'])) {
  $name = $_POST['name'];
  $query = "insert into doctb(name)values('$name')";
  $result = mysqli_query($con, $query);
  if ($result)
    header("Location:adddoc.php");
}
?>
