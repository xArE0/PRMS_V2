DROP DATABASE prms_db;

CREATE DATABASE IF NOT EXISTS prms_db;

USE prms_db;

-- Clear Data
TRUNCATE prms_db.admintb;
TRUNCATE prms_db.appointmenttb;
TRUNCATE prms_db.contact;
TRUNCATE prms_db.doctb;
TRUNCATE prms_db.patreg;
TRUNCATE prms_db.prestb;

-- Creating Database
CREATE TABLE prms_db.record(
  rid INT PRIMARY KEY AUTO_INCREMENT,
  blood_type VARCHAR(20) NOT NULL,
  blood_pressure VARCHAR(30) NOT NULL,
  weight VARCHAR(30) NOT NULL,
  other VARCHAR(100) NOT NULL
);

CREATE TABLE prms_db.image(
  iid INT PRIMARY KEY AUTO_INCREMENT,
  pname VARCHAR(30) NOT NULL,
  picture LONGBLOB DEFAULT NULL 
);

CREATE TABLE prms_db.patreg (
  pid INT(11) PRIMARY KEY AUTO_INCREMENT,
  fname VARCHAR(20) NOT NULL,
  lname VARCHAR(20) NOT NULL,
  gender VARCHAR(10) NOT NULL,
  dob DATE NOT NULL,
  email VARCHAR(30) NOT NULL,
  contact VARCHAR(10) NOT NULL,
  password VARCHAR(30) NOT NULL,
  cpassword VARCHAR(30) NOT NULL,
  picture LONGBLOB DEFAULT NULL,
  active_status INT NOT NULL DEFAULT 1,
  iid INT DEFAULT NULL,
  FOREIGN KEY (iid) REFERENCES image(iid)
);

CREATE TABLE prms_db.appointmenttb (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  pid INT NOT NULL,  
  fname VARCHAR(20) NOT NULL,
  lname VARCHAR(20) NOT NULL,
  gender VARCHAR(10) NOT NULL,
  email VARCHAR(30) NOT NULL,
  contact VARCHAR(10) NOT NULL,
  doctor VARCHAR(30) NOT NULL,
  docFees INT NOT NULL,
  appdate DATE NOT NULL,
  apptime TIME NOT NULL,
  userStatus INT NOT NULL DEFAULT 1,
  doctorStatus INT NOT NULL DEFAULT 1,
  receptStatus INT NOT NULL DEFAULT 1,
  approve_status INT NOT NULL DEFAULT 0,
  rid INT DEFAULT NULL,
  FOREIGN KEY (rid) REFERENCES record(rid)
);

CREATE TABLE prms_db.admintb (
  aid INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(30) NOT NULL
);

CREATE TABLE prms_db.contact (
  cid INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(30) NOT NULL,
  email text NOT NULL,
  contact VARCHAR(10) NOT NULL,
  message VARCHAR(200) NOT NULL
);

CREATE TABLE prms_db.doctb (
  docid INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  spec VARCHAR(50) NOT NULL,
  docFees INT(10) NOT NULL,
  picture LONGBLOB DEFAULT NULL,
  working_status INT NOT NULL DEFAULT 1
);

CREATE TABLE prms_db.prestb (
  doctor VARCHAR(50) NOT NULL,
  pid INT(11) NOT NULL,
  ID INT(11) NOT NULL,
  fname VARCHAR(50) NOT NULL,
  lname VARCHAR(50) NOT NULL,
  appdate DATE NOT NULL,
  apptime TIME NOT NULL,
  disease VARCHAR(250) NOT NULL,
  allergy VARCHAR(250) NOT NULL,
  prescription VARCHAR(1000) NOT NULL
);


-- Dummy data for prms_db.record
INSERT INTO prms_db.record (rid,blood_type, blood_pressure, weight, other) VALUES
  (1,'A+', '120/80', '75 kg', 'No known medical conditions'),
  (2,'B-', '110/70', '68 kg', 'Allergic to peanuts'),
  (3,'O+', '130/90', '82 kg', 'Diabetic'),
  (4,'AB+', '125/85', '72 kg', 'High cholesterol');

-- Dummy data for prms_db.image
INSERT INTO prms_db.image (iid,pname, picture) VALUES
  (1,'John Doe', LOAD_FILE('/path/to/image1.jpg')),
  (2,'Jane Smith', LOAD_FILE('/path/to/image2.jpg')),
  (3,'Michael Johnson', LOAD_FILE('/path/to/image3.jpg')),
  (4,'Emily Davis', LOAD_FILE('/path/to/image4.jpg'));

