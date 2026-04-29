<?php 
session_start(); 
include "db.php"; 
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
    $name = $_POST['name']; 
    $email = $_POST['email']; 
    $password = $_POST['password']; 
    
    // Password length check 
    if (strlen($password) < 6) {
         echo json_encode([ "status" => "error", "message" => "Password must be at least 6 characters." ]); 
         exit;
         } 

     // Password protection 
     $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
     
     // Insert user 
     $sql = "INSERT INTO patients (patient_name, email, patient_password) VALUES ('$name', '$email', '$hashedPassword')"; 
    
     if ($conn->query($sql) === TRUE) { 
        echo json_encode([ 
            "status" => "success", 
            "message" => "Registration successful." 
        ]); 
    } else { 
        echo json_encode([ 
            "status" => "error", 
            "message" => $conn->error 
        ]); 
    } 

        $conn->close(); } 
        
        ?>