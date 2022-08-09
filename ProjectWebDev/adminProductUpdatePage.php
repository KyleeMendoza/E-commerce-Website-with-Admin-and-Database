<?php

    session_start();

    // on all screens requiring login, redirect if NOT logged in
    if (!isset(($_SESSION['username']), ($_SESSION['password']))) { 
        header('location:loginPage.php');
    }

    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "main_database";

    $data = mysqli_connect($host, $user, $password, $db);

    if ($data === false){

        die("connection error"); //if connected unsuccessfully, throw error

    }

    $retailer_sql = "select name, brand, image, stock, price from products_db"; 
    $supplier_sql = "select stock, price from sproducts_db"; //

    $retailer_result = mysqli_query($data, $retailer_sql);
    $supplier_result = mysqli_query($data, $supplier_sql);


    //array para sa price ng supplier
    $price_array = array();
    $stock_array = array();
    while($row = mysqli_fetch_assoc($supplier_result))
    {
        $price_array[] = $row["price"];
        $stock_array[] = $row["stock"];
    }
    //print_r($price_array);
    //print_r($stock_array);

    if (isset($_POST['update'])){
        //ito yung hidden
        $Rprice_ref = $_POST["rprice"];
        $RStock_ref = $_POST["rStock"];
        $Sprice_ref = $_POST["sprice"];
        $SStock_ref = $_POST["sStock"];

        $name_ref = $_POST["product_name"];

        //ito yung new inputs na binago ng user
        $newRprice = $_POST["retailPrice"];
        $newRstock = $_POST["retailStock"];

        $newSprice = $_POST["supplyPrice"];
        $newSstock = $_POST["supplyStock"];
    

        if ($Rprice_ref != $newRprice || $Sprice_ref != $newSprice || $RStock_ref != $newRstock || $SStock_ref != $newSstock){

            $supply_sql = mysqli_query($data, "UPDATE sproducts_db SET price='$newSprice', stock='$newSstock' WHERE name='$name_ref'");
            $retail_sql = mysqli_query($data, "UPDATE products_db SET price='$newRprice', stock='$newRstock' WHERE name='$name_ref'");

            if($supply_sql || $retail_sql){
                echo "<script>alert ('Product has been updated!')</script>";
                echo "<script>document.location='adminProductUpdatePage.php';</script>";
            }
            // print_r($_POST["retailPrice"]);
            // print_r($_POST["supplyPrice"]);
            // print_r($name_ref);
            // print_r($Rprice_ref);
            // print_r($Sprice_ref);

            // print_r($newSstock);
            // print_r($name_ref);
            // print_r($SStock_ref);

        } else {
            echo "<script>alert ('Make changes to update')</script>";
            echo "<script>document.location='adminProductUpdatePage.php';</script>";
        }

    }

    if (isset($_POST['delete'])){
        $name_ref = $_POST["product_name"];
        //$index_ref = $_POST["index"];

        //print_r($index_ref);

        $supply_sql = mysqli_query($data, "DELETE FROM sproducts_db WHERE name='$name_ref'");
        $retail_sql = mysqli_query($data, "DELETE FROM products_db WHERE name='$name_ref'");

        if($supply_sql || $retail_sql){
            echo "<script>alert ('Product has been deleted!')</script>";
            echo "<script>document.location='adminProductUpdatePage.php';</script>";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Products</title>
    <link rel="stylesheet" href="adminCSS.css">
</head>
<body>

    <div class="sidebar">
        <div class="adminLogo">
            <img src="Images/Logo.png" alt="">
        </div>
        <hr class="solid" style="border-top: 3px solid #bbb;">
        <a href="adminHomePage.php">Home</a>
        <a href="adminProductUpdatePage.php">Products</a>
        <a href="viewUserList.php">Manage Accounts</a>
        <a href="viewOrderHistory.php">Manage Order History</a>
        <!-- <a href="#">Orders</a>
        <a href="#">Customers</a>
        <a href="#">Sellers</a>
        <a href="#">Statistics</a>
        <a href="#">Promotions</a> -->
        <a href="logout.php" id="logout-btn" class="btn"  style="margin-top: 550px">Log Out</a>
    </div>
      
    <div class="navigation">
        <!-- <div class="searchBar">
            <div class="icon">
                <img src="Images/search.png" alt="">
            </div>
            <div class="search">
               <input type="text" class="searchTerm" placeholder="Search">
            </div>
        </div> -->
        <p>Admin Page</p>
        <div class="userIcon">
            <img src="Images/admin-icon.png" alt="">
            <i>
                <?php
                    $counter = $_SESSION["pending"];
                    echo "<span id='cart_count'>$counter</span>";
                ?>
            </i>
            <span id="adminName">Admin</span>
        </div>
    </div>

    
    <section class="productUpdate" id="productUpdate">
        <h1 class="heading" > Update <span>Products</span> </h1>
        <a href="adminProductCreatePage.php" class="btn">+Add Product</a>
        <div class="contents">

            

            <table class="table" id="table">

                <tr>
                    <th>No.</th>
                    <th>Product Brand</th>
                    <th>Product name</th>
                    <th>Retail Stock</th>
                    <th>Retail Price</th>
                    <th>Supplier Stock</th>
                    <th>Supplier Price</th>
                    <th>Action</th>
                    <!-- <th>Date</th> -->
                </tr> 

                <?php   
                    //$number = 1; //manual indexing
                    $_SESSION["number"] = 1;
                    $index = 0;
    
                    while ($array = mysqli_fetch_array($retailer_result)){
                ?>  

                <tr>  
                    <form action="#" method="post">

                        <td><?php echo  $_SESSION["number"]++; ?></td>
                        <input type="hidden" name="index" value="<?php echo  $_SESSION["number"] - 1; ?>">
                        <td><?php echo $array["brand"]; ?></td>

                        <td><?php echo $array["name"]; ?></td>
                        <input type="hidden" name="product_name" value="<?php echo $array["name"]; ?>">

                        <td><input type="text" name="retailStock" value="<?php echo $array["stock"]; ?>"></td>

                        <td>₱<input type="text" name="retailPrice" value="<?php echo $array["price"]; ?>"></td>

                        <td><input type="text" name="supplyStock" value="<?php echo number_format($stock_array[$index]); $index++; ?>"></td>

                        <td>₱<input type="text" name="supplyPrice"  value="<?php echo number_format($price_array[$index - 1], 2);?>"></td>

                        <input type="hidden" name="rprice" value="<?php echo $array["price"]; ?>">
                        <input type="hidden" name="sprice" value="<?php echo number_format($price_array[$index - 1], 2);?>">
                        <input type="hidden" name="rStock" value="<?php echo $array["stock"]; ?>">
                        <input type="hidden" name="sStock" value="<?php echo number_format($stock_array[$index - 1]);?>">

                        <td>
                            <input type="submit" class="btn" name="update" value = "Update" style="width: 120px; height: 50px; padding: 0px; font-size: 16pt;"></input>
                            <input type="submit" class="btn delete" name="delete" value = "Delete" style="width: 120px; height: 50px; padding: 0px; font-size: 16pt;"></input>
                        </td>
                    
                    </form>
                    
                    
                </tr>  

                <?php     
                }
                //$_SESSION["latest_index"] = $number;
                ?>

                <?php  
                // }  
                ?> 

            </table>

           

        </div>




    </section>




    <!-- js connection -->
    <script src="script.js"></script>
</body>
</html>