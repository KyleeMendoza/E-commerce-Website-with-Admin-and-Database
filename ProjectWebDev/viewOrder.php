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

    $username = $_SESSION["order_name"];
    //unset($_SESSION["order_name"]);

    $order_sql = "select * from user_orders where name='$username'"; 
    $order_result = mysqli_query($data, $order_sql);

    $Phistory_sql = "select * from purchase_history where name='$username'"; 
    $Phistory_result = mysqli_query($data, $Phistory_sql);

    $user_sql = "select * from login where name='$username'"; 
    $user_result = mysqli_query($data, $user_sql);

    while ($row = mysqli_fetch_assoc($user_result)){
        if ($row["name"] == $username){
            $_SESSION['name'] = $row["name"];
            $_SESSION['contact_number'] = $row["contact_number"];
            $_SESSION['address'] = $row["address"];
        }
    }


    if (isset($_POST["delete_order"])){

        $delete_sql = mysqli_query($data, "DELETE FROM user_orders WHERE name='$username'");
        $history_sql = mysqli_query($data, "UPDATE purchase_history SET status='Complete' WHERE name='$username'");

        if($delete_sql){
            echo "<script>alert ('Order Completed! ')</script>"; //print alert
            echo "<script>window.location = 'adminHomePage.php'</script>";
        }
        //print_r($_SESSION["order_name"]);
        unset($_SESSION["order_name"]);

    }

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>
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

    <section class="viewOrder" id="viewOrder">
        <h1 class="heading" > View <span>Order</span> </h1>

        <div class="details">
    
                <div class="subdetails">

                    <p>Name: <span id="checkoutName"><?php echo $_SESSION['name']; ?></span></p>
                    <p>Contact: <span id="checkoutContact"><?php echo $_SESSION['contact_number']; ?></span></p>
                    <p>Address: <span id="checkoutAddress"><?php echo $_SESSION['address']; ?></span></p>
                    <p>Date: <input type="text" placeholder="mm/dd/yyyy" name="OrderDate" id="OrderDate" readonly></p>

                </div> 
    
        </div>

        <div class="contents">

            <?php
            $number = 1;
            $total = 0;  
            ?>

            <form action="#" method="POST">

                <table class="table" id="table">

                    <tr>
                        <th>No.</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <!-- <th>Date</th> -->
                    </tr> 

                    <?php   
        
                        while ($array = mysqli_fetch_array($order_result)){
                    ?>  

                    <tr>  
                        <form action="#" method="post">
                            <td><?php echo $number++; ?></td>
                            <td><?php echo $array["product_name"]; ?></td>
                            <td><?php echo $array["product_quantity"]; ?></td>
                            <td>₱ <?php echo $array["product_price"]; ?></td>
                        
                        </form>
                        
                        
                    </tr>  

                    <?php  
                        $total = $total + $array["product_price"];    
                    }
                    //$_SESSION["latest_index"] = $number;
                    ?>

                    <tr >  

                        <td></td>
                        <td></td>
                        <td></td>
                        <td id="Grandtotal" colspan="3">
                            Total: <span>  ₱ <?php echo number_format($total, 2); ?></span>
                        </td>

                    </tr>  



                    <?php  
                    // }  
                    ?> 

                </table>
                <input type="submit" name="delete_order" id="delete_order" class="btn" value="Mark as Complete">

            </form>

        </div>
    </section>

    <!-- js connection -->
<script src="script.js"></script>

</body>
</html>