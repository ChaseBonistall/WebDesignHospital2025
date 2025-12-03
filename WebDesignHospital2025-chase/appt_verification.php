<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'] ?? 0;
    $doctor_id = $_POST['doctor_id'] ?? '';
    $appointment_date = $_POST['appointment_date'] ?? '';
    $appointment_time = $_POST['appointment_time'] ?? '';

    if ($user_id && $doctor_id && $appointment_date && $appointment_time) {
    
    $sql = "INSERT INTO scheduled_appt (user_id, doctor_id, appointment_date, appointment_time) 
            VALUES ('$user_id', '$doctor_id', '$appointment_date', '$appointment_time')";
    
    if ($conn->query($sql)) {
        echo "Appointment saved successfully!<br>";
        echo "<a href='dashboard.php'><button>Back to Dashboard</button></a>";
        exit;
    } else {
        echo "Error saving appointment: " . $conn->error;
    }
} else {
        echo "Please fill in all fields or log in again.";
    }
} else {
    echo "Invalid request.";
}
?>
