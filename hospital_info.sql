CREATE TABLE `user_info` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
);

CREATE TABLE doctors (
    'id' int AUTO_INCREMENT PRIMARY KEY,
    'name' varchar(100) NOT NULL
);

CREATE TABLE 'appointments' (
    'appointment_id' int AUTO_INCREMENT PRIMARY KEY,
    'patient_id' int,
    'doctor_id' int,
    'appointment_date' DATETIME,
    FOREIGN KEY ('patient_id') REFERENCES 'user_info'('user_id'),
    FOREIGN KEY ('doctor_id') REFERENCES doctors(id)
);