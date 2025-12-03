<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: loginpage.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
<h1>Welcome <?= htmlspecialchars($_SESSION['username']); ?></h1>
<p>You can create an appointment, view your appointments, or log out.</p>

<a href="setappointment.php">
    <button>Create Appointment</button>
</a>
<a href="checkappointment.php">
    <button>Check Your existing appointments</button>
</a>
<br><br>
<form action="logout.php" method="POST">
    <button type="submit">Log Out</button>
</form>

</body>
</html>
