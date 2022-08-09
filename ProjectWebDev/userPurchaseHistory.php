<?php
    session_start();

    // on all screens requiring login, redirect if NOT logged in
    if (!isset(($_SESSION['username']), ($_SESSION['password']), ($_SESSION["user_id"]), ($_SESSION["name"]), ($_SESSION["address"]), ($_SESSION["email_address"]), ($_SESSION["contact_number"]))) { 
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

    $sql = "select * from purchase_history"; 
    $result = mysqli_query($data, $sql);



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Purchase History</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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

    <section class="purchaseHistory" id="purchaseHistory">
        <h1 class="heading" > Purchase <span>History</span> </h1>
        <div class="contents">

            <table class="table">
                <tr>
                    <th>Order No.</th>
                    <th>Date</th>
                    <th>Bill-to name</th>
                    <th>Total Price</th>
                    <th>Invoice Number</th>
                    <th>Status</th>
                    <!-- <th>Date</th> -->
                </tr> 

                <?php   
                    $number = 1; //manual indexing
    
                    while ($array = mysqli_fetch_array($result)){

                    if ($array["user_id"] == $_SESSION["user_id"]){ //get lang yung nakapangalan sa account
        
                ?>  

                <tr>  

                    <td><?php echo $number++; ?></td>  
                    <td><?php echo $array["date"]; ?></td>  
                    <td><?php echo $_SESSION["name"]; ?></td>  
                    <td>₱ <?php echo $array["total"]; ?></td>  
                    <td><?php echo $array["invoice"]; ?></td>
                    <td><?php echo $array["status"]; ?></td>

                </tr>  

                <?php  
                    } 
                    }  
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