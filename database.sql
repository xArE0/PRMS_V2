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

INSERT INTO prms_db.doctb (docid, username, password, email, spec, docFees, picture, working_status) 
VALUES 
(1, 'Aayush Shrestha', 'aayush123', 'aayush@gmail.com', 'General', 600, null, 1),
(2, 'Anukul Pokharel', 'anukul123', 'anukul@gmail.com', 'Cardiologist', 650, null, 1),
(3, 'Nabin Thapa', 'navin123', 'nabin@gmail.com', 'Neurologist', 700, null, 1),
(4, 'Dipesh Pradhan', 'dipesh123', 'dipesh@gmail.com', 'Pediatrician', 750, null, 1),
(5, 'Abhishek Shrestha', 'abhishek123', 'abhishek@gmail.com', 'Cardiologist', 1000, null, 1);

INSERT INTO prms_db.patreg (fname, lname, gender, dob, email, contact, password, cpassword, picture, active_status) 
VALUES 
('Avishek', 'Shrestha', 'Male', '2004-01-01', 'abhishrestha987@gmail.com', '9861921546', 'avi123', 'avi123', NULL, 1),
('Anu', 'Thapa', 'Female', '2005-05-05', 'anu@gmail.com', '9876543210', 'anu123', 'anu123', NULL, 1),
('Aayush', 'Khadka', 'Male', '2001-08-08', 'aayush@gmail.com', '9856412846', 'aayush123', 'aayush123', NULL, 1),
('Gita', 'Maharjan', 'Female', '1992-02-02', 'gita@gmail.com', '9876543210', 'gita123', 'Gita123', NULL, 1),
('Dipesh', 'Bhattarai', 'Male', '1985-12-12', 'dipesh@gmail.com', '1234567890', 'dipesh123', 'Dipesh123', NULL, 1);

INSERT INTO prms_db.contact (name, email, contact, message) 
VALUES 
('Avishek Shrestha', 'abhishrestha987@gmail.com', '9861921546', 'I had a great experience at your clinic. The staff was very friendly and helpful. Keep up the good work!'),
('Emily Johnson', 'emily.johnson@example.com', '9876543210', 'I am highly satisfied with the treatment I received. The doctors were knowledgeable and professional. Thank you for your excellent service.'),
('Michael Williams', 'michael.williams@example.com', '1234567890', 'I would like to express my gratitude for the outstanding care I received during my visit. The facilities were clean and well-maintained, and the medical staff was attentive to my needs.'),
('Sarah Brown', 'sarah.brown@example.com', '9876543210', 'I was impressed by the efficiency and professionalism of your clinic. The doctors took the time to explain everything clearly and made me feel comfortable throughout my appointment.'),
('David Miller', 'david.miller@example.com', '1234567890', 'I have been a patient at your clinic for several years now, and I have always been pleased with the level of care I have received. Thank you for your dedication to providing quality healthcare services.');

INSERT INTO appointmenttb (ID, pid, fname, lname, gender, email, contact, doctor, docFees, appdate, apptime, userStatus, doctorStatus, receptStatus, approve_status) 
VALUES 
(1, 1, 'Avishek', 'Shrestha', 'Male', 'abhishrestha987@gmail.com', '9861921546', 'Aayush Shrestha', 650, '2024-04-15', '11:40:00', 1, 0, 1, 1),
(2, 1, 'Avishek', 'Shrestha', 'Male', 'abhishrestha987@gmail.com', '9861921546', 'Aayush Shrestha', 650, '2024-04-23', '11:40:00', 1, 0, 1, 1),
(3, 2, 'Anu', 'Thapa', 'Female', 'anu@gmail.com', '9876543210', 'Dipesh Pradhan', 750, '2024-04-19', '14:00:00', 1, 1, 1, 0),
(4, 3, 'Aayush', 'Khadka', 'Male', 'aayush@gmail.com', '9856412846', 'Nabin Thapa', 700, '2024-04-20', '13:00:00', 1, 1, 1, 0),
(5, 4, 'Gita', 'Maharjan', 'Female', 'gita.maharjan@gmail.com', '9876543210', 'Anukul Pokharel', 650, '2024-04-21', '16:00:00', 1, 1, 1, 0),
(6, 5, 'Dipesh', 'Bhattarai', 'Male', 'dipesh.bhattarai@gmail.com', '1234567890', 'Aayush Shrestha', 600, '2024-04-22', '10:30:00', 1, 1, 1, 0),
(7, 1, 'Avishek', 'Shrestha', 'Male', 'abhishrestha987@gmail.com', '9861921546', 'Aayush Shrestha', 650, '2024-04-25', '12:00:00', 1, 0, 1, 1);

INSERT INTO prestb (ID, pid, doctor, fname, lname, appdate, apptime, disease, allergy, prescription) 
VALUES 
(1, 1, 'Aayush Shrestha', 'Avishek', 'Shrestha', '2024-04-15', '11:40:00', 'Headache', 'None', 'Paracetamol'),
(2, 1, 'Aayush Shrestha', 'Avishek', 'Shrestha', '2024-04-23', '11:40:00', 'Chest Pain and Difficulty Breathing', 'None', 'Acetaminophen 25 mg'),
(7, 1, 'Aayush Shrestha', 'Avishek', 'Shrestha', '2024-04-25', '12:00:00', 'Heart Complications', 'None', 'Continue dosage of Acetaminophen and Exercise');

INSERT INTO record (rid, blood_type, blood_pressure, weight, other, ID) 
VALUES 
(1, 'A+', '120/80 mmHg', '75 Kg', 'No other Remarkable Symptoms', 1),
(2, 'A+', '130/80 mmHg', '77 Kg', 'Possibility of Heart Disease', 2),
(3, 'A+', '135/75 mmHg', '76 Kg', 'Possibility of needing surgery if condition worsens', 7);


INSERT INTO prms_db.image (pname, picture, ID) 
VALUES 
('rep4.jpg','picture1',1),
('rep1.jpg','picture2',2),


-- Query For testing Join
SELECT appointmenttb.ID, appointmenttb.appdate, appointmenttb.apptime, appointmenttb.doctor, record.*, image.picture
FROM appointmenttb
LEFT JOIN record ON appointmenttb.ID = record.ID
LEFT JOIN image ON appointmenttb.ID = image.ID
WHERE appointmenttb.pid = 1;

INSERT into prms_db.image(iid,picture,ID) VALUES (7,LOAD_FILE('../assets/images/Patients/pat2.png'),1)


SELECT * FROM appointmenttb LEFT JOIN record ON appointmenttb.ID = record.ID LEFT JOIN image ON appointmenttb.ID = image.ID JOIN prestb on prestb.pid=appointmenttb.pid