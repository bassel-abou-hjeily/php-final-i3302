<?php
session_start();
include("connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$is_admin = false;
$sql = "SELECT * FROM `account` WHERE `id` = '$user_id'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row['role'] == 'admin') {
        $is_admin = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/details_card.css">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
</head>

<body>
    <form action="" method="POST">
        <?php

        if (isset($_POST['addToCart']) && isset($_GET["ID"])) {

            $_SESSION["item_Id"] = $_GET["ID"];
            $_SESSION["source"] = $_GET["source"];

            $checkCart = "SELECT id FROM cart_owner WHERE user_id = $user_id LIMIT 1";
            $cartResult = mysqli_query($conn, $checkCart);

            if (mysqli_num_rows($cartResult) == 0) {
                $createCart = "INSERT INTO cart_owner (user_id) VALUES ($user_id)";
                if (mysqli_query($conn, $createCart)) {
                    $cart_id = mysqli_insert_id($conn);
                } else {
                    echo "<script>alert('Error creating cart: " . mysqli_error($conn) . "');</script>";
                    exit;
                }
            } else {
                $cart_row = mysqli_fetch_assoc($cartResult);
                $cart_id = $cart_row['id'];
            }

            $checkProductInCart = "SELECT quantity FROM cart_products
                                   WHERE cart_id = $cart_id AND product_id = $_GET[ID] AND status= 'cart'";
            $productResult = mysqli_query($conn, $checkProductInCart);

            if (mysqli_num_rows($productResult) > 0) {
                $updateQuantity =    "UPDATE cart_products 
                                      SET quantity = quantity + 1 
                                      WHERE cart_id = $cart_id AND product_id = $_GET[ID]";
                if (mysqli_query($conn, $updateQuantity)) {
                    header("Location: cart.php");
                    exit;
                } else {
                    exit;
                }
            } else {
                $sql ="INSERT INTO cart_products (cart_id, product_id, quantity,status, price) 
                       SELECT $cart_id AS cart_id, i.Item_ID AS product_id, 1 AS quantity, 'cart' , 0
                       FROM items i 
                       WHERE i.Item_ID = $_GET[ID]";




                if (mysqli_query($conn, $sql)) {
                    header("Location: cart.php");
                    exit;
                } else {
                    $error_message = "Error: " . mysqli_error($conn);
                }
            }
        }
        else{
            // unset($_SESSION["item_Id"]);
        }

        if (isset($_GET["ID"]) || (isset($_SESSION["item_Id"]) && isset($_SESSION["source"]))) {
            if(isset($_GET["ID"])){
                $card = "SELECT i.*, c.Name as catName,c.id as catId FROM items i, categories c
                WHERE i.Item_ID = " . $_GET["ID"] . " AND i.Cat_ID = c.id";
            }
            else if((isset($_SESSION["item_Id"]) && isset($_SESSION["source"]))){
                $card = "SELECT i.*, c.Name,c.id as catId FROM items i, categories c
                WHERE i.Item_ID = " . $_SESSION["item_Id"] . " AND i.Cat_ID = c.id";
            }
            $r_card = mysqli_query($conn, $card);

            while ($res = mysqli_fetch_array($r_card)) { ?>

                <div class="blurr">
                    <div class="details_cardd" id="details_cardd">
                        <div class="nav_cardd">
                            <div class="info">Info</div>
                            <?php 
                             if(isset($_GET["ID"])){
                        echo    '<div class="Exit">
                                    <a href=' . $_GET["source"] . '.php' . '?categorie=' . $res['catId'] . '#' . $_GET["ID"] . '>
                                        <img src="./images/Exit.ico" alt="Exit" width="40px" height="40px">
                                    </a>
                                </div> ';
                                unset($_SESSION["item_Id"]);
                                unset($_SESSION["source"]);
                             }
                             else if((isset($_SESSION["item_Id"]) && isset($_SESSION["source"]))){
                                echo    '<div class="Exit">
                                <a href=' . $_SESSION["source"] . '.php' . '?categorie=' . $res['catId'] . '#' . $_SESSION["item_Id"] . '>
                                    <img src="./images/Exit.ico" alt="Exit" width="40px" height="40px">
                                </a>
                                </div> ';
                             }
                                
                           ?>
                        </div>
                        <div class="body_card">

                            <div class="name_card"><?php echo $res["Name"]; ?></div>

                            <div class="image">
                                <img src="images/<?php echo $res["Name"] ?>/<?php echo $res["Picture"] ?>" alt="Tree Tech">
                            </div>

                            <div class="p_description pi">
                                <div class="Description_card N">Description</div>
                                <input class="result_c" disabled value="<?php echo $res["Description"]; ?>" style="min-height:fit-content; max-height:100px; overflow:auto;">
                            </div>

                            <div class="p_price pi">
                                <div class="price_card N">Price</div>
                                <div class="result_c"><?php echo $res["Price_after_discount"].'$'; ?></div>
                            </div>

                            <div class="p_status pi">
                                <div class="status_card N">Status</div>
                                <div class="result_c"><?php echo $res["Status"]; ?></div>
                            </div>

                            <div class="p_nb_items pi">
                                <div class="nb_items_card N">Nb_items</div>
                                <div class="result_c"><?php echo $res["quantity"]; ?></div>
                            </div>

                            <div class="p_date pi">
                                <div class="date_card N">Date</div>
                                <div class="result_c"><?php echo $res["Add_Date"]; ?></div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="picture">
                    <img src="images/<?php echo $res["catName"] ?>/<?php echo $res["Picture"] ?>" alt="Tree Tech">
                </div>
                <div class="sub">
                    <?php
                    if ($res["quantity"] > 0) {
 echo !$is_admin ? '<p> <input type="submit" value="Add to Cart" name="addToCart" >  </p>  <p> <a href="http://wa.me/96171184211">Contact On Whatsapp</a> </p>' : ''; 
                    }
                    ?>
                   
                </div>

                <div class="contact">
                    <?php
                    if ($res["quantity"] <= 0) {
                        echo "<p class='last_child'>";
                        echo '<i class="fa-solid fa-circle-exclamation"></i>' . " Out Of Stock";
                        echo "</p>";
                    }
                    ?>
                </div>

        <?php }
        } ?>

    </form>
</body>

</html>