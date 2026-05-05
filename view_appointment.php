<?php
session_start();
include "db_connect.php";

// Security Check
if (!isset($_SESSION['patient_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: homepage.html");
    exit();
}

$patient_id = $_SESSION['patient_id'];

try {
    // JOIN allows us to get the doctor name from the doctors table
    $sql = "SELECT a.appt_date, a.appt_time, d.doctor_name, d.doctor_email 
            FROM appointments a
            JOIN doctors d ON a.doctor_id = d.doctor_id
            WHERE a.patient_id = :p_id
            ORDER BY a.appt_date ASC";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(['p_id' => $patient_id]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error fetching appointments: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="patient_dashboard.php">Dashboard</a></li>
            <li><a href="booking.php">Book New</a></li>
            <li style="float:right"><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="section">
        <h1>Your Scheduled Appointments</h1>

        <?php if (count($appointments) > 0): ?>
            <table border="1" style="width:100%; border-collapse: collapse; margin-top: 20px; text-align: left;">
                <tr style="background-color: #ffffff;">
                    <th style="padding: 10px;">Date</th>
                    <th style="padding: 10px;">Time</th>
                    <th style="padding: 10px;">Doctor</th>
                </tr>
                <?php foreach ($appointments as $app): ?>
                    <tr>
                        <td style="padding: 10px;"><?php echo htmlspecialchars($app['appt_date']); ?></td>
                        <td style="padding: 10px;"><?php echo htmlspecialchars($app['appt_time']); ?></td>
                        <td style="padding: 10px;">Dr. <?php echo htmlspecialchars($app['doctor_name']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>You have no appointments scheduled. <a href="booking.php">Book one now!</a></p>
        <?php endif; ?>
        
        <br>
        <a href="patient_dashboard.php" class="createappt" style="text-decoration:none;">Back to Dashboard</a>
    </div>
</body>
</html>