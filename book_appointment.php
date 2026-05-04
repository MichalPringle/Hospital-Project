<?php
session_start();

// Security Check
if (!isset($_SESSION['patient_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login_patient.php");
    exit();
}

include "db_connect.php";

//Only run if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Capture from Session
    $patient_id = $_SESSION['patient_id']; 

    // Capture from Form 
    $doctor_name = $_POST['Doctor'] ?? '';
    $appt_date   = $_POST['Appointment_date'] ?? '';
    $appt_time   = $_POST['Appointment_time'] ?? '';

    try {
        //Find the ID for the name "Dr. XXX"
        $docLookup = $dbh->prepare("SELECT doctor_id FROM doctors WHERE doctor_name = :name");
        $docLookup->execute(['name' => $doctor_name]);
        $doctor = $docLookup->fetch(PDO::FETCH_ASSOC);

        if ($doctor) {
            $doctor_id = $doctor['doctor_id'];

            // add appt time
            $sql = "INSERT INTO appointments (patient_id, doctor_id, appt_date, appt_time)
                    VALUES (:p_id, :d_id, :a_date, :a_time)";

            $stmt = $dbh->prepare($sql);
            $stmt->execute([
                'p_id'   => $patient_id,
                'd_id'   => $doctor_id,
                'a_date' => $appt_date,
                'a_time' => $appt_time
            ]);

            echo "<h2>Appointment booked successfully!</h2>";
            echo "<a href='booking.php'>Book another</a>";
        } else {
            echo "Error: Doctor not found in database.";
        }

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>