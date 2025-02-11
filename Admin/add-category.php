<?php
session_start();
include("../connect.php");

include("navbar.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if(isset($_POST["sub"])){
    $is_admin = false;
    $input = $_POST['upload'];
    $sql = "INSERT INTO Categories(Name) values('$input')  ";
    $result = mysqli_query($conn, $sql);
    
    if($result)
        echo "Successful";
    else
        echo mysqli_error($conn);

    // if ($result && mysqli_num_rows($result) > 0) {  
    
    //     if ($row['role'] == 'admin') {
    //         $is_admin = true;
    //     } else {
    //         header("Location: ../home.php");
    //         exit;
    //     }
    // } 

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="css/add-category_css.css">
</head>

<body>
    <h1>Add Category</h1>

    <form action="" method="post" enctype="multipart/form-data" class="form1">
        <label for="upload">Category Name:</label>
        <input type="text" name="upload"  required><br>
        <input type="submit" value="Add Category" name="sub">
    </form>


</body>

</html>