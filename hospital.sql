CREATE DATABASE hospital;
CREATE TABLE patients (
patient_id INT PRIMARY KEY AUTO_INCREMENT, patient_name VARCHAR(100) NOT NULL, email VARCHAR(250) UNIQUE NOT NULL , patient_password VARCHAR(250) NOT NULL);
CREATE TABLE doctors (
doctor_id INT PRIMARY KEY AUTO_INCREMENT, doctor_name VARCHAR(100) NOT NULL, specialty VARCHAR(250));
CREATE TABLE appointments (
appt_id INT PRIMARY KEY AUTO_INCREMENT, doctor_id INT NOT NULL, patient_id INT NOT NULL, appt_date DATETIME NOT NULL, FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id), FOREIGN KEY (patient_id) REFERENCES patients(patient_id));
CREATE TABLE availability (
availability_id INT PRIMARY KEY AUTO_INCREMENT, doctor_id INT NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday') NOT NULL, FOREIGN KEY (doctor_id) REFERENCES doctors (doctor_id));

INSERT INTO patients (patient_name, email, patient_password)  VALUES ('Mark Zepplin', 'MZ70@gmail.com', 'MarkZ@1970');
INSERT INTO patients (patient_name, email, patient_password) VALUES ('Peter Pan', 'PanMan3000@gmail.com', '123654');
INSERT INTO patients (patient_name, email, patient_password) VALUES ('Sarah Hyland', 'SarahH@yahoo.com', '12345');
INSERT INTO patients (patient_name, email, patient_password) VALUES ('Jackie Chan', 'RushHour3@gmail.com', '63212');
INSERT INTO patients (patient_name, email, patient_password) VALUES ('Chris Tucker', 'ChrisT@yahoo.com', '676767');
INSERT INTO patients (patient_name, email, patient_password) VALUES ('Dave Chapelle',  'DaveChap02@yahoo.com', 'W2HFR569');

INSERT INTO doctors (doctor_name, specialty) VALUES ('Donatello Rivera', 'Internal Medicine');
INSERT INTO doctors (doctor_name, specialty) VALUES ('Rebecca Black', 'Emergency Medicine');
INSERT INTO doctors (doctor_name, specialty) VALUES ('Michael Jordan', 'Cardiology');
INSERT INTO doctors (doctor_name, specialty) VALUES ('Jayla Whittaker', 'Neurology');
INSERT INTO doctors (doctor_name, specialty) VALUES ('Steph Curry', 'Orthopaedics');
INSERT INTO doctors (doctor_name, specialty) VALUES ('Madison Lumley', 'Oncology');

ALTER TABLE doctors ADD doctor_email varchar(255); 
ALTER TABLE doctors ADD doctor_password varchar(255);
