<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userid = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: checkappointment.php");
    exit;
}

$appointmentid = (int)$_GET['id'];
$message = "";
$stmt = $conn->prepare("SELECT * FROM scheduled_appt WHERE appointment_id = ? AND user_id = ?");
$stmt->bind_param("ii", $appointmentid, $userid);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

if (!$appointment) {
    die("Appointment not found or access denied.");
}
$doctors = [];
$docResult = $conn->query("SELECT doctor_id, name FROM doctors");
while ($row = $docResult->fetch_assoc()) {
    $doctors[] = $row;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_POST['doctor_id'] ?? '';
    $appointment_date = $_POST['appointment_date'] ?? '';
    $appointment_time = $_POST['appointment_time'] ?? '';

    if ($doctor_id && $appointment_date && $appointment_time) {
        $stmt = $conn->prepare("
        UPDATE scheduled_appt 
        SET doctor_id = ?, appointment_date = ?, appointment_time = ? 
        WHERE appointment_id = ? AND user_id = ?
        ");
        $stmt->bind_param("issii", $doctor_id, $appointment_date, $appointment_time, $appointmentid, $userid);

        if ($stmt->execute()) {
            $message = "Appointment updated successfully.";
        } 
        else {
        $message = "Error: " . $stmt->error;
        }
    } 
    else {
    $message = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Appointment</title>
</head>
<body>
    <h2>Edit Appointment #<?php echo $appointmentid; ?></h2>
    <p><?php echo $message; ?></p>
    <p><a href="checkappointment.php">Back to My Appointments</a></p>

    <form method="POST" action="editappointment.php?id=<?php echo $appointmentid; ?>">
        <label>Doctor:</label><br>
        <select name="doctor_id">
            <?php foreach ($doctors as $doc): ?>
                <option value="<?php echo $doc['doctor_id']; ?>" 
                    <?php if ($doc['doctor_id'] == $appointment['doctor_id']) echo "selected"; ?>>
                    <?php echo htmlspecialchars($doc['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Date:</label><br>
        <input type="date" name="appointment_date" value="<?php echo $appointment['appointment_date']; ?>"><br><br>

        <label>Time:</label><br>
        <input type="time" name="appointment_time" value="<?php echo $appointment['appointment_time']; ?>"><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
