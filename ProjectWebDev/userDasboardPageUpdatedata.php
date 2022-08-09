<?php
    session_start();

    // on all screens requiring login, redirect if NOT logged in dagdag ko dito yung ibang variable para magamit sa input sa baba
    if (!isset(($_SESSION['username']), ($_SESSION['password']), ($_SESSION["user_id"]), ($_SESSION["name"]), ($_SESSION["address"]), ($_SESSION["email_address"]), ($_SESSION["contact_number"]))) { 
        header('location:loginPage.php');
    }

    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "main_database"; //name of database create in PHPMYADMIN
    $data = mysqli_connect($host, $user, $password, $db); //connect to the database

    if(isset($_POST['Updatedata'])){
        $userid = $_SESSION["user_id"];
        $new_name = $_POST["NewRegisterName"];
        $new_address = $_POST["NewRegisterAddress"];
        $new_password = $_POST["NewRegisterPassword"];
        $new_email_address = $_POST["NewRegisterEmail"];
        $new_contact_number = $_POST["NewRegisterContact"];
        $new_username = $_POST["NewRegisterUserName"];
        

        $sql = mysqli_query($data, "UPDATE login SET name='$new_name', address='$new_address',
        username='$new_username', password='$new_password', email_address='$new_email_address', 
        contact_number='$new_contact_number' WHERE user_id='$userid'");

        $ph_sql = mysqli_query($data, "UPDATE purchase_history SET name='$new_name' WHERE user_id='$userid'");
        
        if($sql){
            echo "<script>alert ('You have successfully update your record! Please login again.')</script>";
            echo "<script>document.location='loginPage.php';</script>";
        }
    }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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

    <section class="profilePage" id="profilePage">
        <h1 class="heading" > My <span>Profile</span> </h1>
        <div class="contents">

            <div class="box1">
                <img src="Images/userIcon.png" alt="">
            </div>

            <div class="box2">
                <form  method="post" action="">
                    <div class="inputBox">
                        <span>Name: </span>
                        <input type="text" name="NewRegisterName" id="RegisterName" value='' required>
                    </div>
                    <div class="inputBox">
                        <span>Address: </span>
                        <input type="text" name="NewRegisterAddress" id="RegisterAddress" value="" required>
                    </div>
                    <div class="inputBox">
                        <span>UserName: </span>
                        <input type="text" name="NewRegisterUserName" id="RegisterUserName" value="" required>
                    </div>
                    <div class="inputBox">
                        <span>Password: </span>
                        <input type="password" name="NewRegisterPassword" id="RegisterPassword" value="" required>
                    </div>
                    <div class="inputBox">
                        <span>Email Address: </span>
                        <input type="email" name="NewRegisterEmail" id="RegisterEmail" value="" required>
                    </div>
                    <div class="inputBox">
                        <span>Contact Number: </span>
                        <input type="number" name="NewRegisterContact" id="RegisterContact" value="" required>
                    </div>
                    <div class="buttons">
                        <input type="submit" name="Updatedata" value="Update" class="btn" id="updateProfile">
                    </div>
                </form>
            </div>

        </div>
        
    </section>




    <!-- js connection -->
    <script src="script.js"></script>
</body>
</html>