<?php
include("../connect.php");

if (isset($_GET['name'])) {
    $fileName = $_GET['name'];
    $filePath = 'gallery/' . $fileName;

    if (file_exists($filePath)) {
        unlink($filePath);
    }

    $sql = "DELETE FROM gallery WHERE name_picture = '$fileName'";
    if (mysqli_query($conn,$sql)) {
        echo "Image deleted successfully.";
        header("Location: gallery.php");
    } else {
        echo "Error deleting image: " . $conn->error;
    }

    mysqli_close($conn);
}
?>
