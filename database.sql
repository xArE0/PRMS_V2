DROP DATABASE prms_db;

CREATE DATABASE IF NOT EXISTS prms_db;

USE prms_db;

-- Clear Data
TRUNCATE prms_db.admintb;
TRUNCATE prms_db.appointmenttb;
TRUNCATE prms_db.contact;
TRUNCATE prms_db.doctb;
TRUNCATE prms_db.patreg;
TRUNCATE prms_db.prestb;v
TRUNCATE prms_db.image;
-- Creating Database

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
  approve_status INT NOT NULL DEFAULT 0
);

CREATE TABLE prms_db.record(
  rid INT PRIMARY KEY AUTO_INCREMENT,
  blood_type VARCHAR(20) NOT NULL,
  blood_pressure VARCHAR(30) NOT NULL,
  weight VARCHAR(30) NOT NULL,
  other VARCHAR(100) NOT NULL,
  ID INT NOT NULL,
  FOREIGN KEY (ID) REFERENCES appointmenttb(ID)
);

CREATE TABLE prms_db.image(
  iid INT PRIMARY KEY AUTO_INCREMENT,
  pname VARCHAR(30) NOT NULL,
  picture LONGBLOB DEFAULT NULL,
  ID INT NOT NULL,
  FOREIGN KEY (ID) REFERENCES appointmenttb(ID)
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
  active_status INT NOT NULL DEFAULT 1
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
-- Insert dummy data into admintb table
INSERT INTO admintb (username, password) 
VALUES 
('admin1', 'adminpassword1'),
('admin2', 'adminpassword2'),
('admin3', 'adminpassword3'),
('admin4', 'adminpassword4'),
('admin5', 'adminpassword5');

-- Insert dummy data into contact table
INSERT INTO contact (name, email, contact, message) 
VALUES 
('John Doe', 'john.doe@example.com', '1234567890', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'),
('Alice Smith', 'alice.smith@example.com', '9876543210', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
('Michael Brown', 'michael.brown@example.com', '1234567890', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'),
('Emily Jones', 'emily.jones@example.com', '9876543210', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'),
('David Taylor', 'david.taylor@example.com', '1234567890', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

-- Insert dummy data into doctb table
INSERT INTO prms_db.doctb (username, password, email, spec, docFees, working_status) 
VALUES 
('doctora', 'doctorpassword1', 'doctor1@example.com', 'Cardiologist', 100, 1),
('doctorb', 'doctorpassword2', 'doctor2@example.com', 'Dermatologist', 120, 1),
('doctorc', 'doctorpassword3', 'doctor3@example.com', 'Pediatrician', 90, 1),
('doctord', 'doctorpassword4', 'doctor4@example.com', 'Oncologist', 150, 1),
('doctore', 'doctorpassword5', 'doctor5@example.com', 'Neurologist', 110, 1);

-- Insert dummy data into prestb table
INSERT INTO prestb (doctor, pid, ID, fname, lname, appdate, apptime, disease, allergy, prescription) 
VALUES 
('Dr. Smith', 1, 1, 'John', 'Doe', '2024-04-15', '10:00:00', 'Fever', 'None', 'Paracetamol 500mg'),
('Dr. Johnson', 2, 2, 'Alice', 'Smith', '2024-04-16', '11:30:00', 'Allergy', 'Peanuts', 'Antihistamines'),
('Dr. Lee', 3, 3, 'Michael', 'Brown', '2024-04-17', '12:00:00', 'Headache', 'None', 'Rest and fluids'),
('Dr. Martinez', 4, 4, 'Emily', 'Jones', '2024-04-18', '13:30:00', 'Injury', 'None', 'Painkillers and rest'),
('Dr. White', 5, 5, 'David', 'Taylor', '2024-04-19', '14:00:00', 'Stomachache', 'Spicy food', 'Antacids');

-- Insert dummy data into appointmenttb table
INSERT INTO appointmenttb (pid, fname, lname, gender, email, contact, doctor, docFees, appdate, apptime, userStatus, doctorStatus, receptStatus, approve_status) 
VALUES 
(1, 'John', 'Doe', 'Male', 'john.doe@example.com', '1234567890', 'Dr. Smith', 50, '2024-04-15', '10:00:00', 1, 1, 1, 0),
(2, 'Alice', 'Smith', 'Female', 'alice.smith@example.com', '9876543210', 'Dr. Johnson', 60, '2024-04-16', '11:30:00', 1, 1, 1, 0),
(3, 'Michael', 'Brown', 'Male', 'michael.brown@example.com', '1234567890', 'Dr. Lee', 40, '2024-04-17', '12:00:00', 1, 1, 1, 0),
(4, 'Emily', 'Jones', 'Female', 'emily.jones@example.com', '9876543210', 'Dr. Martinez', 55, '2024-04-18', '13:30:00', 1, 1, 1, 0),
(5, 'David', 'Taylor', 'Male', 'david.taylor@example.com', '1234567890', 'Dr. White', 45, '2024-04-19', '14:00:00', 1, 1, 1, 0);

-- Insert dummy data into record table
INSERT INTO record (blood_type, blood_pressure, weight, other, ID) 
VALUES 
('A+', '120/80', '70 kg', 'Normal', 1),
('B-', '130/90', '65 kg', 'High BP', 2),
('AB+', '140/90', '75 kg', 'Normal', 3),
('O-', '110/70', '60 kg', 'Low BP', 4),
('A-', '125/85', '68 kg', 'Normal', 5);

INSERT INTO image (pname, picture, ID) 
VALUES 
('John Doe Picture', '/path/to/john_doe_picture.jpg', 1),
('Alice Smith Picture', '/path/to/alice_smith_picture.jpg', 2),
('Michael Brown Picture', '/path/to/michael_brown_picture.jpg', 3),
('Emily Jones Picture', '/path/to/emily_jones_picture.jpg', 4),
('David Taylor Picture', '/path/to/david_taylor_picture.jpg', 5);

-- Insert dummy data into patreg table
INSERT INTO patreg (fname, lname, gender, dob, email, contact, password, cpassword, picture, active_status) 
VALUES 
('John', 'Doe', 'Male', '1990-01-01', 'john.doe@example.com', '1234567890', 'password', 'password', NULL, 1),
('Alice', 'Smith', 'Female', '1995-05-05', 'alice.smith@example.com', '9876543210', 'password', 'password', NULL, 1),
('Michael', 'Brown', 'Male', '1988-08-08', 'michael.brown@example.com', '1234567890', 'password', 'password', NULL, 1),
('Emily', 'Jones', 'Female', '1992-02-02', 'emily.jones@example.com', '9876543210', 'password', 'password', NULL, 1),
('David', 'Taylor', 'Male', '1985-12-12', 'david.taylor@example.com', '1234567890', 'password', 'password', NULL, 1);




SELECT appointmenttb.ID, appointmenttb.appdate, appointmenttb.apptime, appointmenttb.doctor, record.*, image.picture
    FROM appointmenttb
    LEFT JOIN record ON appointmenttb.ID = record.ID
    LEFT JOIN image ON appointmenttb.ID = image.ID
    Where pid=1

INSERT into prms_db.image(iid,picture,ID) VALUES (7,LOAD_FILE('../assets/images/Patients/pat2.png'),1)