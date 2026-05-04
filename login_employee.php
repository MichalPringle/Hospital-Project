<?php
session_start();
require_once 'db_connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $emailFromForm = $_POST['email'] ?? '';
    $passFromForm  = $_POST['password'] ?? '';

    /
    $sql = "SELECT doctor_id, doctor_name, doctor_password 
            FROM doctors 
            WHERE doctor_email = :email";

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute(['email' => $emailFromForm]);
        $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

        //Verify User
        if ($doctor) {
            // Check if the hashed password matches
            if (password_verify($passFromForm, $doctor['doctor_password'])) {
                
            
                $_SESSION['doctor_id']      = $doctor['doctor_id'];
                $_SESSION['logged_in_user'] = $doctor['doctor_name'];
                $_SESSION['role']           = 'employee'; 

                echo "Login successfully! Welcome Dr. " . $doctor['doctor_name'];
                
                // might implement: redirect to dashboard
                // header("Location: doctor_dashboard.php");
                // exit();
                
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No account found with that email.";
        }
    } catch (PDOException $e) {
        // Log error and stop execution
        die("Query failed: " . $e->getMessage());
    }
}
?>