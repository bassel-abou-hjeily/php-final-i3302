<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}
if(!isset($_SESSION['reset_email'])){
    header("Location : login.php");
}
include("./connect.php");

$error_message = "";
$success_message = "";
$password = $confirm_password="";
if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $Email = $_SESSION['reset_email'];
    if (empty($password) || empty($confirm_password)) {
        $error_message = "Please fill out both password fields.";
    } elseif (!preg_match('/^.{8,}/', $password)) {
        $error_message = "Password must be at least 8 characters long!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        $password = bin2hex(mhash(MHASH_GOST, $password));
        $confirm_password = bin2hex(mhash(MHASH_GOST, $confirm_password));
  
        $sql = "UPDATE account SET Password = '$password' , ConfirmPassword = '$confirm_password' WHERE Email = '$Email'";
        if (mysqli_query($conn, $sql)) {
            $success_message = "Your password has been successfully reset.";
            unset($_SESSION['reset_email']); 
            header("Location: login.php");
            exit(); 
         
        } else {
            $error_message = "There was an error resetting your password. Please try again.";
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="register-container">
        <div class="register-form">
            <form method="post">
                <h1 class="form-title">Reset Password</h1>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" value="<?php echo $password?>" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $confirm_password?>" required>
                </div>

                <div class="form-group">
                    <input type="submit" value="Reset Password" class="form-button">
                </div>

                <?php if (!empty($error_message)): ?>
                    <div class="error-message">
                        <p><?= $error_message ?></p>
                    </div>
                <?php elseif (!empty($success_message)): ?>
                    <div class="success-message">
                        <p><?= $success_message ?></p>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
