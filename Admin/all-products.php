<?php
include("../connect.php");
include("check.php");
include("navbar.php");

if (isset($_GET['delete_id'])) {
    $delete_item_id =  $_GET['delete_id'];
    $delete_query = "UPDATE  items SET role = 0 WHERE Item_ID = '$delete_item_id'";

    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Item deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting item');</script>";
    }
    header("Location: all-products.php");
    exit();
}

// if (isset($_GET['delete_cat'])) {
//     $delete_cat_id =  $_GET['delete_cat'];
//     $delete_query = "DELETE FROM categories WHERE Id = '$delete_cat_id'";

//     if (mysqli_query($conn, $delete_query)) {
//         echo "<script>alert('category deleted successfully');</script>";
//     } else {
//         echo "<script>alert('Error deleting category');</script>";
//     }


//     header("Location: all-products.php");
//     exit();
// }


$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

$selected_category = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT items.Item_ID, items.Name AS item_name, items.Description, items.Price, items.role,
               items.discount_percentage, items.Price_after_discount, items.Add_Date, 
               items.Status, items.Picture, items.Cat_ID, items.quantity,items.discount_end_date, 
               categories.Name AS category_name
        FROM items
        INNER JOIN categories ON categories.Id = items.Cat_ID
        WHERE items.role = 1";

if ($selected_category) {
    $sql .= " AND categories.Name = '$selected_category'";
}

$sql .= " ORDER BY Add_Date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="css/all-products_css.css">
    <link rel="stylesheet" href="../css/all.min.css">

</head>

<body>
    <h1>All Products</h1>

    <?php
    echo '<nav>';
    echo '<a href="all-products.php" ';
    if (!isset($_GET["category"])) {
        echo 'class="active"';
    }
    echo '>All Items</a>';
    while ($category_row = mysqli_fetch_assoc($category_result)) {
        echo '<a href="all-products.php?category=' . $category_row['Name'] . '" ';
        if (isset($_GET["category"]) && $selected_category == $category_row['Name']) {
            echo 'class="active"';
        }
        echo '>' . $category_row['Name'] . '</a>';
    }
    echo '</nav>';

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<caption>Item List</caption>";
        echo "<thead>";
        echo "<tr><th>Image</th><th>Item Name</th><th>Description</th><th>Price</th><th>Discount (%)</th><th>Price After Discount</th><th>Add Date</th><th>discount_end_date</th><th>Status</th><th>Category</th><th>Quantity</th><th>Actions</th></tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            $item_id = $row['Item_ID'];
            $item_name = $row['item_name'];
            $description = $row['Description'];
            $price = $row['Price'];
            $discount_percentage = $row['discount_percentage'];
            $price_after_discount = $row['Price_after_discount'];
            $add_date = $row['Add_Date'];
            $status = $row['Status'];
            $image_name = $row['Picture'];
            $category = $row['category_name'];
            $quantity = $row['quantity'];
            $end_date = $row['discount_end_date'];
            echo '<tr id=' . $item_id . '>';
            echo '<td><img src="../images/' . $category . '/' . $image_name . '" alt="Image" width="60px" height="60px"></td>';
            echo "<td>" . $item_name . "</td>";
            echo "<td>" . $description . "</td>";
            echo "<td>" . $price . "</td>";
            echo "<td>" . $discount_percentage . "</td>";
            echo "<td>" . $price_after_discount . "</td>";
            echo "<td>" . $add_date . "</td>";
            echo "<td>" . $end_date . "</td>";
            echo "<td>" . $status . "</td>";
            echo "<td>" . $category . "</td>";
            echo "<td>" . $quantity . "</td>";
            echo "<td>";
            echo '<a href="edit.php?id=' . $item_id . '" class="btn btn-edit">Edit</a>';
            echo '<a href="all-products.php?delete_id=' . $item_id . '" class="btn btn-delete">Delete</a>';
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "No results found";
        $category_query = "SELECT * FROM categories WHERE Name='$selected_category'";
        $category_result = mysqli_query($conn, $category_query);
        $row = mysqli_fetch_assoc($category_result);

        // $id = $row['Id'];
        // echo '<a href="all-products.php?delete_cat=' . $id . '" class="btn btn-delete" > Delete This Category  </a>';
    }
    ?>

</body>

</html>