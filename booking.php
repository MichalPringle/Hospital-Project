<?php

session_start(); //alwasys start session 

//check if user is logged in, if not redirect to login page
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: patient_login.php");
    exit();
}


include "db_connect.php";
//query to fetch doctor names and ids for dropdown
$stmt = $dbh->query("SELECT doctor_id, doctor_name FROM doctors");

?>

<form action ="book_appointment.php" method="POST">
    <label>Select a doctor:</label>
    <select name="doctor_id" required>
        <?php
        //fetch in ASSOC and loop through results to populate dropdown
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<option value='" . $row['doctor_id'] . "'>" . $row['doctor_name'] . "</option>";
        }

        ?>
    </select>
    
    <label>Appointment Date & Time:</label>
    <input type="datetime-local" name="appointment_datetime" required>
    <button type="submit">Book Appointment</button>
</form>