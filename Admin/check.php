<?php
session_start();
include("../connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}


$id = $_SESSION['user_id'];

$firstname = $lastname = $email = $password = $confirmPassword = $phone_nb = '';
$error_message = '';
$is_admin = false; 

$sql = "SELECT * FROM account WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $firstname = $row['Firstname'];
    $lastname = $row['Lastname'];
    $email = $row['Email'];
    $phone_nb = $row['Phone_Nb'];
 
    if ($row['role'] == 'admin') {
        $is_admin = true;
    }else{
        header("Location: ../home.php");
    }
}?>