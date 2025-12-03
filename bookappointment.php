<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['patientid'])) {
    header("Location: login.php");
    exit;
}

$patientid = $_SESSION['patientid'];
$message = "";

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctorid = isset($_POST['doctorid']) ? $_POST['doctorid'] : '';
    $appointmentdatetime = isset($_POST['appointmentdatetime']) ? $_POST['appointmentdatetime'] : '';
    $reason = isset($_POST['reason']) ? $_POST['reason'] : '';

    if ($doctorid && $appointmentdatetime) {
        // Convert from "YYYY-MM-DDTHH:MM" to "YYYY-MM-DD HH:MM:00"
        $appointmentdatetime = str_replace('T', ' ', $appointmentdatetime);

        $stmt = $conn->prepare(
            "INSERT INTO appointments (patientid, doctorid, appointmentdatetime, reason) 
             VALUES (?, ?, ?, ?)"
        );
        if (!$stmt) {
            $message = "Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param("iiss", $patientid, $doctorid, $appointmentdatetime, $reason);

            if ($stmt->execute()) {
                $message = "Appointment booked successfully.";
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $message = "Please select doctor and date/time.";
    }
}

// Load all doctors for dropdown
$doctors = [];
$result = $conn->query("SELECT id, name, specialization FROM doctors");
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
</head>
<body>
    <h2>Book Appointment</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['patientname']); ?> | 
       <a href="dashboard.php">Home</a> |
       <a href="myappointments.php">My Appointments</a> |
       <a href="logout.php">Logout</a>
    </p>

    <p><?php echo $message; ?></p>

    <form method="POST" action="bookappointment.php">
        <label>Doctor:</label><br>
        <select name="doctorid">
            <option value="">-- Select Doctor --</option>
            <?php foreach ($doctors as $doc): ?>
                <option value="<?php echo $doc['id']; ?>">
                    <?php echo $doc['name'] . " (" . $doc['specialization'] . ")"; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Appointment Date & Time:</label><br>
        <input type="datetime-local" name="appointmentdatetime"><br><br>

        <label>Reason:</label><br>
        <textarea name="reason"></textarea><br><br>

        <button type="submit">Book</button>
    </form>
</body>
</html>
