<?php
require 'db_connection.php';
session_start();
session_unset();
session_destroy();

setcookie("username","", time() - 3600,"/");
header("Location: welcomepage.html");
exit;
?>