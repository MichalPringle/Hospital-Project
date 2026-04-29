<?php
session_start();
include "db.php";

header("Content-Type: application/json");


// LOGIN USER
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM patients WHERE email = '$email'";
    $result = $conn->query($sql);

    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['patient_password'])) {
            
        // Save session data
        $_SESSION['logged_in_user'] = $row['patient_name'];
        $_SESSION['patient_id'] = $row['patient_id'];
        echo "Login Successful. Welcome, " . $row['patient_name'] . "!";
    } else {
        echo "Invalid login information. Please try again or create an account.";
    }}}
    
?>