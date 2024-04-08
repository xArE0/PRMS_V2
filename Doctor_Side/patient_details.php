<?php
$con = mysqli_connect("localhost", "root", "", "prms_db");

// Check if the request is made via POST method and if 'patientID' is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['patientID'])) {
    $patientID = $_POST['patientID'];

    // Query to fetch patient details from the database
    $query_patient = "SELECT * FROM patreg WHERE pid = $patientID";
    $result_patient = mysqli_query($con, $query_patient);

    if ($result_patient) {
        if (mysqli_num_rows($result_patient) > 0) {
            // Fetch patient details
            $row_patient = mysqli_fetch_assoc($result_patient);

            // Format the patient details as HTML
            $patient_details = '
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-4">
                            <!-- User Photo -->
                        </div>
                        <div class="col">
                            <p><strong>Patient ID:</strong> ' . $row_patient['pid'] . '</p>
                            <p><strong>First Name:</strong> ' . $row_patient['fname'] . '</p>
                            <p><strong>Last Name:</strong> ' . $row_patient['lname'] . '</p>
                            <p><strong>Gender:</strong> ' . $row_patient['gender'] . '</p>
                            <p><strong>Email:</strong> ' . $row_patient['email'] . '</p>
                        </div>
                    </div>
                </div>
            ';

            // Query to fetch prescriptions for the patient
            $query_prescriptions = "SELECT * FROM prestb WHERE pid = $patientID";
            $result_prescriptions = mysqli_query($con, $query_prescriptions);

            if ($result_prescriptions) {
                // Construct the table for prescriptions
                $prescription_table = '
                    <div class="row">
                        <div class="col">
                            <h4>Prescriptions</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Prescription ID</th>
                                        <th>Disease</th>
                                        <th>Allergy</th>
                                        <th>Prescription</th>
                                    </tr>
                                </thead>
                                <tbody>
                ';

                while ($row_prescription = mysqli_fetch_assoc($result_prescriptions)) {
                    // Add each prescription to the table
                    $prescription_table .= '
                        <tr>
                            <td>' . $row_prescription['ID'] . '</td>
                            <td>' . $row_prescription['disease'] . '</td>
                            <td>' . $row_prescription['allergy'] . '</td>
                            <td>' . $row_prescription['prescription'] . '</td>
                        </tr>
                    ';
                }

                $prescription_table .= '
                                </tbody>
                            </table>
                        </div>
                    </div>
                ';

                // Combine patient details and prescription table
                echo $patient_details . $prescription_table;
            } else {
                echo "Error retrieving prescriptions: " . mysqli_error($con);
            }
        } else {
            echo "No patient found with ID: " . $patientID;
        }
    } else {
        echo "Error retrieving patient details: " . mysqli_error($con);
    }
} else {
    echo "Invalid request!";
}
?>