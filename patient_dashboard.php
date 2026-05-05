<?php
session_start();

// check security 
if (!isset($_SESSION['patient_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: homepage.html");
    exit();
}

include "db_connect.php";

// Fetch the patient name using the correct session key
try {
    $sql = "SELECT patient_name FROM patients WHERE patient_id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['id' => $_SESSION['patient_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If for some reason the patient is gone from DB, logout
    if (!$user) {
        header("Location: logout.php");
        exit();
    }
} catch (PDOException $e) {
    die("Error fetching user data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

    <div class="navbar">
        <ul>
            <li><a href="homepage.html">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <<div class="section">
    <h1>Welcome, <?php echo htmlspecialchars($user['patient_name']); ?>!</h1>
    
    <div class="dashboard-menu">
        <p><a href="booking.php" class="btn">Book New Appointment</a></p>
        
        <p><a href="view_appointment.php" class="btn">View Appointments</a></p>
        
        <p><a href="logout.php" class="btn logout">Logout</a></p>
    </div>
</div>
</body>
</html>