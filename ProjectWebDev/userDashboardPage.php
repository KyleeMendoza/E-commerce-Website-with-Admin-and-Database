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

    // if ($_SERVER["REQUEST_METHOD"] == "POST"){ //if the "method" of the form is "POST"

    //     // $username = $_POST["loginUsername"]; //create variable for the name of the input in that form
    //     // $password = $_POST["loginPassword"];
    
    
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
    
                <div class="inputBox">
                    <span>Name: </span>
                    <input type="text" name="RegisterName" id="RegisterName" value='<?php echo $_SESSION['name'] ?>' readonly="readonly">
                </div>
                <div class="inputBox">
                    <span>Address: </span>
                    <input type="text" name="RegisterAddress" id="RegisterAddress" value="<?php echo $_SESSION['address']; ?>" readonly="readonly">
                </div>
                <div class="inputBox">
                    <span>User Name: </span>
                    <input type="text" name="RegisterUserName" id="RegisterUserName" value="<?php echo $_SESSION['username']; ?>" readonly="readonly">
                </div>
                <div class="inputBox">
                    <span>Password: </span>
                    <input type="password" name="RegisterPassword" id="RegisterPassword" value="<?php echo $_SESSION['password']; ?>" readonly="readonly">
                </div>
                <div class="inputBox">
                    <span>Email Address: </span>
                    <input type="email" name="RegisterEmail" id="RegisterEmail" value="<?php echo $_SESSION['email_address']; ?>" readonly="readonly">
                </div>
                <div class="inputBox">
                    <span>Contact Number: </span>
                    <input type="number" name="=RegisterContact" id="RegisterContact" value="<?php echo $_SESSION['contact_number']; ?>" readonly="readonly">
                </div>
                
                <form method="POST" action="userDasboardPageUpdatedata.php">
                    <div class="buttons">
                        <input type="submit" name="update" value="Update" class="btn" id="updateProfile">
                    </div>
                </form>
    
            </div>

        </div>
        
    </section>




    <!-- js connection -->
    <script src="script.js"></script>
</body>
</html>