CREATE DATABASE prms_db;

USE prms_db;

CREATE TABLE admintb (
  username varchar(50) NOT NULL,
  password varchar(30) NOT NULL
);

INSERT INTO admintb (username, password) VALUES
('admin', 'admin123');

CREATE TABLE appointmenttb (
  pid int(11) PRIMARY KEY AUTO_INCREMENT,
  ID int(11) NOT NULL AUTO_INCREMENT,
  fname varchar(20) NOT NULL,
  lname varchar(20) NOT NULL,
  gender varchar(10) NOT NULL,
  email varchar(30) NOT NULL,
  contact varchar(10) NOT NULL,
  doctor varchar(30) NOT NULL,
  docFees int(5) NOT NULL,
  appdate date NOT NULL,
  apptime time NOT NULL,
  userStatus int(5) NOT NULL,
  doctorStatus int(5) NOT NULL,
  approve_status INT NOT NULL DEFAULT 1,
);

INSERT INTO appointmenttb (pid, ID, fname, lname, gender, email, contact, doctor, docFees, appdate, apptime, userStatus, doctorStatus) VALUES
(4, 1, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '2020-02-14', '10:00:00', 1, 0),
(4, 2, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-02-28', '10:00:00', 0, 1),
(4, 3, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Amit', 1000, '2020-02-19', '03:00:00', 0, 1),
(11, 4, 'Shraddha', 'Kapoor', 'Female', 'shraddha@gmail.com', '9768946252', 'ashok', 500, '2020-02-29', '20:00:00', 1, 1),
(4, 5, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-02-28', '12:00:00', 1, 1),
(4, 6, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '2020-02-26', '15:00:00', 0, 1),
(2, 8, 'Alia', 'Bhatt', 'Female', 'alia@gmail.com', '8976897689', 'Ganesh', 550, '2020-03-21', '10:00:00', 1, 1),
(5, 9, 'Gautam', 'Shankararam', 'Male', 'gautam@gmail.com', '9070897653', 'Ganesh', 550, '2020-03-19', '20:00:00', 1, 0),
(4, 10, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '0000-00-00', '14:00:00', 1, 0),
(4, 11, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-03-27', '15:00:00', 1, 1),
(9, 12, 'William', 'Blake', 'Male', 'william@gmail.com', '8683619153', 'Kumar', 800, '2020-03-26', '12:00:00', 1, 1),
(9, 13, 'William', 'Blake', 'Male', 'william@gmail.com', '8683619153', 'Tiwary', 450, '2020-03-26', '14:00:00', 1, 1);

CREATE TABLE contact (
  name varchar(30) NOT NULL,
  email text NOT NULL,
  contact varchar(10) NOT NULL,
  message varchar(200) NOT NULL
);

INSERT INTO contact (name, email, contact, message) VALUES
('Anu', 'anu@gmail.com', '7896677554', 'Hey Admin'),
(' Viki', 'viki@gmail.com', '9899778865', 'Good Job, Pal'),
('Ananya', 'ananya@gmail.com', '9997888879', 'How can I reach you?'),
('Aakash', 'aakash@gmail.com', '8788979967', 'Love your site'),
('Mani', 'mani@gmail.com', '8977768978', 'Want some coffee?'),
('Karthick', 'karthi@gmail.com', '9898989898', 'Good service'),
('Abbis', 'abbis@gmail.com', '8979776868', 'Love your service'),
('Asiq', 'asiq@gmail.com', '9087897564', 'Love your service. Thank you!'),
('Jane', 'jane@gmail.com', '7869869757', 'I love your service!');

CREATE TABLE doctb (
  username varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  spec varchar(50) NOT NULL,
  docFees int(10) NOT NULL,
  working_status INT NOT NULL DEFAULT 0
);

INSERT INTO doctb (username, password, email, spec, docFees) VALUES
('ashok', 'ashok123', 'ashok@gmail.com', 'General', 500),
('arun', 'arun123', 'arun@gmail.com', 'Cardiologist', 600),
('Dinesh', 'dinesh123', 'dinesh@gmail.com', 'General', 700),
('Ganesh', 'ganesh123', 'ganesh@gmail.com', 'Pediatrician', 550),
('Kumar', 'kumar123', 'kumar@gmail.com', 'Pediatrician', 800),
('Amit', 'amit123', 'amit@gmail.com', 'Cardiologist', 1000),
('Abbis', 'abbis123', 'abbis@gmail.com', 'Neurologist', 1500),
('Tiwary', 'tiwary123', 'tiwary@gmail.com', 'Pediatrician', 450);

CREATE TABLE patreg (
  pid int(11) PRIMARY KEY AUTO_INCREMENT,
  fname varchar(20) NOT NULL,
  lname varchar(20) NOT NULL,
  gender varchar(10) NOT NULL,
  email varchar(30) NOT NULL,
  contact varchar(10) NOT NULL,
  password varchar(30) NOT NULL,
  cpassword varchar(30) NOT NULL,
  active_status INT NOT NULL DEFAULT 1
);

INSERT INTO patreg (fname, lname, gender, email, contact, password, cpassword) VALUES
('Ram', 'Kumar', 'Male', 'ram@gmail.com', '9876543210', 'ram123', 'ram123'),
('Alia', 'Bhatt', 'Female', 'alia@gmail.com', '8976897689', 'alia123', 'alia123'),
('Shahrukh', 'khan', 'Male', 'shahrukh@gmail.com', '8976898463', 'shahrukh123', 'shahrukh123'),
('Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'kishan123', 'kishan123'),
('Gautam', 'Shankararam', 'Male', 'gautam@gmail.com', '9070897653', 'gautam123', 'gautam123'),
('Sushant', 'Singh', 'Male', 'sushant@gmail.com', '9059986865', 'sushant123', 'sushant123'),
('Nancy', 'Deborah', 'Female', 'nancy@gmail.com', '9128972454', 'nancy123', 'nancy123'),
('Kenny', 'Sebastian', 'Male', 'kenny@gmail.com', '9809879868', 'kenny123', 'kenny123'),
('William', 'Blake', 'Male', 'william@gmail.com', '8683619153', 'william123', 'william123'),
('Peter', 'Norvig', 'Male', 'peter@gmail.com', '9609362815', 'peter123', 'peter123'),
('Shraddha', 'Kapoor', 'Female', 'shraddha@gmail.com', '9768946252', 'shraddha123', 'shraddha123');

CREATE TABLE prestb (
  doctor varchar(50) NOT NULL,
  pid int(11) NOT NULL,
  ID int(11) NOT NULL,
  fname varchar(50) NOT NULL,
  lname varchar(50) NOT NULL,
  appdate date NOT NULL,
  apptime time NOT NULL,
  disease varchar(250) NOT NULL,
  allergy varchar(250) NOT NULL,
  prescription varchar(1000) NOT NULL
);

INSERT INTO prestb (doctor, pid, ID, fname, lname, appdate, apptime, disease, allergy, prescription) VALUES
('Dinesh', 4, 11, 'Kishan', 'Lal', '2020-03-27', '15:00:00', 'Cough', 'Nothing', 'Just take a teaspoon of Benadryl every night'),
('Ganesh', 2, 8, 'Alia', 'Bhatt', '2020-03-21', '10:00:00', 'Severe Fever', 'Nothing', 'Take bed rest'),
('Kumar', 9, 12, 'William', 'Blake', '2020-03-26', '12:00:00', 'Sever fever', 'nothing', 'Paracetamol -> 1 every morning and night'),
('Tiwary', 9, 13, 'William', 'Blake', '2020-03-26', '14:00:00', 'Cough', 'Skin dryness', 'Intake fruits with more water content');


delete from prms_db.prestb where ID=0