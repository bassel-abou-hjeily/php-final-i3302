<?php
include("connect.php");
session_start();
if(!isset($_GET["categorie"])){
    header("Location: home.php");
    exit;
}
$now = date('Y-m-d H:i:s');
$ss = "SELECT * FROM account where role = 'admin' ;";
$query = mysqli_query($conn, $ss);
$r_profile = mysqli_fetch_array($query);

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Items</title>
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/show_items.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/normalize.css">


    <script>
        window.onload = function() {
            document.querySelector(".InnerContainer").className = "InnerContainer slideUp";
            document.querySelector(".InnerContainer").style.visibility = "visible";
        };
    </script>


</head>

<body>
    
    <form action="search.php" class="form2">
        <input type="submit" value="Search" class="search"> 
    </form>

    <?php
    if (isset($_GET["categorie"])) {
        $res = "SELECT  i.Name as itemName, i.role , c.Name as categoryName , i.* , c.*
         FROM items i,categories c
         WHERE i.Cat_ID=" . $_GET["categorie"] . " AND i.Cat_ID=c.id  And i.role = 1 
         ORDER BY i.discount_percentage DESC, Add_Date DESC";
        $r_res = mysqli_query($conn, $res);

        $cat = "SELECT  c.Id, c.Name 
         FROM categories c 
         WHERE Id=" . $_GET["categorie"];
        $r_cat = mysqli_query($conn, $res);
        $category = mysqli_fetch_array($r_cat);

        $_SESSION["cat_id"] =  $category["Id"];                  
        
    }
    ?>
    
    <a href=<?php echo 'home.php#' . $category['Name'] ?> style="top:50px;left:50px;position:sticky">
         <span class="link icon"><i class="fa-solid fa-arrow-left"></i></span> </a>
    <div class="outerContainer">
        <form class="form" action="./details_card.php" method="get">
            <h3 class="title" id="accessories"><span><?php echo $category['Name'][0] ?></span><?php $categoryNameWithoutFirstLetter = substr($category['Name'], 1);
                                                                                                echo $categoryNameWithoutFirstLetter; ?></h3>

            <div class="InnerContainer ">
                <?php while ($result = mysqli_fetch_array($r_res)) { ?>
                    <a href="details_card.php?ID=<?php echo $result['Item_ID'] ?>&source=show_items">
                        <div class="card" id=<?php echo $result['Item_ID'] ?>>

                            <Div class="product-card">
                                <img src="images/<?php echo $result['categoryName'] ?>/<?php echo $result['Picture'] ?>" alt="Product" class="product-card__image" />
                                <figcaption class="product-card__caption">
                                    <header class="product-card__header">
                                        <h2 class="product-card__title"><?php echo $result['itemName'] ?></h2>
                                        <p class="product-card__subtitle"><?php echo $result['Description'] ?></p>
                                    </header>
                                    <footer class="product-card__footer">
                                        <?php


                                        if ($result['discount_percentage'] > 0 && $result['discount_end_date'] > $now) {
                                            echo '<div class="on-sale-badge"> SALE &nbsp;' . $result['discount_percentage'] . '%</div>';
                                            echo  " <span style='color:Black;' >  &nbsp;</span><span style='color:green;'> $" . $result['Price_after_discount'] . " &nbsp; </span>  <span style='color:Black;' > &nbsp;</span> <span style='color:gray;text-decoration: line-through;'>$" . $result['Price'] . "</span>";
                                        } else if ($result['discount_percentage'] > 0 && $result['discount_end_date'] < $now) {

                                            $update = "update items set discount_percentage=0 where Item_ID=" . $result['Item_ID'];
                                            mysqli_query($conn, $update);
                                            $result['discount_percentage'] = 0;


                                            $discounted_price = $result['Price'] - ($result['Price'] * ($result['discount_percentage'] / 100));



                                            echo  " <span class='product-card__price'> $" . number_format($discounted_price, 2) . " </span>";
                                        } else {
                                            echo  " <span class='product-card__price'> $" . $result['Price'] . " </span>";
                                        }

                                        ?>

                                    </footer>

                                </figcaption>
                            </Div>
                        </div>
                    </a>
                <?php } ?>


            </div>



        </form>
    </div>

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
                        <p>
                            Mohammad Diab
                        </p>
                        <p class="number"><a href="http://wa.me/96171184211">71 - 184 211</a></p>
                    </div>
                    <div class="author">
                        <p>
                            Mohammad Saleh
                        </p>
                        <p class="number"><a href="http://wa.me/96103079306">03 - 079 306</a></p>
                    </div>
                    <div class="author">
                        <p>
                            Bassel Abou Hjeily
                        </p>
                        <p class="number"><a href="http://wa.me/96171493637">71 - 493 637</a></p>
                    </div>
                    <div class="author">
                        <p>
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
    <script>
        var x = '<?php echo ($nb = $r_profile["Phone_Nb"]); ?>'
        x = x.split("");
        x = x[0] + x[1] + " - " + x[2] + x[3] + x[4] + " " + x[5] + x[6] + x[7];
        document.getElementById("ph_nb").innerHTML = x;
    </script>

</body>


</html>