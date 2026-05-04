<?php 
session_start(); 
include "db_connect.php"; 
header("Content-Type: application/json"); 

// CHECK LOGIN STATUS 
if ($_SERVER["REQUEST_METHOD"] === "GET") { 
    if (isset($_SESSION['logged_in_user'])) { 
        echo json_encode([ "status" => "active", "user" => $_SESSION['logged_in_user'] ]);
    } else { 
        echo json_encode([ "status" => "inactive" ]); 
    } 
    exit; 
} 

// REGISTER USER 
if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $name = $_POST['doctor_name'] ?? null; 
    $email = $_POST['doctor_email'] ?? null; 
    $password = $_POST['doctor_password'] ?? null; 
    
    if (!$name || !$email || !$password) {
        echo json_encode([ "status" => "error", "message" => "All fields are required." ]); 
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode([ "status" => "error", "message" => "Password must be at least 6 characters." ]); 
        exit;
    } 

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
     
    // Use Prepared Statements for security
    $sql = "INSERT INTO doctors (doctor_name, doctor_email, doctor_password) VALUES (:name, :email, :pass)"; 
    
    try {
        $stmt = $dbh->prepare($sql);
        $result = $stmt->execute([
            'name' => $name,
            'email' => $email,
            'pass' => $hashedPassword
        ]);

        if ($result) { 
            echo json_encode([ "status" => "success", "message" => "Registration successful." ]); 
        } 
    } catch (PDOException $e) { 
        echo json_encode([ "status" => "error", "message" => "Database error: " . $e->getMessage() ]); 
    }
    exit;
} 
?>