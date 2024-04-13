DROP DATABASE prms_db;

CREATE DATABASE IF NOT EXISTS prms_db;

USE prms_db;

-- Clear Data
TRUNCATE prms_db.admintb;
DELETE FROM prms_db.appointmenttb;
TRUNCATE prms_db.contact;
TRUNCATE prms_db.doctb;
TRUNCATE prms_db.image;
TRUNCATE prms_db.patreg;
TRUNCATE prms_db.prestb;
TRUNCATE prms_db.record;

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


INSERT INTO prms_db.admintb (username, password) 
VALUES 
('admin', 'admin123'),
('avishek', 'avi123');

INSERT INTO prms_db.doctb (username, password, email, spec, docFees, working_status) 
VALUES 
('aayush', 'aayush123', 'aayush@gmail.com', 'Cardiologist', 100, 1),
('anukul', 'anukul123', 'doctorb@gmail.com', 'Dermatologist', 120, 1),
('doctorc', 'doctorc123', 'doctorc@gmail.com', 'Pediatrician', 90, 1),
('doctord', 'doctord123', 'doctord@gmail.com', 'Oncologist', 150, 1),
('doctore', 'doctore123', 'doctore@gmail.com', 'Neurologist', 110, 1);

INSERT INTO prms_db.patreg (fname, lname, gender, dob, email, contact, password, cpassword, picture, active_status) 
VALUES 
('Avishek', 'Shrestha', 'Male', '2004-01-01', 'avishek@gmail.com', '9861921546', 'avi123', 'avi123', NULL, 1),
('Sita', 'Ghimire', 'Female', '1995-05-05', 'sita.ghimire@gmail.com', '9876543210', 'Sita123', 'Sita123', NULL, 1),
('Rajan', 'Shrestha', 'Male', '1988-08-08', 'rajan.shrestha@gmail.com', '1234567890', 'Rajan123', 'Rajan123', NULL, 1),
('Gita', 'Maharjan', 'Female', '1992-02-02', 'gita.maharjan@gmail.com', '9876543210', 'Gita123', 'Gita123', NULL, 1),
('Dipesh', 'Bhattarai', 'Male', '1985-12-12', 'dipesh.bhattarai@gmail.com', '1234567890', 'Dipesh123', 'Dipesh123', NULL, 1);

INSERT INTO prms_db.contact (name, email, contact, message) 
VALUES 
('Hari Sharma', 'hari.sharma@gmail.com', '1234567890', 'Love Your Work!'),
('Sita Ghimire', 'sita.ghimire@gmail.com', '9876543210', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
('Rajan Shrestha', 'rajan.shrestha@gmail.com', '1234567890', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'),
('Gita Maharjan', 'gita.maharjan@gmail.com', '9876543210', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'),
('Dipesh Bhattarai', 'dipesh.bhattarai@gmail.com', '1234567890', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

INSERT INTO prms_db.appointmenttb (pid, fname, lname, gender, email, contact, doctor, docFees, appdate, apptime, userStatus, doctorStatus, receptStatus, approve_status) 
VALUES 
(1, 'Hari', 'Sharma', 'Male', 'hari.sharma@gmail.com', '1234567890', 'aayush', 50, '2024-04-15', '10:00:00', 1, 1, 1, 0),
(2, 'Sita', 'Ghimire', 'Female', 'sita.ghimire@gmail.com', '9876543210', 'aayush', 60, '2024-04-16', '11:30:00', 1, 1, 1, 0),
(3, 'Rajan', 'Shrestha', 'Male', 'rajan.shrestha@gmail.com', '1234567890', 'aayush', 40, '2024-04-17', '12:00:00', 1, 1, 1, 0),
(4, 'Gita', 'Maharjan', 'Female', 'gita.maharjan@gmail.com', '9876543210', 'aayush', 55, '2024-04-18', '13:30:00', 1, 1, 1, 0),
(5, 'Dipesh', 'Bhattarai', 'Male', 'dipesh.bhattarai@gmail.com', '1234567890', 'aayush', 45, '2024-04-19', '14:00:00', 1, 1, 1, 0);

INSERT INTO prms_db.prestb (doctor, pid, ID, fname, lname, appdate, apptime, disease, allergy, prescription) 
VALUES 
('aayush', 1, 1, 'Hari', 'Sharma', '2024-04-15', '10:00:00', 'Fever', 'None', 'Paracetamol 500mg'),
('aayush', 2, 2, 'Sita', 'Ghimire', '2024-04-16', '11:30:00', 'Allergy', 'Peanuts', 'Antihistamines'),
('aayush', 3, 3, 'Rajan', 'Shrestha', '2024-04-17', '12:00:00', 'Headache', 'None', 'Rest and fluids'),
('aayush', 4, 4, 'Gita', 'Maharjan', '2024-04-18', '13:30:00', 'Injury', 'None', 'Painkillers and rest'),
('aayush', 5, 5, 'Dipesh', 'Bhattarai', '2024-04-19', '14:00:00', 'Stomachache', 'Spicy food', 'Antacids');

INSERT INTO prms_db.record (blood_type, blood_pressure, weight, other, ID) 
VALUES 
('A+', '120/80', '70 kg', 'Normal', 1),
('B-', '130/90', '65 kg', 'High BP', 1),
('AB+', '140/90', '75 kg', 'Normal', 2),
('O-', '110/70', '60 kg', 'Low BP', 2),
('A-', '125/85', '68 kg', 'Normal', 3);

INSERT INTO prms_db.image (pname, picture, ID) 
VALUES 
('Hari Sharma Picture', '/path/to/hari_sharma_picture.jpg', 1),
('Sita Ghimire Picture', '/path/to/sita_ghimire_picture.jpg', 1),
('Rajan Shrestha Picture', '/path/to/rajan_shrestha_picture.jpg', 2),
('Gita Maharjan Picture', '/path/to/gita_maharjan_picture.jpg', 2),
('Dipesh Bhattarai Picture', '/path/to/dipesh_bhattarai_picture.jpg', 2);



SELECT appointmenttb.ID, appointmenttb.appdate, appointmenttb.apptime, appointmenttb.doctor, record.*, image.picture
    FROM appointmenttb
    LEFT JOIN record ON appointmenttb.ID = record.ID
    LEFT JOIN image ON appointmenttb.ID = image.ID
    Where pid=1

INSERT into prms_db.image(iid,picture,ID) VALUES (7,LOAD_FILE('../assets/images/Patients/pat2.png'),1)


SELECT * FROM appointmenttb LEFT JOIN record ON appointmenttb.ID = record.ID LEFT JOIN image ON appointmenttb.ID = image.ID JOIN prestb on prestb.pid=appointmenttb.pid