<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
        }

        /* Navbar styling */
        .navbar {
            display: flex;
            justify-content: center;
            background-color: black;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            /* Space between icon and text */
            transition: all 0.3s ease;
            border-radius: 5px;
        }

        .navbar a:hover {
            background-color: yellow;
            color: black;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .link.active {
            background-color: yellow;
            color: white;
            transform: scale(1.05);
            color: black;

        }

        span {
            position: absolute;
            left: 20px;
            top: 15px;
            background-color: white;
            padding: 10px;
            border-radius: 50%;
        }

        span:hover {
            background-color: yellow;
        }
    </style>
</head>

<body>
    <?php $current_page = basename($_SERVER['PHP_SELF']);?>
    
    <!-- Navigation Bar -->
    <a <?php if(isset($_SESSION["item_Id"]) && isset( $_SESSION["source"])){
            echo 'href = details_card.php?ID='.$_SESSION['item_Id'].'&source='. $_SESSION["source"];
            }else{
                echo 'href = home.php';
            }
            ?>>
         <span>
            <i class="fa-solid fa-arrow-left"></i>
        </span>
    </a>


    
    <nav class="navbar">
        <a href="cart.php"    class="link <?php echo ($current_page == 'cart.php') ? 'active' : ''; ?>"><i class="fa-solid fa-cart-shopping"></i>Cart</a>
        <a href="history.php" class="link <?php echo ($current_page == 'history.php') ? 'active' : ''; ?>"><i class="fa-solid fa-clock-rotate-left"></i> History</a>
        <a href="order.php"   class="link <?php echo ($current_page == 'order.php') ? 'active' : ''; ?>"><i class="fa-solid fa-truck"></i> Order</a>
    </nav>

</body>

</html>