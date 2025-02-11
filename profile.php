<?php
session_start();
if (isset($_SESSION['update_success']) && $_SESSION['update_success'] === true) {
    unset($_SESSION['update_success']);
}
?>
<?php
include("./connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];
$firstname = $lastname = $email = $password = $confirmPassword = $phone_nb = $latitude = $longitude = '';
$error_message = '';

$sql = "SELECT * FROM account WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $firstname = $row['Firstname'];
    $lastname = $row['Lastname'];
    $email = $row['Email'];
    $phone_nb = $row['Phone_Nb'];
    $confirmPassword = $row['ConfirmPassword'];
    $password = $row['Password'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['Email']);
    $password = trim($_POST['Password']);
    $confirmPassword = trim($_POST['ConfirmPassword']);
    $phone_nb = trim($_POST['Phone_Nb']);
    $latitude = trim($_POST['latitude']);
    $longitude = trim($_POST['longitude']);

    if (!preg_match('/^[a-zA-Z\s]+$/', $firstname) || !preg_match('/^[a-zA-Z\s]+$/', $lastname)) {
        $error_message = "First name and Last name should only contain alphabetic characters and spaces!";
    } elseif (!preg_match('/^\+?[0-9]{8,15}$/', $phone_nb)) {
        $error_message = "Phone number must contain only numbers and optionally start with a '+' sign!";
    } elseif (!preg_match('/^.{8,}$/', $password)) {
        $error_message = "Password must be at least 8 characters long!";
    } elseif ($password !== $confirmPassword) {
        $error_message = "Passwords do not match!";
    } else {
        $password = bin2hex(mhash(MHASH_GOST, $Password));
        $confirmPassword = bin2hex(mhash(MHASH_GOST, $ConfirmPassword));
        $sql = "UPDATE account SET 
                    Firstname = '$firstname', 
                    Lastname = '$lastname', 
                    Email = '$email', 
                    Password = '$password', 
                    Phone_Nb = '$phone_nb', 
                    ConfirmPassword = '$confirmPassword',
                    Latitude = '$latitude',
                    Longitude = '$longitude'
                WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['update_success'] = true;
            header("Location: home.php");
            exit;
        } else {
            $error_message = "Error updating profile: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #fff;
    color: #333;
}

.update-container {
position: relative;
    width: 100%;
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.update-form {
    display: flex;
    flex-direction: column;
}

.form-title {
    text-align: center;
    font-size: 24px;
    color: #f2a900;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-size: 14px;
    color: #333;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #f2a900;
    outline: none;
}

button[type="button"] {
    padding: 10px;
    font-size: 14px;
    background-color: #f2a900;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button[type="button"]:hover {
    background-color: #d88c00;
}

/* Submit Button */
.form-button {
    margin-top: 20px;
    padding: 10px;
    font-size: 14px;
    background-color: #000;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form-button:hover {
    background-color: #444;
}

.error-message p {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}

.Exit {
    position: absolute;
    top: 10px;
    right: 10px;
}

.Exit img {
    cursor: pointer;
}

#map {
    margin-top: 20px;
    border-radius: 10px;
}

@media (max-width: 600px) {
    .update-container {
        width: 90%;
        padding: 15px;
    }
    .form-title {
        font-size: 20px;
    }
}
</style>
</head>
<body>
    <div class="update-container">
        <form name="updateProfile" method="post" class="update-form">
            <h1 class="form-title">Update Profile</h1>
            <div class="Exit"><a href="home.php"><img src="./images/Exit.ico" alt="Exit" width="40px" height="40px"></a></div>
            <div class="form-group">
                <label for="firstname">Firstname</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" required>
            </div>
            <div class="form-group">
                <label for="lastname">Lastname</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="Email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="Password" value="" >
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="ConfirmPassword" value="" >
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="Phone_Nb" value="<?php echo $phone_nb; ?>" required>
            </div>
            <!-- Display Map if Latitude and Longitude Exist -->
            <div id="map" style="height: 300px;"></div>

            <input type="hidden" id="latitude" name="latitude" value="<?php echo $latitude; ?>">
            <input type="hidden" id="longitude" name="longitude" value="<?php echo $longitude; ?>">

            <button type="button" onclick="getLocation()">Add Location</button>
            <input type="submit" value="Update" class="form-button">
            <div class="error-message">
                <p><?php if ($error_message !== '') echo $error_message; ?></p>
            </div>
        </form>
    </div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // let latitude = <//?php echo json_encode($latitude); ?>;
        // let longitude = <//?php echo json_encode($longitude); ?>;
        let latitude = <?php echo $latitude; ?>;
        let longitude = <?php echo $longitude; ?>;
        let map;
        let marker;

        // Initialize map if latitude and longitude are available
        if (latitude && longitude) {
            map = L.map('map').setView([latitude, longitude], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            marker = L.marker([latitude, longitude]).addTo(map);
            marker.bindPopup("Your current location").openPopup();
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lon;

                    // Update map with new location
                    if (map) {
                        map.setView([lat, lon], 13);
                        marker.setLatLng([lat, lon]);
                    } else {
                        map = L.map('map').setView([lat, lon], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);
                        marker = L.marker([lat, lon]).addTo(map);
                        marker.bindPopup("Your current location").openPopup();
                    }
                }, function(error) {
                    alert("Geolocation error: " + error.message);
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
    </script>
</body>
</html>