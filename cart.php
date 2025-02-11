<?php
session_start();
include("connect.php");
include("navbar.php");

if (!isset($_SESSION['user_id'])) {
    echo '<p class="no-data">Please log in to view your cart.</p>';
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["order_now"])) {


        $user_id = $_SESSION['user_id'];
        $sql = "SELECT 
        cart_products.id AS cart_id, cart_products.quantity as qua, cart_products.status,
        items.Name AS item_name,  items.Description,  items.Price,  items.discount_percentage,
        items.Price_after_discount, items.Picture,  items.quantity as quan,
        categories.Name AS category_name
        FROM cart_products
        INNER JOIN items ON cart_products.product_id = items.Item_ID
        INNER JOIN categories ON items.Cat_ID = categories.Id
        INNER JOIN cart_owner ON cart_owner.id = cart_products.cart_id
        WHERE cart_owner.user_id = $user_id 
        AND cart_products.status ='cart'  ";

        $result = mysqli_query($conn, $sql);
        $quantity1 = [];

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($quantity1, $row["qua"]);
            }
        }
        $quantityProduct = [];
        foreach ($quantity1 as $str) {
            $quantityProduct[] = (int) $str;
        }

        $sql = "SELECT 
        cart_products.id AS cart_id, cart_products.quantity, cart_products.status ,  cart_products.date_order,
        items.Name AS item_name,  items.Description,  items.Price,  items.discount_percentage,
        items.Price_after_discount, items.Picture, items.quantity as quan,
        categories.Name AS category_name
        FROM cart_products
        INNER JOIN items ON cart_products.product_id = items.Item_ID
        INNER JOIN categories ON items.Cat_ID = categories.Id
        INNER JOIN cart_owner ON cart_owner.id = cart_products.cart_id
        WHERE cart_owner.user_id = $user_id 
        AND  cart_products.status ='cart' ";

        $result = mysqli_query($conn, $sql);
        $newQuantity1 = [];
        $arrPrice = [];
        $arrDiscount = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($newQuantity1, $row["quan"]);
                array_push($arrPrice, $row["Price_after_discount"]);
                array_push($arrDiscount, $row["discount_percentage"]);
            }
        }
        
        $quantityItem = [];
        $newPrice = [];
        $newDiscount = [];
        foreach ($newQuantity1 as $str) {
            $quantityItem[] = (int) $str;
        }
        foreach ($arrPrice as $str) {
            $newPrice[] = (int) $str;
        }
        foreach ($arrDiscount as $str) {
            $newDiscount[] = (int) $str;
        }

        
        $quantity = [];
        for ($i = 0; $i < count($quantityProduct); $i++) {
            $quantity[$i] = $quantityItem[$i] - $quantityProduct[$i];
        }


        for ($i = 0; $i < count($quantityProduct); $i++) {

            $sql = "UPDATE items,  categories, cart_owner, cart_products
            set items.quantity =  $quantity[$i]
            where cart_products.product_id = items.Item_ID
            and   items.Cat_ID = categories.Id
            and   cart_owner.id = cart_products.cart_id
            and   cart_owner.user_id = $user_id";

            $result = mysqli_query($conn, $sql);
        }

        for ($i = 0; $i < count($quantityProduct); $i++) {
            $sql = "UPDATE cart_products              
            set status = 'order',
            price = $newPrice[$i],
            discount = $newDiscount[$i],
            date_order = now()
            where status = 'cart' 
            LIMIT 1";

            $result = mysqli_query($conn, $sql);
        }



        header("Location: order.php");
        exit;
    }
}


if (isset($_POST['update_quantity'])) {
    $cart_id = $_POST['cart_id'];
    $new_quantity = $_POST['quantity'];
    if ($new_quantity > 0) {
        $update_query = "UPDATE cart_products SET quantity = $new_quantity WHERE id = $cart_id AND status='cart'";
        mysqli_query($conn, $update_query);
    }
} elseif (isset($_POST['delete_item'])) {
    $cart_id = $_POST['cart_id'];
    $delete_query = "DELETE FROM cart_products WHERE id = $cart_id AND status='cart'";
    mysqli_query($conn, $delete_query);
}


$user_id = $_SESSION['user_id'];
$sql = "SELECT 
    cart_products.id AS cart_id, cart_products.quantity, cart_products.status,
    items.Name AS item_name,  items.Description,  items.Price,  items.discount_percentage,
    items.Price_after_discount, items.Picture, items.quantity as quan,
    categories.Name AS category_name
    FROM cart_products
    INNER JOIN items ON cart_products.product_id = items.Item_ID
    INNER JOIN categories ON items.Cat_ID = categories.Id
    INNER JOIN cart_owner ON cart_owner.id = cart_products.cart_id
    WHERE cart_owner.user_id = $user_id 
    AND cart_products.status ='cart' ";

$result = mysqli_query($conn, $sql);

$total_quantity = 0;
$total_price = 0;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/cart_css.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="products-section">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $item_total = $row['Price_after_discount'] * $row['quantity'];
                    $total_quantity += $row['quantity'];
                    $total_price += $item_total;
                    echo '
                <div class="product-card">
                    <div class="product-image">
                        <img src="images/' . $row['category_name'] . '/' . $row['Picture'] . '" alt="Image" width="60px" height="60px">
                    </div>
                    <div class="product-details">
                        <form method="POST" style="position:relative;">
                            <input type="hidden" name="cart_id" value="' . $row['cart_id'] . '">
                            <button type="submit" name="delete_item" class="delete-icon"><i class="fas fa-trash-alt"></i></button>
                        </form>
                        <h2 class="product-name">' . $row['item_name'] . '</h2>
                        <p class="category">' . $row['Description'] . '</p>
                        <div class="pricing">
                            <p class="price">$' . $row['Price_after_discount'] . '</p>
                            <p class="total-price">$' . $item_total . '</p>
                        </div>
                        <form method="POST" class="quantity-controls">
                            <input type="hidden" name="cart_id" value="' . $row['cart_id'] . '">
                           <lable> Quantity <input type="number" name="quantity" value="' . $row['quantity'] . '" min="1" class="quantity-input" max="' . $row['quan'] . '"  ">  </lable>
                            <button type="submit" name="update_quantity">Update</button>
                        </form>
                    </div>
                </div>';
                }
            } else {
                echo '<p class="no-data">No products in the cart.</p>';
            }

            ?>
        </div>

        <form action="" method="POST">
            <div class="summary-section">
                <div class="summary-card">
                    <div class="summary-header">Summary</div>
                    <div class="summary-row">
                        <p>Total Quantity</p>
                        <p><?php echo $total_quantity; ?></p>
                    </div>
                    <div class="summary-row">
                        <p>Total Price</p>
                        <p>$<?php echo $total_price; ?></p>
                    </div>
                    <input type="submit" value="Order Now" name="order_now" class="payment-button">
                </div>
            </div>
        </form>

    </div>


</body>

</html>