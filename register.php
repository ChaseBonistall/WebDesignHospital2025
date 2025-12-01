<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        die("Fill out all fields.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user_info (username, email, password)
            VALUES ('$username', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration Successful!
        <p>Your account has been created.</p>
        <button onclick=\"window.location.href='loginpage.html'\">Go to Login</button>
        ";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
