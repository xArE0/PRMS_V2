<?php
$con = mysqli_connect("localhost", "root", "", "prms_db");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['patientID'])) {
    $patientID = $_POST['patientID'];

    $query_appointments = "SELECT appointmenttb.ID, appointmenttb.appdate, appointmenttb.apptime, appointmenttb.doctor, appointmenttb.docFees, record.*, image.picture
    FROM appointmenttb
    LEFT JOIN record ON appointmenttb.ID = record.ID
    LEFT JOIN image ON appointmenttb.ID = image.ID
    WHERE appointmenttb.pid = $patientID
    GROUP BY appointmenttb.ID";

    $result_appointments = mysqli_query($con, $query_appointments);

    if ($result_appointments) {
        $appointment_list = '<div class="col-md-12"><h3>Appointments</h3><table class="table"><thead><tr><th>Appointment Date</th><th>Appointment Time</th><th>Doctor</th><th>Blood Type</th><th>Blood Pressure</th><th>Weight</th></tr></thead><tbody>';

        while ($row_appointment = mysqli_fetch_assoc($result_appointments)) {
            // Add each appointment to the table with appointment ID
            $appointment_list .= '<tr class="open-modal" data-appointmentid="' . $row_appointment['ID'] . '"><td>' . $row_appointment['appdate'] . '</td><td>' . $row_appointment['apptime'] . '</td><td>' . $row_appointment['doctor'] . '</td><td>' . $row_appointment['blood_type'] . '</td><td>' . $row_appointment['blood_pressure'] . '</td><td>' . $row_appointment['weight'] . '</td></tr>';
        }

        $appointment_list .= '</tbody></table></div>';

        // Return the HTML content of the appointment list
        echo $appointment_list;
    } else {
        echo "Error retrieving appointments: " . mysqli_error($con);
    }
} else {
    echo "Invalid request!";
}
?>
