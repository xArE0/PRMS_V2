<?php
include('../func1.php');

$doctor = $_SESSION['dname'];

if (isset($_POST['prescribe'])) {
  $disease = $_POST['disease'];
  $allergies = $_POST['allergies'];
  $prescription = $_POST['prescription'];
  $bloodType = $_POST['bloodType'];
  $bloodPressure = $_POST['bloodPressure'];
  $weight = $_POST['weight'];
  $other = $_POST['other'];
  $pid = $_POST['pid'];
  $ID = $_POST['ID'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $appdate = $_POST['appdate'];
  $apptime = $_POST['apptime'];

  // Insert data into record table
  $queryRecord = "INSERT INTO record (blood_type, blood_pressure, weight, other, ID) 
                    VALUES ('$bloodType', '$bloodPressure', '$weight', '$other', '$ID')";
  $resultRecord = mysqli_query($con, $queryRecord);

  // Insert data into prestb table
  $queryPrescribe = "INSERT INTO prestb (doctor, pid, ID, fname, lname, appdate, apptime, disease, allergy, prescription) 
                      VALUES ('$doctor', '$pid', '$ID', '$fname', '$lname', '$appdate', '$apptime', '$disease', '$allergies', '$prescription')";
  $resultPrescribe = mysqli_query($con, $queryPrescribe);

  if ($resultPrescribe) {
    echo "<script>alert('Prescription added successfully');window.location.href = 'doctor-panel1.php';</script>";
  } else {
    echo "<script>alert('Error: Prescription not added');window.location.href = 'doctor-panel1.php';</script>";
  }
}

mysqli_close($con);
?>