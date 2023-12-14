<?php
session_start(); 

include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM customer WHERE Email='$email' AND PasswordMD5Hash='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        
        $_SESSION['email'] = $email; 
        header("Location: ../test1.php"); 
        exit(); 
    } else {
        
        echo "Invalid login credentials";
    }
}
?>
