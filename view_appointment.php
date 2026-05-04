<?php

session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: employee_login.php");
    exit();
}

include "db_connect.php";

$sql = "SELECT appointments.appt_date, doctors.doctor_name 
        FROM appointments 
        INNER JOIN doctors ON appointments.doctor_id = doctors.doctor_id 
        WHERE appointments.patient_id = :p_id";

$stmt = $dbh->prepare($sql);
$stmt->execute(['p_id' => $_SESSION['user_id']]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
</head>
<body>
    <h2>Your Scheduled Appointments</h2>

    <table border="1">
        <tr>
            <th>Doctor Name</th>
            <th>Date & Time</th>
        </tr>

        <?php 
       
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['doctor_name'] . "</td>";
            echo "<td>" . $row['appt_date'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <p><a href="booking.php">Book another appointment</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>