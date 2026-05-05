<?php
session_start();

require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Capture the data from the form
    $emailFromForm = $_POST['email'] ?? ''; 
    $passFromForm = $_POST['password'] ?? '';

    // SQL query 
    $sql = "SELECT patient_id, patient_name, patient_password FROM patients WHERE patient_email = :email";

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute(['email' => $emailFromForm]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($patient) {
            if (password_verify($passFromForm, $patient['patient_password'])) {
                
                $_SESSION['patient_id'] = $patient['patient_id']; 
                $_SESSION['patient_name'] = $patient['patient_name'];
                $_SESSION['role'] = 'patient';

                header("Location: patient_dashboard.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No account found with that email.";
        }
    } catch (PDOException $e) {
        die("Query failed : " . $e->getMessage());
    }

} else {

    header("Location: homepage.html");
    exit();
}
?>