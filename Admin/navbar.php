<?php

include("../connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
        }

        /* Navbar styling */
        .navbar {
            display: flex;
            justify-content: space-between;
            background-color: #616662bd;
            padding: 15px 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .navbar .left {
            display: flex;
            justify-content: start;

        }

        .navbar .right {
            display: flex;
            justify-content: start;

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
            background-color: #ffff63;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            color: black;
        }

        .link.active {
            background-color: #ffff63;
            color: white;
            transform: scale(1.05);
            color: black;

        }

        /* a:focus{
            background-color: yellow;
        } */
    </style>
</head>

<body>

    <!-- Navigation Bar -->

    <?php
        $current_page = basename($_SERVER['PHP_SELF']);

    ?>


    <form action="" method="get">
       
        <nav class="navbar">
            <div class="left">
                <a href="../index.php" class="link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>"><i class="fas fa-home"></i> Home</a>
                <a href="gallery.php" class="link <?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>"><i class="fa-brands fa-envira"></i> Gallery</a>
                <a href="all-users.php" class="link <?php echo ($current_page == 'all-users.php') ? 'active' : ''; ?>"><i class="fa-solid fa-user"></i> All Users</a>
                <a href="all-products.php" class="link <?php echo ($current_page == 'all-products.php') ? 'active' : ''; ?>"><i class="fa-brands fa-product-hunt"></i> All products</a>
                <a href="add-product.php" class="link <?php echo ($current_page == 'add-product.php') ? 'active' : ''; ?>"><i class="fa-solid fa-plus"></i> Add a product</a>
                <a href="add-category.php" class="link <?php echo ($current_page == 'add-category.php') ? 'active' : ''; ?>"><i class="fa-solid fa-plus"></i>   Add Category</a>
                <a href="delivery.php" class="link <?php echo ($current_page == 'delivery.php') ? 'active' : ''; ?>"><i class="fa-solid fa-truck"></i>Delivery</a>
            </div>

            <div class="right">
                <a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </div>
        </nav>
    </form>

</body>

</html>