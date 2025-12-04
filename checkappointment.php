<?php
session_start();
require 'db_connection.php';

// User must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Correct SQL for YOUR tables
$sql = "
SELECT s.appointment_id, s.appointment_date, s.appointment_time,
       d.name AS doctor_name
FROM scheduled_appt s
JOIN doctors d ON s.doctor_id = d.doctor_id
WHERE s.user_id = ?
ORDER BY s.appointment_date DESC, s.appointment_time DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Appointments</title>
</head>
<body>
    <h2>My Appointments</h2>
    <p>
       Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> |
       <a href="dashboard.php">Home</a> |
       <a href="setappointment.php">Book Appointment</a> |
       <a href="logout.php">Logout</a>
    </p>

    <table border="1" cellpadding="5">
        <tr>
            <th>Appointment ID</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['appointment_id']; ?></td>
            <td><?php echo $row['doctor_name']; ?></td>
            <td><?php echo $row['appointment_date']; ?></td>
            <td><?php echo $row['appointment_time']; ?></td>
            <td>
                <a href="editappointment.php?id=<?php echo $row['appointment_id']; ?>">Edit</a> |
                <a href="deleteappointment.php?id=<?php echo $row['appointment_id']; ?>"
                   onclick="return confirm('Are you sure you want to delete this appointment?');">
                   Delete
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
