<?php

//start a session
session_start();

//run connection in this file
require_once 'db_connect.php';

//capture the following area from form html
$emailFromForm = $_POST['email'];
$passFromForm = $_POST['password'];

//sql query blueprint
$sql = "SELECT doctor_id, doctor_name, doctor_password FROM doctors WHERE doctor_email = :email";


try {
    //prepare query
    $stmt = $dbh->prepare($sql);

    //execute the query
    $stmt->execute(['email' => $emailFromForm]);

    //grab the result, in ASSOC 
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if($doctor) {

         if($passFromForm == $doctor['doctor_password']) {

            $_SESSION['doctor_id'] = $doctor['doctor_id'];
            $_SESSION['doctor_name'] = $doctor['doctor_name'];

            echo "Login successfully! Welcome Dr. " . $doctor['doctor_name'];
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
