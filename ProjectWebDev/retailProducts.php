<?php

    session_start();
    
    //on all screens requiring login, redirect if NOT logged in
    if (!isset(($_SESSION['username']), ($_SESSION['password']), ($_SESSION["user_id"]), ($_SESSION["name"]), ($_SESSION["address"]), ($_SESSION["email_address"]), ($_SESSION["contact_number"]))) { 
        header('location:loginPage.php');
    }

    $_SESSION["userType"] = "retail"; //declare user type 

    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "main_database";

    $data = mysqli_connect($host, $user, $password, $db);

    $pampanga = "pampanga";
    $pampanga_sql = "select * from products_db where brand = '".$pampanga."' order by id asc";
    $pampanga_result = mysqli_query($data, $pampanga_sql);

    $cdo = "cdo";
    $cdo_sql = "select * from products_db where brand = '".$cdo."' order by id asc";
    $cdo_result = mysqli_query($data, $cdo_sql);

    $tender = "tender";
    $tender_sql = "select * from products_db where brand = '".$tender."' order by id asc";
    $tender_result = mysqli_query($data, $tender_sql);

    $mjb = "mjb";
    $mjb_sql = "select * from products_db where brand = '".$mjb."' order by id asc";
    $mjb_result = mysqli_query($data, $mjb_sql);




    //add to cart functionality starts
    if (isset($_POST['add_to_cart'])){      //when add to cart was clicked

       
        if (isset($_SESSION["cart"])){      //if cart session variable is already created means it has items in it

            $item_array_id = array_column($_SESSION["cart"], "product_id");         //reference the column in cart array
            //$item_array_name = array_column($_SESSION["cart"], "product_name");

            if (!in_array($_GET["id"], $item_array_id)){        //if GET [id] is not in that column, add that id to the cart

                $count = count($_SESSION['cart']);      //count number of items in cart
                $item_array = array (  

                    'product_img'               =>     $_POST["hidden_img"], 
                    'product_id'               =>     $_GET["id"],  
                    'product_name'               =>     $_POST["hidden_name"],  
                    'product_price'          =>     $_POST["hidden_price"],  
                    'product_quantity'          =>     $_POST["quantity"] 
                );

                $_SESSION["cart"][$count] = $item_array;

                // foreach($_SESSION["cart"] as $keys => $values) {
                //     echo $values["product_name"];
                // }


            } else {        //if GET [id] is in cart already, prompt alert

                echo "<script>alert ('Product is already added in the cart.')</script>"; //print alert
                echo "<script>window.location = 'retailProducts.php'</script>";

            }
            
        } else {        //if cart session variable is non existing, meaning una palang tong item

            $item_array = array (
                'product_img'               =>     $_POST["hidden_img"], 
                'product_id'               =>     $_GET["id"],  
                'product_name'               =>     $_POST["hidden_name"],  
                'product_price'          =>     $_POST["hidden_price"],  
                'product_quantity'          =>     $_POST["quantity"] 
            );

            
            $_SESSION["cart"][0] = $item_array;         //create cart session variable
            //print_r($_SESSION["cart"]);


            //$item_array_name = array_column($_SESSION["cart"], "product_name");
            // foreach($_SESSION["cart"] as $keys => $values) {
            //     echo $values["product_name"];
            // }
        }
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale Products</title>
    <link rel="stylesheet" href="styles.css">


</head>
<body>
    
    <div class="fullPageContainerRetailPage">
        
        <!-- navigation header starts here -->
        <div class="navigation">
            <a href="userHomePage.php#home" class="logo">
                <img src="Images/Logo.png" alt="Logo">
            </a>
            <ul class="mainLinks">
                <li><a href="userHomePage.php#home">Home</a></li>
                <li><a href="userHomePage.php#features">Features</a></li>
                <li><a href="userHomePage.php#products">Product</a></li>
                <li><a href="userHomePage.php#orders">Order</a></li>
                <li><a href="userHomePage.php#aboutus">About</a></li>
            </ul>

            <div class="icons">

                <div id="cart-btn" onclick="goToCart_LoggedIn()">
                    <img src="Images/cart.png" alt="Add To Card">
                    <i>
                        <?php
                            if (isset($_SESSION['cart'])){
                                $count = count($_SESSION['cart']);
                                echo "<span id='cart_count'>$count</span>";
                            } else {
                                echo "<span id='cart_count'>0</span>";
                            }
                        ?>
                    </i>
                </div>
                <div id="profile-btn">
                
                    <li>
                        <!-- <a href="#">Dropdown</a> -->
                        <img src="Images/userIcon.png" alt="Logo">
                        <ul>
                            <li><a href="userDashboardPage.php">Profile</a></li>
                            <li><a href="userPurchaseHistory.php">Purchase History</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                    
                </div>
                <span id="displayFirstName">
                    <?php echo $_SESSION['username']; ?>
                </span>
            </div>

        </div>
        <!-- navigation header ends here -->

        <!-- home section starts here -->
        <section class="home" id="home">

            <div class="content">
                <h3>Fresh And <span>Frozen</span> Products For You</h3>
                <p>Supplying Fresh and Frozen Products for both Retailers and Wholesalers. Pampanga`s Best * CDO * Purefoods * MJB</p>
                <a href="#" class="btn" name="products" id="products">Shop Now</a>
            </div>

        </section>
        <!-- home section ends here -->

        <!-- categories section starts  -->
        <section class="categories" id="categories">
            <div class="box-container">
                <h1 class="heading">Product <span>Categories</span> </h1>
                <div class="box">
                    <img src="Images/Cat-Pambest.jpg" alt="">
                    <h3>Pampanga's Best</h3>
                    <p>Upto 45% off</p>
                    <a href="#pampangapage" class="btn">View Products</a>
                </div>
                <div class="box">
                    <img src="Images//Cat-CDO.jpg" alt="">
                    <h3>CDO Products</h3>
                    <p>Upto 45% off</p>
                    <a href="#cdopage" class="btn">View Products</a>
                </div>
                <div class="box">
                    <img src="Images/Cat-Tender-Juicy.jpg" alt="">
                    <h3>Tender Juicy</h3>
                    <p>Upto 45% off</p>
                    <a href="#tenderpage" class="btn">View Products</a>
                </div>
                <div class="box">
                    <img src="Images/Cat-MJB.png" alt="" style="background-color: grey;">
                    <h3>MJB</h3>
                    <p>Upto 45% off</p>
                    <a href="#mjbpage" class="btn">View Products</a>
                </div>
            </div>
        </section>
        <!-- categories section ends -->

        <!-- pampanga section starts -->
        <section class="pampanga" >
            <div class="box-container" id = "pampangapage">
                <h1 class="heading"> <span>Pampanga's Best</span> Products</h1>

                <div class="scrolling-wrapper">

                    <?php  
                        if(mysqli_num_rows($pampanga_result) > 0)  
                        {  
                            while($pampanga_row = mysqli_fetch_array($pampanga_result))  
                            {  
                        ?>  
                        
                            <form method="post" action="retailProducts.php?action=add&id=<?php echo $pampanga_row["id"]; ?>">  

                                <?php if ($pampanga_row["stock"] != 0){ ?>

                                    <div class="box">
                                        <img src="<?php echo $pampanga_row["image"]; ?>" alt="">
                                        <h3><?php echo $pampanga_row["name"]; ?></h3>
                                        <p>250g for ₱<?php echo $pampanga_row["price"]; ?></p>
                                        <input type="hidden" name="hidden_name" value="<?php echo $pampanga_row["name"]; ?>">
                                        <input type="hidden" name="hidden_price" value="<?php echo $pampanga_row["price"]; ?>">
                                        <input type="hidden" name="hidden_img" value="<?php echo $pampanga_row["image"]; ?>">
                                        <input type="text" name = "quantity" class= "quantity_input" value = "1"><br>
                                        <input type="submit" name = "add_to_cart" class= "btn" value = "Add to Cart">
                                        <!-- <a href="#orders" class="btn">Add to Cart</a> -->
                                    </div>

                                <?php
                                } else continue;
                                ?>

                            </form>  
                        
                        <?php  
                            }  
                        }  
                    ?>  
                    

                </div>

                
            </div>
        </section>
        <!-- pampanga section ends -->

        <!-- cdoprpducts section starts -->
        <section class="cdoproducts" >
            <div class="box-container" id = "cdopage">
                <h1 class="heading"><span>CDO</span> Products</h1>

                <div class="scrolling-wrapper">
                    
                    <?php  
                        if(mysqli_num_rows($cdo_result) > 0)  
                        {  
                            while($cdo_row = mysqli_fetch_array($cdo_result))  
                            {  
                        ?>  
                        
                            <form method="post" action="retailProducts.php?action=add&id=<?php echo $cdo_row["id"]; ?>">  

                                <?php if ($cdo_row["stock"] != 0){ ?>

                                    <div class="box">
                                        <img src="<?php echo $cdo_row["image"]; ?>" alt="">
                                        <h3><?php echo $cdo_row["name"]; ?></h3>
                                        <p>250g for ₱<?php echo $cdo_row["price"]; ?></p>
                                        <input type="hidden" name="hidden_name" value="<?php echo $cdo_row["name"]; ?>">
                                        <input type="hidden" name="hidden_price" value="<?php echo $cdo_row["price"]; ?>">
                                        <input type="hidden" name="hidden_img" value="<?php echo $cdo_row["image"]; ?>">
                                        <input type="text" name = "quantity" class= "quantity_input" value = "1"><br>
                                        <input type="submit" name = "add_to_cart" class= "btn" value = "Add to Cart">
                                        <!-- <a href="#orders" class="btn">Add to Cart</a> -->

                                    </div>

                                <?php
                                } else continue;
                                ?>

                            </form>  
                        
                        <?php  
                            }  
                        }  
                    ?>  

                </div>

                
            </div>
        </section>
        <!-- cdoproducts section ends -->

        <!-- tenderproducts section starts -->
        <section class="tenderproducts" >
            <div class="box-container" id = "tenderpage">
                <h1 class="heading"> <span>Tender Juicy</span> Products</h1>

                <div class="scrolling-wrapper">

                    <?php  
                        if(mysqli_num_rows($tender_result) > 0)  
                        {  
                            while($tender_row = mysqli_fetch_array($tender_result))  
                            {  
                        ?>  
                        
                            <form method="post" action="retailProducts.php?action=add&id=<?php echo $tender_row["id"]; ?>">  

                                <?php if ($tender_row["stock"] != 0){ ?>

                                    <div class="box">
                                        <img src="<?php echo $tender_row["image"]; ?>" alt="">
                                        <h3><?php echo $tender_row["name"]; ?></h3>
                                        <p>250g for ₱<?php echo $tender_row["price"]; ?></p>
                                        <input type="hidden" name="hidden_name" value="<?php echo $tender_row["name"]; ?>">
                                        <input type="hidden" name="hidden_price" value="<?php echo $tender_row["price"]; ?>">
                                        <input type="hidden" name="hidden_img" value="<?php echo $tender_row["image"]; ?>">
                                        <input type="text" name = "quantity" class= "quantity_input" value = "1"><br>
                                        <input type="submit" name = "add_to_cart" class= "btn" value = "Add to Cart">
                                        <!-- <a href="#orders" class="btn">Add to Cart</a> -->
                                    </div>

                                <?php
                                } else continue;
                                ?>

                            </form>  
                        
                        <?php  
                            }  
                        }  
                    ?>  

                </div>

                
            </div>
        </section>
        <!-- tenderproducts section ends -->

        <!-- mjbproducts section starts -->
        <section class="mjbproducts" >
            <div class="box-container" id = "mjbpage">
                <h1 class="heading"> <span>MJB</span> Products</h1>

                <div class="scrolling-wrapper">
                            
                    <?php  
                        if(mysqli_num_rows($mjb_result) > 0)  
                        {  
                            while($mjb_row = mysqli_fetch_array($mjb_result))  
                            {  
                        ?>  
                        
                            <form method="post" action="retailProducts.php?action=add&id=<?php echo $mjb_row["id"]; ?>">  

                                <?php if ($mjb_row["stock"] != 0){ ?>

                                    <div class="box">
                                        <img src="<?php echo $mjb_row["image"]; ?>" alt="">
                                        <h3><?php echo $mjb_row["name"]; ?></h3>
                                        <p>250g for ₱<?php echo $mjb_row["price"]; ?></p>
                                        <input type="hidden" name="hidden_name" value="<?php echo $mjb_row["name"]; ?>">
                                        <input type="hidden" name="hidden_price" value="<?php echo $mjb_row["price"]; ?>">
                                        <input type="hidden" name="hidden_img" value="<?php echo $mjb_row["image"]; ?>">
                                        <input type="text" name = "quantity" class= "quantity_input" value = "1"><br>
                                        <input type="submit" name = "add_to_cart" class= "btn" value = "Add to Cart">
                                        <!-- <a href="#orders" class="btn">Add to Cart</a> -->
                                    </div>

                                <?php
                                } else continue;
                                ?>

                            </form>  
                        
                        <?php  
                            }  
                        }  
                    ?>     

                </div>
                
            </div>
        </section>
        <!-- tenderproducts section ends -->
        <a href="#" id="GoToCart" class="GoToCart-btn">Go to Cart</a>
    </div>

    <!-- include the separate table-->
    <!-- <?php
    //include('cartTable.php');
    ?> -->

    <!-- js connection -->
    <script src="script.js"></script>
    <script>
        
        //pag naclick yung go to cart, ito yung onclick non in js form
        document.getElementById("GoToCart").onclick = function () {
        location.href = "checkoutpage.php";
        
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
        

    };

    </script>
</body>
</html>