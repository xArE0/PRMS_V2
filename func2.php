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
    echo "<script> alert('An account with this email already exists');window.location.href = 'index.php';</script>";
    exit();
  }

  if ($password == $cpassword) {
    $query = "INSERT INTO patreg(fname,lname,gender,email,contact,password,cpassword) VALUES ('$fname','$lname','$gender','$email','$contact','$password','$cpassword')";
    $result = mysqli_query($con, $query);
    if ($result) {
      echo "<script> alert('Registration Successful');window.location.href = 'index.php';</script>";
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
mysqli_close($con);
?>

<!-- PHP script (upload.php) to handle image upload -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
    $image = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);

    $con = mysqli_connect("localhost", "root", "", "prms_db");

    $query = "INSERT INTO patreg(picture) VALUES (?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "b", $image);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
      echo "Image uploaded successfully.";
    } else {
      echo "Failed to upload image.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
  } else {
    echo "Error uploading image.";
  }
}
?>