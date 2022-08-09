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

    $history_sql = "select * from purchase_history"; 
    $history_result = mysqli_query($data, $history_sql);


    if (isset($_POST["delete_order"])){

        $invoice = $_POST["hidden_invoice"];

        $delete_sql = mysqli_query($data, "DELETE FROM purchase_history WHERE invoice='$invoice'");

        if($delete_sql){
            echo "<script>alert ('Purchase history has been Deleted! ')</script>"; //print alert
            echo "<script>window.location = 'viewOrderHistory.php'</script>";
        }
        //print_r($_POST["hidden_invoice"]);
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
        <h1 class="heading"> Purchase <span>History</span> </h1>

        <div class="contents" style="top: 200px;">

            <?php
            $number = 1;
            ?>

            <form action="#" method="POST">

                <table class="table" id="table">

                    <tr>
                        <th>Order No.</th>
                        <th>Date</th>
                        <th>Bill-to name</th>
                        <th>Total Price</th>
                        <th>Invoice Number</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr> 

                    <?php   
        
                        while ($array = mysqli_fetch_array($history_result)){
                    ?>  

                    <tr>  
                        <form action="#" method="post">
                            <td><?php echo $number++; ?></td>
                            <td><?php echo $array["date"]; ?></td>
                            <td><?php echo $array["name"]; ?></td>
                            <td>₱ <?php echo $array["total"]; ?></td>
                            <td><?php echo $array["invoice"]; ?></td>
                            <input type="hidden" name="hidden_invoice" value="<?php echo $array["invoice"]; ?>">
                            <td><?php echo $array["status"]; ?></td>
                            <td><input type="submit" class="btn delete" name="delete_order" value = "Delete" style="width: 120px; height: 50px; padding: 0px; font-size: 16pt;"></input></td>
                        </form>
                        
                    </tr>  

                    <?php   
                    }
                    ?>

                </table>
                <!-- <input type="submit" name="delete_order" id="delete_order" class="btn" value="Mark as Complete"> -->

            </form>

        </div>
    </section>

</body>
</html>