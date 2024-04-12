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
CREATE TABLE prms_db.admintb (
  aid INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(30) NOT NULL
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
  approve_status INT NOT NULL DEFAULT 0
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

CREATE TABLE prms_db.patreg (
  pid INT(11) PRIMARY KEY AUTO_INCREMENT,
  fname VARCHAR(20) NOT NULL,
  lname VARCHAR(20) NOT NULL,
  gender VARCHAR(10) NOT NULL,
  email VARCHAR(30) NOT NULL,
  contact VARCHAR(10) NOT NULL,
  password VARCHAR(30) NOT NULL,
  cpassword VARCHAR(30) NOT NULL,
  picture LONGBLOB DEFAULT NULL,
  active_status INT NOT NULL DEFAULT 1
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

CREATE TABLE prms_db.record(
  
);

-- Inserting Values in the Database
INSERT INTO prms_db.prestb (doctor, pid, ID, fname, lname, appdate, apptime, disease, allergy, prescription) VALUES
('Dinesh', 4, 11, 'Kishan', 'Lal', '2020-03-27', '15:00:00', 'Cough', 'Nothing', 'Just take a teaspoon of Benadryl every night'),
('Ganesh', 2, 8, 'Alia', 'Bhatt', '2020-03-21', '10:00:00', 'Severe Fever', 'Nothing', 'Take bed rest'),
('Kumar', 9, 12, 'Dipesh', 'Blake', '2020-03-26', '12:00:00', 'Sever fever', 'nothing', 'Paracetamol x1 every morning and night'),
('Aayush', 9, 13, 'Dipesh', 'Blake', '2020-03-26', '14:00:00', 'Cough', 'Skin dryness', 'Intake fruits with more water content');

INSERT INTO prms_db.admintb (username, password) VALUES
('admin', 'admin123'),
('avishek','avi123');

INSERT INTO prms_db.appointmenttb (pid, ID, fname, lname, gender, email, contact, doctor, docFees, appdate, apptime) VALUES
(4, 1, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '2020-02-14', '10:00:00'),
(4, 2, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-02-28', '10:00:00'),
(4, 3, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Amit', 1000, '2020-02-19', '03:00:00'),
(11, 4, 'Shraddha', 'Kapoor', 'Female', 'shraddha@gmail.com', '9768946252', 'ashok', 500, '2020-02-29', '20:00:00'),
(4, 5, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-02-28', '12:00:00'),
(4, 6, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '2020-02-26', '15:00:00'),
(2, 8, 'Alia', 'Bhatt', 'Female', 'alia@gmail.com', '8976897689', 'Ganesh', 550, '2020-03-21', '10:00:00'),
(5, 9, 'Gautam', 'Shankararam', 'Male', 'gautam@gmail.com', '9070897653', 'Ganesh', 550, '2020-03-19', '20:00:00'),
(4, 10, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '0000-00-00', '14:00:00'),
(4, 11, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-03-27', '15:00:00'),
(9, 12, 'Dipesh', 'Blake', 'Male', 'Dipesh@gmail.com', '8683619153', 'Kumar', 800, '2020-03-26', '12:00:00'),
(9, 13, 'Dipesh', 'Blake', 'Male', 'Dipesh@gmail.com', '8683619153', 'Aayush', 450, '2020-03-26', '14:00:00');

INSERT INTO prms_db.contact (name, email, contact, message) VALUES
('Anu', 'anu@gmail.com', '7896677554', 'Hey Admin'),
('Viki', 'viki@gmail.com', '9899778865', 'Good Job, Pal'),
('Anu', 'anu@gmail.com', '9997888879', 'How can I reach you?'),
('Aakash', 'aakash@gmail.com', '8788979967', 'Love your site'),
('Ram', 'ram@gmail.com', '8977768978', 'Want some coffee?'),
('Karthick', 'karthi@gmail.com', '9898989898', 'Good service'),
('Abbis', 'abbis@gmail.com', '8979776868', 'Love your service'),
('Usha', 'usha@gmail.com', '9087897564', 'Love your service. Thank you!'),
('Jane', 'jane@gmail.com', '7869869757', 'I love your service!');

INSERT INTO prms_db.doctb (username, password, email, spec, docFees) VALUES
('Anukul', 'anukul123', 'anukul@gmail.com', 'General', 1500),
('ashok', 'ashok123', 'ashok@gmail.com', 'General', 500),
('arun', 'arun123', 'arun@gmail.com', 'Cardiologist', 600),
('Dinesh', 'dinesh123', 'dinesh@gmail.com', 'General', 700),
('Ganesh', 'ganesh123', 'ganesh@gmail.com', 'Pediatrician', 550),
('Kumar', 'kumar123', 'kumar@gmail.com', 'Pediatrician', 800),
('Amit', 'amit123', 'amit@gmail.com', 'Cardiologist', 1000),
('Abbis', 'abbis123', 'abbis@gmail.com', 'Neurologist', 1500),
('Aayush', 'aayush123', 'aayush@gmail.com', 'Pediatrician', 450);

INSERT INTO prms_db.patreg (fname, lname, gender, email, contact, password, cpassword) VALUES
('Aayush', 'Shrestha', 'Male', 'aayush@gmail.com', '9840031521', 'aayush123', 'aayush123'),
('Ram', 'Kumar', 'Male', 'ram@gmail.com', '9876543210', 'ram123', 'ram123'),
('Alia', 'Bhatt', 'Female', 'alia@gmail.com', '8976897689', 'alia123', 'alia123'),
('Shahrukh', 'khan', 'Male', 'shahrukh@gmail.com', '8976898463', 'shahrukh123', 'shahrukh123'),
('Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'kishan123', 'kishan123'),
('Gautam', 'Shankararam', 'Male', 'gautam@gmail.com', '9070897653', 'gautam123', 'gautam123'),
('Sushant', 'Singh', 'Male', 'sushant@gmail.com', '9059986865', 'sushant123', 'sushant123'),
('Nancy', 'Dahal', 'Female', 'nancy@gmail.com', '9128972454', 'nancy123', 'nancy123'),
('Kenny', 'Sebastian', 'Male', 'kenny@gmail.com', '9809879868', 'kenny123', 'kenny123'),
('Dipesh', 'Blake', 'Male', 'dipesh@gmail.com', '8683619153', 'Dipesh123', 'Dipesh123'),
('Peter', 'Norvig', 'Male', 'peter@gmail.com', '9609362815', 'peter123', 'peter123'),
('Shraddha', 'Kapoor', 'Female', 'shraddha@gmail.com', '9768946252', 'shraddha123', 'shraddha123');


