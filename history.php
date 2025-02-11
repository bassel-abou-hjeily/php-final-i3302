<?php
session_start();
include("connect.php");
include("navbar.php");

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT 
    cart_products.id AS cart_id, cart_products.quantity, cart_products.status , cart_products.date_history,
    items.Name AS item_name,  items.Description,  items.Price,  items.discount_percentage,
    items.Price_after_discount, items.Picture, 
    categories.Name AS category_name
    FROM cart_products
    INNER JOIN items ON cart_products.product_id = items.Item_ID
    INNER JOIN categories ON items.Cat_ID = categories.Id
    INNER JOIN cart_owner ON cart_owner.id = cart_products.cart_id
    WHERE cart_owner.user_id = $user_id 
    AND  cart_products.status  ='history' 
    ORDER BY cart_products.date_history DESC";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {



        echo '<div class="page">';
        echo '<table border="1">' .
            '<tr>
         <th>Picture</th> <th>Name Item</th>  <th>Description</th> <th>Quantity</th>  <th> Price</th>  <th> Discount Percentage</th>  <th> Price After Discount</th>  <th>Total Price</th> <th>Date</th>
    </tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . '<img src="images/' . $row['category_name'] . '/' . $row['Picture'] . '" alt="Image" width="60px" height="60px">'  . '</td>' .
                "<td>" . $row["item_name"] . "</td>" .  "<td>" . $row["Description"] . "<td>" . $row["quantity"] .
                "</td>" . "<td>" . $row["Price"] . '$' . "</td>" . "<td>" . $row["discount_percentage"] . '%' . "</td>" .
                "<td>" . $row["Price_after_discount"] . '$' . "</td>" .  "<td>" . ($row["quantity"] * $row["Price_after_discount"])."$" . "</td>" . "<td>" . $row["date_history"] . "</td>";
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <style>
        .page {
            background-color: #eee;
            margin: 0px auto;
            height: 100vh;
            text-align: center;
            position: relative;
        }

        table {
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            border-spacing: 0;
            animation-name: fadeIn;
            animation-duration: 1s;
            width: 90%;
        }

        table th,
        table td {
            padding: 15px;
            margin: 20px;
        }
        table th{
            background-color: #333;
            color: white;
        }

        table tr:nth-child(odd){
           background-color: #ddd;
        }
        table tr:nth-child(even){
           background-color: white;
        }
    </style>
</head>

<body>

</body>

</html>