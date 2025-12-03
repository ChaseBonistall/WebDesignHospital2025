CREATE TABLE `user_info` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
)

INSERT INTO `doctors` (`doctor_id`, `name`) VALUES
(1, 'Dr. Sarah Leslen'),
(2, 'Dr. Bridget Axle'),
(3, 'Dr. Emily Stanford'),
(4, 'Dr. Danny DeCheeto'),
(5, 'Dr. Michael Arcen'),
(6, 'Dr. Robert Jones'),
(7, 'Dr. Anne Frank'),
(8, 'Dr. David Kim'),
(9, 'Dr. Jennifer Brown'),
(10, 'Dr. Ben Dover');

CREATE TABLE `scheduled_appt` (
  `appointment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL
)
