<?php
include("../connect.php");
include("check.php");
include("navbar.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_SESSION['user_id'];

$firstname = $lastname = $email = $password = $confirmPassword = $phone_nb = '';
$error_message = '';
$is_admin = false;

$sql = "SELECT * FROM `account` WHERE `id` = '$id'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $firstname = $row['Firstname'];
    $lastname = $row['Lastname'];
    $email = $row['Email'];
    $phone_nb = $row['Phone_Nb'];

    if ($row['role'] == 'admin') {
        $is_admin = true;
    } else {
        header("Location: ../home.php");
    }
} 

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];

    $sql = "SELECT i.*, c.name as catName FROM items i, categories c WHERE i.Item_ID = '$item_id' AND i.CAT_ID = c.id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("SQL Error: " . mysqli_error($conn));
    }

    $product = mysqli_fetch_array($result);

    if (!$product) {
        echo "<p style='color: red;'>Product not found.</p>";
        exit();
    }

    $category_sql = "SELECT * FROM `categories`";
    $category_result = mysqli_query($conn, $category_sql);

    if (!$category_result) {
        die("SQL Error: " . mysqli_error($conn));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $nb_items = $_POST['nb_items'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $discount = $_POST['discount'];
    $fileName = $product['Picture'];
    $discount_end_date = $_POST['date1'];
    $categoryQuery = "SELECT Name FROM categories WHERE Id = '$category'";
    $categoryResult = mysqli_query($conn, $categoryQuery);
    $categoryRow = mysqli_fetch_assoc($categoryResult);
    $categoryName = $categoryRow['Name'];
    if (isset($_FILES['upload']) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['upload'];
        // $uploadDir = '../images/' . $product['category'] . '/';
        $uploadDir = '../images/' . $categoryName. '/';
        $uploadFile = $uploadDir . basename($file['name']);

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $fileName = $file['name'];
        } else {
            echo "<p style='color: red;'>Failed to upload file.</p>";
        }
    }

    // Update product details in the database
    $sql_update = "UPDATE items SET 
        Name = '$name',
        Description = '$description',
        Price = '$price',
        Add_Date = '$date',
        Status = '$status',
        Cat_ID = '$category',
        discount_percentage = '$discount',
        quantity = '$nb_items',
        discount_end_date = '$discount_end_date',
        Picture = '$fileName'
        WHERE Item_ID = '$item_id'";

    if (mysqli_query($conn, $sql_update)) {
     

        header("Location: all-products.php");
        echo "<script>window.location.reload();</script>";
        exit; 
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/edit_css.css">
</head>

<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form class="form1" action="" method="POST" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo $product['Name']; ?>" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4" required><?php echo $product['Description']; ?></textarea>

            <label for="price">Price</label>
            <input type="number" name="price" id="price" min='1' step="1" value="<?php echo $product['Price']; ?>" required>

            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="used" <?php if ($product['Status'] == 'used') echo 'selected'; ?>>Used</option>
                <option value="new" <?php if ($product['Status'] == 'new') echo 'selected'; ?>>New</option>
            </select>

            <label for="discount">Discount</label>
            <input type="number" name="discount" id="discount" step="1" max="100" min="0" value="<?php echo $product['discount_percentage']; ?>" required>

            <label for="nb_items">Number of Items</label>
            <input type="number" name="nb_items" id="nb_items" min="0" value="<?php echo $product['quantity']; ?>" required>

            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="<?php echo $product['Add_Date']; ?>" required>

            <label for="date1">Discount End Date</label>
            <input type="date" name="date1" id="date1" value="<?php echo $product['discount_end_date']; ?>" required>

            <label for="category">Category</label>
            <select name="category" id="category" required>
                <?php
                while ($category = mysqli_fetch_assoc($category_result)) {
                    echo "<option value='" . $category["Id"] . "' " . ($product['Cat_ID'] == $category['Id'] ? 'selected' : '') . ">" . $category["Name"] . "</option>";
                }
                ?>
            </select>

            <label for="upload">Product Image</label>
<input type="file" name="upload" id="upload" onchange="previewImage(event)">
<div id="image-preview-container">
    <img id="image-preview" src="" alt="Image Preview" style="display: none; width: 150px; height: auto; border: 1px solid #ddd; padding: 5px;">
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image-preview');
            output.src = reader.result;
            output.style.display = 'block'; 
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>


            <button type="submit">Update Product</button>
        </form>
    </div>
</body>

</html>
