<?php
session_start(); 


if (isset($_SESSION['email'])) {
   
    header('Location: ../htmlcss/test1.php');
    exit();
}


header('Location: ../htmlcss/login.html');
exit();
?>
