<?php
session_start();
include("./connect.php");


if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}


$error_message = "";
$Email=$Phone=$color="";

    if (isset($_POST['Email']) && isset($_POST['phone']) && isset($_POST['Favorite_Color'])) {
        $Email = strtolower(trim($_POST['Email']));
        $Phone = trim($_POST['phone']);
        $color=trim($_POST['Favorite_Color']);

        if (empty($Email) || empty($Phone) || empty($color )) {
            $error_message = "Please enter  your email and phone number and favorite color.";
        } else {
            $sql = "SELECT * FROM `account` WHERE `Email` = '$Email' AND `Phone_Nb` = '$Phone' AND `color` ='$color'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $_SESSION['reset_email'] = $Email;
                header("Location: reset_password.php");
                exit;
            } else {
                $error_message = "Email and Phone number and color do not match.";
              
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="register-container">
        <div class="register-form">
            <form method="post">
                <h1 class="form-title">Forgot Password</h1>
                <p>Enter your email and phone number to reset your password.</p>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="Email" value="<?php echo $Email?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $Phone?>"  required minlength="8" maxlength="8">
                </div>
                <div class="form-group">
            <label for="color">Favorite Color:</label>
            <input type="text" id="color" name="Favorite_Color" value="<?php echo $color?>" required>
        </div>
                <div class="form-group">
                    <input type="submit" value="Submit" class="form-button">
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
