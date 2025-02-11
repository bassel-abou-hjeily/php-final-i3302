<?php
include("../connect.php");
include("check.php");
include("navbar.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/add-product_css.css">
    <link rel="stylesheet" href="../css/all.min.css">
</head>

<body>

    <h1>Add Product</h1>

    <?php
    $sql = "SELECT * FROM `categories`";
    $result = mysqli_query($conn, $sql);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $nb_items = $_POST['nb_items'];
        $date = $_POST['date'];
        $category = $_POST['category'];
        $discount = $_POST['discount'];
        $end_date = $_POST['date2'];
        $fileName = 'default.jpg';
        $categoryQuery = "SELECT Name FROM categories WHERE Id = '$category'";
        $categoryResult = mysqli_query($conn, $categoryQuery);
        $categoryRow = mysqli_fetch_assoc($categoryResult);
        $categoryName = $categoryRow['Name'];

        if (isset($_FILES['upload'])) {
            $file = $_FILES['upload'];
            $uploadDir = '../images/' . $categoryName . '/';
            $uploadFile = $uploadDir . basename($file['name']);

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if ($file['error'] === UPLOAD_ERR_OK) {

                if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    $fileName = $file['name'];
                } else {
                    echo "<p style='color: red;'>Failed to upload file.</p>";
                }
            } else {
                echo "<p style='color: red;'>Error during file upload: " . $file['error'] . "</p>";
            }
        }

        $sql_insert = "INSERT INTO items (Name, Description, Price, Add_Date,discount_end_date, Status, Cat_ID,discount_percentage, quantity, Picture)
                       VALUES ('$name', '$description', '$price', '$date','$end_date' ,'$status', '$category','$discount','$nb_items', '$fileName')";

        if (mysqli_query($conn, $sql_insert)) {
            echo "<p style='color: green;'>Product added successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }

    ?>

    <form action="" method="POST" enctype="multipart/form-data" class="form1">
        <div class="form-heading">Fill the details below</div>

        <label for="name">Name</label>
        <input type="text" name="name" id="name" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4" required></textarea>

        <label for="price">Price</label>
        <input type="number" name="price" id="price" step="0.01" required>

        <label for="status">Status</label>
        <select name="status" id="status" required>
            <option value="used">Used</option>
            <option value="new">New</option>
        </select>

        <label for="discount">discount</label>
        <input type="number" name="discount" id="discount" step="1" max="100" min="0" required>

        <label for="nb_items">Number of Items</label>
        <input type="number" name="nb_items" id="nb_items" required>

        <label for="date">Date add</label>
        <input type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" required>
        <label for="date">Date end discount</label>
        <input type="date" name="date2" id="date2" value="<?php echo date('Y-m-d');  ?>" required>



        <label for="category">Category</label>
        <select name="category" id="category" required>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row["Id"] . "'>" . $row["Name"] . "</option>";
                }
            }
            ?>
        </select>

        <label for="upload">Product Image</label>
        <input type="file" name="upload" id="upload" required>

        <button type="submit">Add Product</button>
    </form>
</body>

</html>