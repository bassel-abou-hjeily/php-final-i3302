<?php
session_start();
include("../connect.php");
include("navbar.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_SESSION['user_id'];

$firstname = $lastname = $email = $phone_nb = '';
$is_admin = false;

$sql = "SELECT * FROM account WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $firstname = $row['Firstname'];
    $lastname = $row['Lastname'];
    $email = $row['Email'];
    $phone_nb = $row['Phone_Nb'];

    if ($row['role'] !== 'admin') {
        header("Location: ../home.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="css/gallery_css.css">
</head>

<body>
    <h1>Gallery</h1>

    <form action="" method="post" enctype="multipart/form-data" class="form1">
        <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
        <label for="upload">Choose an image to upload:</label>
        <input type="file" name="upload" accept="image/*" required><br>
        <input type="submit" value="Upload">
    </form>

    <?php
    if (isset($_FILES['upload'])) {
        $file = $_FILES['upload'];
        $uploadDir = 'gallery/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($file['name']);
        preg_match('/\.([a-zA-Z0-9]+)$/', $file['name'], $matches);
        $ext = isset($matches[1]) ? strtolower($matches[1]) : '';
        
        $fileName = "ppic_" . time() . "." . $ext; 
        $uploadFile = $uploadDir . $fileName;

       
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $sql = "INSERT INTO gallery (name_picture) VALUES ('$fileName')";
                if (mysqli_query($conn, $sql)) {
                    echo "File successfully uploaded and saved to the database.<br>";
                    echo "File Name: " . $file['name'] . "<br>";
                } else {
                    echo "Error: The image already exists.";
                }
            }
     
    }

    $sql = "SELECT name_picture FROM gallery";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h3>Uploaded Images:</h3>";
        echo "<table>
                <tr>
                    <th>Image Name</th>
                    <th>Image</th>
                    <th>Delete</th>
                </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $filePath = 'gallery/' . $row['name_picture'];
            echo "<tr>
                    <td>" . $row['name_picture'] . "</td>
                    <td><img src='$filePath' alt='Uploaded Image' class='uploaded-image' width='100'></td>
                    <td><a href='delete_image.php?name=" . urlencode($row['name_picture']) . "'>Delete</a></td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No images found.";
    }

    mysqli_close($conn);
    ?>
</body>
</html>