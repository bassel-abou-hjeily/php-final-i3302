<?php

session_start();

include("./connect.php");

$now = '';
if (isset($_SESSION['user_id'])) {

    $id = $_SESSION['user_id'];
} else {
    $id = '';
}


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
        include("./homeNavbar.php");
    }
}

$ss = "SELECT * FROM account where role = 'admin' ;";
$query = mysqli_query($conn, $ss);
$r_profile = mysqli_fetch_array($query);

$gal = "SELECT * FROM gallery";
$r_gal = mysqli_query($conn, $gal);
$i_gal = mysqli_fetch_all($r_gal);

$now = date('Y-m-d H:i:s');


?>

<!DOCTYPE html>
<html lang="en">

<head>


    <script>
        window.onload = function() {
            document.querySelector("#logoImage").style.paddingLeft = 0;
        };
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {


            if (window.pageYOffset > 350) {

                document.querySelector(".galleryy").className = "galleryy slideUp";
                document.querySelector(".galleryy").style.visibility = "visible";
            }

            if (window.pageYOffset > 1000) {

                document.querySelector(".categoriesContainer").className = "categoriesContainer slideUp";
                document.querySelector(".categoriesContainer").style.visibility = "visible";
            }

        }
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree Tech</title>
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">


</head>

<body>
    <form class="form" action="./details_card.php" method="get">
        <div class="landing">
            <div class="container">
                <div class="circle_orange"></div>
                <div class="circle_purple"></div>
                <div class="content_img">
                    <div class="content">
                        <div class="text">
                            <div class="text_header"><span>T</span>ree <span>T</span>ech</div>
                            <div class="text_content slideUp">
                                <span class="s1">GREAT TECH GREAT BUSINESS</span>
                                <span class="s2">
                                    Internet installation, immediate sale <br>
                                    and maintenance of cellular devices,<br>
                                    sales and recharging of lines, installing <br>
                                    and maintaining Cameras
                                </span>
                            </div>
                        </div>
                    </div>
                    <img class="image" id="logoImage" src="images/img3.png" />
                </div>
                <div class="homeNavbar">
                    <div class="logo">

                        <img src="images/img2.png" alt="Tree Tech" class="img_logo">

                    </div>
                    <div class="nav">
                        <ul class="ul">
                            <li class="categories">
                                Categories
                                <ul class="category">
                                    <?php
                                    $cat = "SELECT  * FROM categories";
                                    $r_cat = mysqli_query($conn, $cat);
                                    while ($category = mysqli_fetch_array($r_cat)) {
                                        $res = "SELECT  i.Name as itemName , c.Name as categoryName , i.* , c.* FROM items i,categories c WHERE i.Cat_ID=c.Id and i.Cat_ID=" . $category['Id'] . " ORDER BY i.discount_percentage DESC";
                                        $r_res = mysqli_query($conn, $res);
                                        if (mysqli_num_rows($r_res) > 0) {

                                            echo '<li><a href="#' . $category['Name'] . '">' . $category['Name'] . '</a></li>';
                                        }
                                    }
                                    ?>

                                </ul>
                            </li>
                            <li class="gallery"><a href="#gallery">Gallery</a></li>
                            <li class="about"><a href="#about">About</a></li>
                            <li class="contact"><a href="#contact">Contact</a></li>
                            <?php echo !$is_admin  ? '<li class="cart"><a href="./cart.php"><i class="fa fa-shopping-cart"></i></a></li>' : ''; ?>
                            <?php echo !$is_admin ? '<li class="logout"><a href="./logout.php"><i class="fa fa-sign-out-alt"></i></a></li>' : ''; ?>
                            <li class="settings"><a href="./profile.php"><i class="fa-solid fa-user"></i></a></li>


                        </ul>
                        <!-- todo navbar button for small window -->
                        <button class="toggle-menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--! //////////////////////////////////////////////////////////////////////////////////// -->
        <!-- Gallery -->
        <div class="to">
            <h1 class="sectionTitle" id="gallery"><span>G</span>ALLERY</h1>
            <div class="galleryy">
                <div class="container">
                    <div class="slide">
                        <?php foreach ($i_gal as $res) { ?>
                            <div class="item" style="background-image: url(Admin/gallery/<?php echo $res[0] ?>); background-repeat: no-repeat;"></div>
                        <?php } ?>
                    </div>
                    <div class="buttons">
                        <button id="prev"><i class="fa-solid fa-angle-left"></i></button>
                        <button id="next"><i class="fa-solid fa-angle-right"></i></button>
                    </div>
                </div>
            </div>
            <!--! //////////////////////////////////////////////////////////////////////////////////// -->
            <!-- Categories -->

            <div class="categoriesContainer">
                <div class="container">
                    <h1 class="sectionTitle"><span>C</span>ategories</h1>
                    <?php
                    $cat = "SELECT  * FROM categories";
                    $r_cat = mysqli_query($conn, $cat);
                    while ($category = mysqli_fetch_array($r_cat)) {
                        $res = "SELECT  i.Name as itemName,i.role  , c.Name as categoryName , i.* , c.*
                         FROM items i,categories c
                         WHERE i.Cat_ID=c.Id and i.role = 1  and i.Cat_ID=" . $category['Id'] . " 
                         ORDER BY i.discount_percentage DESC, Add_Date DESC";
                        $r_res = mysqli_query($conn, $res);
                        if (mysqli_num_rows($r_res) > 0) {

                            $categoryNameWithoutFirstLetter = substr($category['Name'], 1);
                            echo '
                             <div class="' . $category['Name'] . ' outerContainer " id="' . $category['Name'] . '">
                             <h3 class="title" id="accessories"><span>' . $category['Name'][0] . '</span>' . $categoryNameWithoutFirstLetter . '</h3>

                        <div class="InnerContainer ">.';
                            while ($item = mysqli_fetch_array($r_res)) {
                                echo '
                                <div class="card" id=' . $item['Item_ID'] . '>
                                    <a href="details_card.php?ID=' . $item['Item_ID'] . '&source=home">
                                        <Div class="product-card">
                                            <img src="images/' . $category['Name'] . '/' . $item['Picture'] . '" alt="Product" class="product-card__image" />
                                            <figcaption class="product-card__caption">
                                                <header class="product-card__header">
                                                    <h2 class="product-card__title">' . $item['itemName'] . '</h2>
                                                    <p class="product-card__subtitle">' . $item['Description'] . '</p>
                                                </header>
                                                <footer class="product-card__footer">
                                                    ';

                                if ($item['discount_percentage'] > 0 && $item['discount_end_date'] > $now) {
                                    echo '<div class="on-sale-badge"> SALE &nbsp;' . $item['discount_percentage'] . '%</div>';
                                    echo  " <span style='color:Black;' >  &nbsp;</span><span style='color:green;'> $" . $item['Price_after_discount'] . " &nbsp; </span>  <span style='color:Black;' >  &nbsp;</span> <span style='color:gray;text-decoration: line-through;'>$" . $item['Price'] . "</span>";
                                } else if ($item['discount_percentage'] > 0 && $item['discount_end_date'] < $now) {

                                    $update = "update items set discount_percentage=0 where Item_ID=" . $item['Item_ID'];
                                    mysqli_query($conn, $update);
                                    $item['discount_percentage'] = 0;
                                    $discounted_price = $item['Price'] - ($item['Price'] * ($item['discount_percentage'] / 100));



                                    echo  " <span class='product-card__price'> $" . number_format($discounted_price) . " </span>";
                                } else {
                                    echo  " <span class='product-card__price'> $" . $item['Price'] . " </span>";
                                }


                                echo '
                                                </footer>

                                            </figcaption>
                                        </Div>
                                    </a>
                                </div>';
                            }
                            echo '  </div>  
                            <click class="parent_btn">    
                                <a href="show_items.php?categorie=' . $category['Id'] . '">
                                    <div class="btn">View Collection</div>
                                </a>
                            </click>
           </div>
  ';
                        }
                    } ?>


                </div>
            </div> <!-- Start About -->
            <div class="aboutt" id="about">
                <div class="container">
                    <h1 class="sectionTitle"><span>A</span>bout</h1>
                    <p>Less is more work</p>
                    <div class="about-content">
                        <div class="image">
                            <img src="images\about.jpg" alt="">
                        </div>
                        <div class="text">
                            <p>
                                Sell New/Used Mobile Phones with best price, private cell mission is very simple:<br>
                                &nbsp;&nbsp;-&nbsp;Make our customers feel happy<br>
                                &nbsp;&nbsp;-&nbsp;Sell all kinds of mobile phone, laptop
                            </p>
                            <hr>
                            <p>
                                Installing and maintaining <span class="cam">CAMERAS <img src="./images/camera/camera.png"> </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End About -->

            <!--! //////////////////////////////////////////////////////////////////////////////////// -->

            <!-- Start Contact -->
            <?php

            ?>
            <div class="contactt" id="contact">
                <div class="container">
                    <h3 class="sectionTitle"><span>C</span>ontact</h3>
                    <p>We are born to create</p>
                    <div class="info">
                        <p class="label">Feel free to drop us a line at:</p>
                        <a href="mailto:TreeTech@mail.com?subject=Contact" class="link">TreeTech@gmail.com</a>
                        <div class="social">
                            Find Us On Social Networks
                            <i class="fab fa-instagram"></i>
                            <i class="fab fa-whatsapp"></i>
                            <i class="fab fa-facebook"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Contact -->

            <!--! //////////////////////////////////////////////////////////////////////////////////// -->

            <!-- Start Footer -->
            <div class="footer">
                <div class="container">
                    <div class="chield">
                        <div class="icon">
                            <img src="images/logo.ico" alt="">
                        </div>
                        <div class="second">
                            <div class="text">
                                <h2>Contact Me</h2>
                            </div>
                            <p>71 - 102 801</p>
                            <div class="phone-number">
                                <p id="ph_nb"></p>
                            </div>
                            <div class="text">
                                <h2>WE ARE SOCIAL</h2>
                            </div>
                            <div class="media">
                                <i class="fab fa-facebook-f"></i>
                                <i class="fab fa-whatsapp"></i>
                                <i class="fab fa-instagram"></i>
                            </div>
                        </div>
                        <div class="third">
                            <div class="text">
                                <h2>Designed by</h2>
                            </div>
                            <div class="author">
                                <p class="hassan mohammad">
                                    Mohammad Diab
                                </p>
                                <p class="number"><a href="http://wa.me/96171184211">71 - 184 211</a></p>
                            </div>
                            <div class="author">
                                <p class="ali mohammad">
                                    Mohammad Saleh
                                </p>
                                <p class="number"><a href="http://wa.me/96103079306">03 - 079 306</a></p>
                            </div>

                            <div class="author">
                                <p class="ali mohammad">
                                    Bassel Abou Hjeily
                                </p>
                                <p class="number"><a href="http://wa.me/96171493637">71 - 493 637</a></p>
                            </div>
                            <div class="author">
                                <p class="ali mohammad">
                                    Jad Mcheik
                                </p>
                                <p class="number"><a href="http://wa.me/96181953723">81 - 953 723</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="final">
                        <p class="copyright">
                            &copy; 2025
                            <span>Tree Tech </span>
                            All Right Reserved
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script src="js/main.js"></script>
</body>

</html>