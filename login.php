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
        $_SESSION['user_id'] = $row['user_id'];
        setcookie("username", $username, time() + 3600, "/");
        header("Location: dashboard.php");
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
