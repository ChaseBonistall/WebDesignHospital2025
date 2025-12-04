<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: loginpage.html");
    exit;
}

$userid = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: checkappointment.php");
    exit;
}

$appointmentid = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM scheduled_appt WHERE appointment_id = ? AND user_id = ?");
$stmt->bind_param("ii", $appointmentid, $userid);
$stmt->execute();

header("Location: checkappointment.php");
exit;
?>
