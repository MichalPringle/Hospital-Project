<?php

session_start(); //alwasys start session 

// Check if user is logged in and has the 'patient' role
if (!isset($_SESSION['patient_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login_patient.php");
    exit();
}


include "db_connect.php";
//query to fetch doctor names and ids for dropdown
$stmt = $dbh->query("SELECT doctor_id, doctor_name FROM doctors");

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Hospital Management System</title>
    <link href="Style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="navbar">
        <ul>
            <li><a href="homepage.html">Home</a></li>
            <li><a href="homepage.html#Patientlogin">Patient Login</a></li>
            <li><a href="homepage.html#Employeelogin">Employee Login</a></li>
            <li><a href="homepage.html#About">About</a></li>
        </ul>
    </div>
    <h1>Book Appointment</h1>
    <div class="section">
        <form action="book_appointment.php" method="POST">
            <label>Patient Name:</label>
            <input type="text" name="name" placeholder="Enter your name">

            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter your email">
            <div class="bookingrow">
                <div class="formgroup">
                    <label for="clinic">Clinic: </label>
                    <select name="clinic" id="clinic" onchange="updateDoctors()" required>
                        <option value="">Select Clinic</option>
                        <option value="Internal Medicine">Internal Medicine</option>
                        <option value="Emergency Medicine">Emergency Medicine</option>
                        <option value="Cardiology">Cardiology</option>
                        <option value="Neurology">Neurology</option>
                        <option value="Orthopaedics">Orthopaedics</option>
                        <option value="Oncology">Oncology</option>
                        <option value="Pediatrics">Pediatrics</option>
                        <option value="Physical Therapy">Physical Therapy</option>
                    </select>
                </div>
                <div class="formgroup">
                    <label for="Doctor">Doctor: </label>
                    <select name="Doctor" id="Doctor" required>
                        <option value="">Select Doctor</option>
                    </select>
                </div>
            </div>
            <label>Appointment Date:</label>
            <input type="date" id="date" name="Appointment_date" required>

            <label>Appointment Time:</label>
            <input type="time" id="time" name="Appointment_time" required>
            <div class="buttongroup">
                <button type="submit" class="createappt">Create Appointment</button>
                <button type="reset" class="createappt">Reset Form</button>

            </div>
    </div>
    <script>
    function updateDoctors() {
        const clinicSelect = document.getElementById("clinic");
        const doctorSelect = document.getElementById("Doctor");
        const selectedClinic = clinicSelect.value;

        // Cleaned up data mapping
        const doctorData = {
            "Cardiology": ["Michael Jordan"],
            "Internal Medicine": ["Donatello Rivera"],
            "Neurology": ["Jayla Whittaker"],
            "Orthopaedics": ["Steph Curry"],
            "Oncology": ["Madison Lumley"],
            "Emergency Medicine": ["Rebecca Black"],
            "Pediatrics": ["Hellen Tray"],
            "Physical Therapy": ["Sarah Hyland"]
        };

        // Clear out current options
        doctorSelect.innerHTML = '<option value="">Select Doctor</option>';

        // If a clinic is selected, populate the doctors
        if (selectedClinic && doctorData[selectedClinic]) {
            doctorData[selectedClinic].forEach(doctor => {
                let option = document.createElement("option");
                option.value = doctor;
                option.textContent = doctor;
                doctorSelect.appendChild(option);
            });
        }
    }
</script>
</body>
