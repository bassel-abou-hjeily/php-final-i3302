<?php
include("../connect.php");
include("check.php");
include("navbar.php");


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $product_id = $_POST["sub"];
    // echo $product_id;
    $sql = "UPDATE cart_products             
                SET cart_products.status = 'history',
                cart_products.date_history = NOW()
                WHERE cart_products.status = 'order' 
                and  cart_products.id = $product_id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Successful";
        // header("Location: all-users.php");
        // echo "<script>window.location.reload();</script>";
         header("Location: " . $_SERVER["REQUEST_URI"]);
         exit; 
    } else
        mysqli_error($conn);
}


$sql = "SELECT 
cart_products.id AS cart_id, cart_owner.user_id, account.id,account.Firstname,account.Lastname, account.Phone_nb, account.latitude, account.longitude, 
cart_products.quantity, cart_products.status ,  cart_products.date_order, cart_products.price as newPrice,
items.Name AS item_name,  items.Description,  items.Price,  items.discount_percentage,
items.Price_after_discount, items.Picture,
categories.Name AS category_name
FROM cart_products
INNER JOIN items ON cart_products.product_id = items.Item_ID
INNER JOIN categories ON items.Cat_ID = categories.Id
INNER JOIN cart_owner ON cart_owner.id = cart_products.cart_id
INNER JOIN account    ON account.id = cart_owner.user_id
WHERE cart_products.status ='order'
ORDER BY  cart_products.date_order DESC";


$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    echo '<div class="page">';
    echo '<form method="POST" action="">';
    echo '<table border="1">' .
        '<tr>
            <th>Picture</th> <th> Name of User</th>   <th> Number</th> <th>Name Item</th>  <th>Description</th>  <th>Quantity</th>
            <th> Price</th>  <th> Discount Percentage</th>  <th> Price After Discount</th>
            <th>Total Price</th> <th>Date</th> <th>Location</th> <th>Action</th>
        </tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . '<img src="../images/' . $row['category_name'] . '/' . $row['Picture'] . '" alt="Image" width="60px" height="60px">'  . '</td>' .
            "<td>" . $row["Firstname"] . ' '. $row["Lastname"] . "</td>". "<td>" . $row["Phone_nb"] . "</td>"   . "<td>" . $row["item_name"] . "</td>" 
            .  "<td>" . $row["Description"] . "<td>" . $row["quantity"] .
            "</td>" . "<td>" . $row["Price"] . '$' . "</td>" . "<td>" . $row["discount_percentage"] . '%' . "</td>" .
            "<td>" . $row["newPrice"] . '$' . "</td>" .  "<td>" . ($row["quantity"] * $row["newPrice"])."$" . "</td>" . '<td>' . $row["date_order"] . "</td>"
            . '<td>' . 
            '<a href="https://www.google.com/maps?q=' . $row["latitude"] . ',' . $row["longitude"] . '&z=15" target="_blank">Location</a>'.
            
            "</td>"

          . '<td>' . ' <button type="submit" style="cursor:pointer" value="' . $row['cart_id'] . '" name="sub">Delivered</button>  ' . "</td>";
        echo '</tr>';
    }

    echo '</table>';
    echo '</form>';

    echo '</div>';
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery</title>

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
            width: 95%;
        }

        table th,
        table td {
            padding: 15px;
            margin: 20px;
        }
        table th{
            background-color: #7bffb4;
            color: black;
        }

        table tr:nth-child(odd){
           background-color: #ddd;
        }
        table tr:nth-child(even){
           background-color: white;
        }

        form button {
            background-color: #ff5757;
            padding: 10px;
            border-radius: 5px;
            color: white;
        }
        form button:hover{
            background-color: yellow;
            color: black;
        }

        td a{
            text-decoration: none;
            color: white;
            background-color: green;
            padding: 10px;
            border-radius: 5px;
            
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                position: absolute;
                top: 10%;
                left: 50%;
                transform: translateX(-50%) scale(0.5);

            }

            to {
                opacity: 1;
                transform: scale(1);
                position: absolute;
                top: 10%;
                left: 50%;
                transform: translateX(-50%);

            }
        }
    </style>
</head>

<body>

</body>

</html>