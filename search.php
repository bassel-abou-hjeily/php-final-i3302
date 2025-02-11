<?php
session_start();
include("connect.php");
if (!isset($_SESSION["cat_id"])) {
    header("Location: home.php");
    exit;
}
$now = date('Y-m-d H:i:s');
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/search_css.css">
</head>
<body>

<h1>Search</h1>
<a href=<?php echo 'show_items.php' .'?categorie=' . $_SESSION["cat_id"] ?> style="position:absolute;  top:40px; left:40px;" >
         <span class="link icon"><i class="fa-solid fa-arrow-left"></i></span> </a>

<form name="frm" method="post" class="form1">

    <input  type="text" name="find" id="find" value="<?php if(isset($_POST['find'])) echo $_POST['find'];?>"  onchange="submit()">
    <input type="submit" name="sub" value="search">

</form>


</body>
</html>
<?php


if(isset($_POST['find']) ) {
    $text=$_POST['find'];
    $sql="SELECT  items.Item_Id as itemID, items.Name as itemName, items.Description, items.role,
    items.Price, items.Price_after_discount, items.Add_Date, items.Picture, items.Discount_Percentage,
     items.status, items.discount_end_date,
    categories.id, categories.Name as category_name, items.Add_Date
    from items ,categories
    where items.Name LIKE '%$text%'
    and   items.Cat_ID=categories.Id
    And   items.role = 1
    and   categories.Id=".$_SESSION["cat_id"]  . " ORDER BY Discount_Percentage DESC, Add_Date DESC"  ;

    $r_res=mysqli_query($conn,$sql);

    $cat = "SELECT  c.Id, c.Name  FROM categories c WHERE Id=" .$_SESSION["cat_id"];
    $r_cat = mysqli_query($conn, $cat);
    $category = mysqli_fetch_array($r_cat);

    $_SESSION["cat_id"] =  $category["Id"]; 

    if(mysqli_num_rows($r_res)>0){ 
?>
<div class="outerContainer">
        <form class="form" action="./details_card.php" method="get">


            <div class="InnerContainer ">
                <?php while ($result = mysqli_fetch_array($r_res)) { ?>
                    <a href="details_card.php?ID=<?php echo $result['itemID'] ?>&source=search">
                        <div class="card" id=<?php echo $result['itemID'] ?>>

                            <Div class="product-card">
                                <img src="images/<?php echo $result['category_name'] ?>/<?php echo $result['Picture'] ?>" alt="Product" class="product-card__image" />
                                <figcaption class="product-card__caption">
                                    <header class="product-card__header">
                                        <h2 class="product-card__title"><?php echo $result['itemName'] ?></h2>
                                        <p class="product-card__subtitle"><?php echo $result['Description'] ?></p>
                                    </header>
                                    <footer class="product-card__footer">
                                        <?php


                                        if ($result['Discount_Percentage'] > 0 && $result['discount_end_date'] > $now) {
                                            echo '<div class="on-sale-badge"> SALE &nbsp;' . $result['Discount_Percentage'] . '%</div>';
                                            echo  " <span style='color:Black;' >  &nbsp;</span><span style='color:green;'> $" . $result['Price_after_discount'] . " &nbsp; </span>  <span style='color:Black;' > &nbsp;</span> <span style='color:gray;text-decoration: line-through;'>$" . $result['Price'] . "</span>";
                                        } else if ($result['Discount_Percentage'] > 0 && $result['discount_end_date'] < $now) {

                                            $update = "update items set discount_percentage=0 where Item_ID=" . $result['Item_ID'];
                                            mysqli_query($conn, $update);
                                            $result['Discount_Percentage'] = 0;


                                            $discounted_price = $result['Price'] - ($result['Price'] * ($result['Discount_Percentage'] / 100));



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

    
    
   <?php }
    
    
    else{
        echo "no result found!";
    }}
    
?>

