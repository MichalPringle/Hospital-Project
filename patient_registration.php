<?php 
session_start(); 
include "db_connect.php"; 
header("Content-Type: application/json"); 

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $name = $_POST['patient_name'] ?? null; 
    $email = $_POST['patient_email'] ?? null; 
    $password = $_POST['patient_password'] ?? null; 
    
    if (!$name || !$email || !$password) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]); 
        exit;
    } 

    if (strlen($password) < 6) {
         echo json_encode(["status" => "error", "message" => "Password must be 6+ chars."]); 
         exit;
    } 

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
     
    $sql = "INSERT INTO patients (patient_name, patient_email, patient_password) VALUES (:name, :email, :pass)"; 
    
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
            'name'  => $name,
            'email' => $email,
            'pass'  => $hashedPassword
        ]);

        echo json_encode(["status" => "success", "message" => "Registration successful."]); 
    } catch (PDOException $e) { 
        echo json_encode(["status" => "error", "message" => "DB Error: " . $e->getMessage()]); 
    } 
    exit;
} 
echo json_encode(["status" => "error", "message" => "Invalid request method."]);
?>