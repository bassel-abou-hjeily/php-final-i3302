<?php
session_start();
include("./connect.php");
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}
$Email = '';
$Password = '';
$error_message = '';
if (isset($_POST['Email'])) {
    $Email = strtolower(trim($_POST['Email']));
}
if (isset($_POST['Password'])) {
    $Password = trim($_POST['Password']);
    $Password = bin2hex(mhash(MHASH_GOST, $Password));
}
if (empty($Email) || empty($Password)) {
    $error_message = "All fields are required!";
} elseif (!preg_match('/^.{8,}$/', $Password)) {
    $error_message = "Password must be at least 8 characters long!";
} else {
    $sql = "SELECT * FROM account WHERE Email = '$Email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['status'] === 'Blocked') {
            $error_message = "You are blocked";
        } else if (hash_equals($row['Password'], $Password)) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['Email'];
            header("Location: home.php");
            exit;
        } else {
            $error_message = "Incorrect Email and password!";
        }
    } else {
        $error_message = "Incorrect Email and password!";
    }
}


mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<style>

.forgot-password {
    font-size: 14px;
}

.forgot-link {
    color: #007bff;
    text-decoration: none;
}

.forgot-link:hover {
    text-decoration: underline;
}

</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/all.min.css">

</head>

<body>
<a href="./index.php" style="top:50px;left:50px;position:absolute">
<span class="link icon"><i class="fa-solid fa-arrow-left"></i></span> </a>
    <div class="register-container">
        <div class="register-form">
            <form name="login" method="post">
                <h1 class="form-title">Login</h1>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="Email" value="<?php echo $Email ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="Password" required>
                </div>
                <div class="forgot-password">
                        <a href="forgetpassword.php" class="forgot-link">Forgot password?</a>
                    </div>
                <div class="form-group">
                    <input type="submit" value="Login" class="form-button">
                </div>
                <div class="form-footer">
                    <p>Don't have an account? <a href="./signup.php">Sign Up</a></p>
                </div>
                <div class="error-message">
                    <?php if (!empty($error_message)): ?>
                        <p><?= $error_message ?></p>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>