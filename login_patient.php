<?php

//start a session
session_start();

//run connection in this file
require_once 'db_connect.php';

//capture the following area from form html
$emailFromForm = $_POST['email'];
$passFromForm = $_POST['password'];

//sql query blueprint
$sql = "SELECT patient_id, patient_name, patient_password FROM patients WHERE email = :email";


try {
    //prepare query
    $stmt = $dbh->prepare($sql);

    //execute the query
    $stmt->execute(['email' => $emailFromForm]);

    //grab the result, in ASSOC 
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if($patient) {

         if(password_verify($passFromForm, $patient['patient_password'])) {

            $_SESSION['patient_id'] = $patient['patient_id'];
            $_SESSION['patient_name'] = $patient['patient_name'];

            echo "Login successfully! Welcome " . $patient['patient_name'];
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that email";
    }

}catch (PDOException $e) {
    die("Query failed : " . $e->getMessage());
}
?>
