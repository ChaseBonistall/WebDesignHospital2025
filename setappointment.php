<?php
echo "Set an appointment";
require 'db_connection.php';
$sql = "SELECT doctor_id, name FROM doctors";
$result = $conn->query($sql);
$doctors = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_array()) {
        $doctors[] = $row;
    }
}
?>
<html>
<body>

<form method="POST" action="appt_verification.php">
    <label for="Doctor">Select Doctor </label>
    <select name="doctor_id" id="doctor" required>
        <option value="">-- Select a Doctor --</option>
        <?php foreach ($doctors as $doctor): ?>
            <option value="<?php echo $doctor['doctor_id']; ?>">
                <?php echo htmlspecialchars($doctor['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label for="date">Select Date:</label><br>
    <input type="date" id="date" name="appointment_date" required>
    <br><br>

    <label for="time">Select Time:</label><br>
    <select name="appointment_time" id="time" required>
        <option value="">-- Select Time --</option>
        <option value="08:00:00">8:00 AM</option>
        <option value="09:00:00">9:00 AM</option>
        <option value="10:00:00">10:00 AM</option>
        <option value="11:00:00">11:00 AM</option>
        <option value="12:00:00">12:00 PM</option>
        <option value="13:00:00">1:00 PM</option>
        <option value="14:00:00">2:00 PM</option>
        <option value="15:00:00">3:00 PM</option>
        <option value="16:00:00">4:00 PM</option>
    </select>
    <br><br>

    <button type="submit">Confirm Appointment</button>

</form>

<br>
<a href="dashboard.php"><button>Back to Dashboard</button></a>

</body>
</html>
