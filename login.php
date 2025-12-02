<?php
require 'db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

   $sql = "SELECT * FROM user_info WHERE username = '$username'";
   $result = $conn->query($sql);

    if ($result->num_rows > 0) {
     $row = $result->fetch_assoc();
     if (password_verify($password,$row['password'])){
        $_SESSION['username'] = $username;
        setcookie("username", $username, time() + 3600, "/");
        header("Location: dashboard.html");
        exit;
     }
     else{
        echo "Invalid Password";
     }
    }
    else{
        echo "User Unknown";
    }
}
?>
