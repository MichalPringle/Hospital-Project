<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    // Kick them to the patient login
    header("Location: patient_login.php");
    exit();
}

include "db_connect.php";

$patient_id = $_SESSION['patient_id']; 

$doctor_id = $_POST['doctor_id'];
$appt_date = $_POST['appt_date'];

$sql = "INSERT INTO appointments (patient_id, doctor_id, appt_date)
         VALUES (:patient_id, :doctor_id, :appt_date)";

$stmt = $dbh->prepare($sql);

$success = $stmt->execute([
    'patient_id' => $patient_id,
    'doctor_id' => $doctor_id,
    'appt_date' => $appt_date
]);

if ($success) {
    echo "Appointment booked successfully!";
} else {
    echo "Error booking appointment.";
}
?>