<?php 
session_start(); 
include "db_connect.php"; 
header("Content-Type: application/json"); 

// CHECK LOGIN STATUS 
if ($_SERVER["REQUEST_METHOD"] === "GET") { 
    if (isset($_SESSION['logged_in_user'])) { 
        echo json_encode([ "status" => "active", "user" => $_SESSION['logged_in_user'] ]);
         } else { echo json_encode([ "status" => "inactive" ]); } 
         exit; 
         } 

// REGISTER USER 
if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $name = $_POST['doctor_name']; 
    $email = $_POST['doctor_email']; 
    $password = $_POST['doctor_password']; 
    
    // Password length check 
    if (strlen($password) < 6) {
         echo json_encode([ "status" => "error", "message" => "Password must be at least 6 characters." ]); 
         exit;
         } 

     // Password protection 
     $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
     
     // Insert user 
     $sql = "INSERT INTO doctors (doctor_name, doctor_email, doctor_password) VALUES ('$name', '$email', '$hashedPassword')"; 
    
     if ($dbh->query($sql)) { 
        echo json_encode([ 
            "status" => "success", 
            "message" => "Registration successful." 
        ]); 
    } else { 
        $error = $dbh->errorInfo();
        echo json_encode([ 
            "status" => "error", 
            "message" => "Database error: " . $error[2]
        ]); 
    } 
} 
        
?>