-- Dummy data for prms_db.patreg
INSERT INTO prms_db.patreg (fname, lname, gender, dob, email, contact, password, cpassword, picture, iid) VALUES
  ('John', 'Doe', 'Male', '1985-06-15', 'john.doe@example.com', '1234567890', 'password123', 'password123', LOAD_FILE('/path/to/image1.jpg'), 1),
  ('Jane', 'Smith', 'Female', '1992-09-20', 'jane.smith@example.com', '0987654321', 'password456', 'password456', LOAD_FILE('/path/to/image2.jpg'), 2),
  ('Michael', 'Johnson', 'Male', '1978-03-01', 'michael.johnson@example.com', '5555555555', 'password789', 'password789', LOAD_FILE('/path/to/image3.jpg'), 3),
  ('Emily', 'Davis', 'Female', '1990-11-12', 'emily.davis@example.com', '9999999999', 'passwordabc', 'passwordabc', LOAD_FILE('/path/to/image4.jpg'), 4);

-- Dummy data for prms_db.appointmenttb
INSERT INTO prms_db.appointmenttb (pid, fname, lname, gender, email, contact, doctor, docFees, appdate, apptime, rid) VALUES
  (1, 'John', 'Doe', 'Male', 'john.doe@example.com', '1234567890', 'Dr. Smith', 100, '2023-05-01', '10:00:00', 1),
  (2, 'Jane', 'Smith', 'Female', 'jane.smith@example.com', '0987654321', 'Dr. Johnson', 120, '2023-05-15', '14:30:00', 2),
  (3, 'Michael', 'Johnson', 'Male', 'michael.johnson@example.com', '5555555555', 'Dr. Davis', 150, '2023-06-01', '09:00:00', 3),
  (4, 'Emily', 'Davis', 'Female', 'emily.davis@example.com', '9999999999', 'Dr. Smith', 100, '2023-06-20', '16:00:00', 4);

-- Dummy data for prms_db.admintb
INSERT INTO prms_db.admintb (username, password) VALUES
  ('admin', 'password123'),
  ('superadmin', 'password456');

-- Dummy data for prms_db.contact
INSERT INTO prms_db.contact (name, email, contact, message) VALUES
  ('John Doe', 'john.doe@example.com', '1234567890', 'I have a question about my appointment.'),
  ('Jane Smith', 'jane.smith@example.com', '0987654321', 'I need to cancel my appointment.'),
  ('Michael Johnson', 'michael.johnson@example.com', '5555555555', 'I have a suggestion for the website.'),
  ('Emily Davis', 'emily.davis@example.com', '9999999999', 'I would like to schedule a new appointment.');

-- Dummy data for prms_db.doctb
INSERT INTO prms_db.doctb (username, password, email, spec, docFees, picture) VALUES
  ('Dr.Smith', 'password123', 'dr.smith@example.com', 'General Practitioner', 100, LOAD_FILE('/path/to/image5.jpg')),
  ('Dr.Johnson', 'password456', 'dr.johnson@example.com', 'Cardiologist', 150, LOAD_FILE('/path/to/image6.jpg')),
  ('Dr.Davis', 'password789', 'dr.davis@example.com', 'Pediatrician', 120, LOAD_FILE('/path/to/image7.jpg')),
  ('Dr.Lee', 'passwordabc', 'dr.lee@example.com', 'Dermatologist', 180, LOAD_FILE('/path/to/image8.jpg'));

-- Dummy data for prms_db.prestb
INSERT INTO prms_db.prestb (doctor, pid, ID, fname, lname, appdate, apptime, disease, allergy, prescription) VALUES
  ('Dr.Smith', 1, 1, 'John', 'Doe', '2023-05-01', '10:00:00', 'Common cold', 'None', 'Paracetamol, Decongestant'),
  ('Dr.Johnson', 2, 2, 'Jane', 'Smith', '2023-05-15', '14:30:00', 'High blood pressure', 'Penicillin', 'Antihypertensive medication'),
  ('Dr.Davis', 3, 3, 'Michael', 'Johnson', '2023-06-01', '09:00:00', 'Asthma', 'Dust mites', 'Inhaler, Antihistamine'),
  ('Dr.Smith', 4, 4, 'Emily', 'Davis', '2023-06-20', '16:00:00', 'Acne', 'None', 'Topical medication, Oral antibiotics');