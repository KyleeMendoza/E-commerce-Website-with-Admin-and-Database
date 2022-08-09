<?php
    session_start();

    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "main_database"; //name of database create in PHPMYADMIN

    $data = mysqli_connect($host, $user, $password, $db); //connect to the database
    
    if ($data === false){

        die("connection error"); //if connected unsuccessfully, throw error

    }

    //function for user_id random number generator
    function random_num ($length) {

        $text = "";
        if ($length < 5){
            $length = 5;
        }
        $len = rand(4, $length);

        for ($i=0; $i < $len; $i++){
            $text .= rand(0,9);
        }
        return $text;
    }

    if (isset($_POST["register_submit"])){ //if submit button is clicked
    
        if ($_SERVER["REQUEST_METHOD"] == "POST"){ //if the "method" of the form is "POST"

            if ($_POST["RegisterName"] != null && $_POST["RegisterAddress"] != null && $_POST["RegisterUserName"] != null && $_POST["RegisterPassword"] != null && $_POST["RegisterEmail"] != null && $_POST["RegisterContact"] != null){
                
                //create variable for the name of the input in that form
                $user_id = random_num(20);

                $name = $_POST["RegisterName"]; 
                $address = $_POST["RegisterAddress"];
                $username = $_POST["RegisterUserName"]; 
                $password = $_POST["RegisterPassword"];
                $email = $_POST["RegisterEmail"]; 
                $contact_number = $_POST["RegisterContact"];

                $check = "select * from login where username = '$username'";
                $rs = mysqli_query($data,$check);
                // $data = mysqli_fetch_array($rs, MYSQLI_NUM);

                if(mysqli_num_rows($rs) > 0) {

                    echo "<script>alert ('User Already in Exists.')</script>";
                    echo "<script>window.location = 'loginPage.php'</script>";

                } else {
                    
                    //save to database
                    $query = "insert into login (user_id,name,address,username,password,email_address,contact_number) values ('$user_id','$name','$address','$username','$password','$email','$contact_number')";
                    mysqli_query($data, $query);

                    echo "<script>alert ('User Created!')</script>";
                    echo "<script>window.location = 'loginPage.php'</script>";

                    //redirect to login after creation
                    // header("Location: loginPage.php");
                    die;
                }

            } else {
                echo "<script>alert ('Please Fill in all inputs')</script>";
                echo "<script>window.location = 'registerpage.php'</script>";
            }
    
        }
    }
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
	<body>

        <div class="navigation">
            
            <a href="#" class="logo">
                <img src="Images/Logo.png" alt="Logo">
            </a>

            <ul class="mainLinks">
                <li><a href="index.php#home">Home</a></li>
                <li><a href="index.php#features">Features</a></li>
                <li><a href="index.php#products">Product</a></li>
                <li><a href="index.php#orders">Order</a></li>
                <li><a href="index.php#aboutus">About</a></li>
            </ul>

            <div class="icons">
                <div id="cart-btn" onclick="goToCart_notLoggedIn()">
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
                <!-- <div id="cart-btn" onclick="goToCart_notLoggedIn()"><img src="Images/cart.png" alt="Add To Card" title="Go to cart"></div> -->
                <div id="user-btn" onclick="showLoginForm_notLoggedIn()"><img src="Images/userIcon.png" alt="Logo" title="login"></div>
            </div>

        </div>



        <section class="registration" id="registration">

            <div class="create">

                <form class="orderForm" action="#" method="POST">

                    <div class="flex">

                        <h1 class="heading" > Create <span>Account</span> </h1>
                        <div class="inputBox">
                            <span>Name: </span>
                            <input type="text" placeholder="Full Name" name="RegisterName" id="RegisterName" required>
                        </div>
                        <div class="inputBox">
                            <span>Address: </span>
                            <input type="text" placeholder="Full Address" name="RegisterAddress" id="RegisterAddress" required>
                        </div>
                        <div class="inputBox">
                            <span>Username: </span>
                            <input type="text" placeholder="Username" name="RegisterUserName" id="RegisterUserName" required>
                        </div>
                        <div class="inputBox">
                            <span>Password: </span>
                            <input type="password" placeholder="Password" name="RegisterPassword" id="RegisterPassword" required>
                        </div>
                        <div class="inputBox">
                            <span>Email Address: </span>
                            <input type="email" placeholder="Email Address" name="RegisterEmail" id="RegisterEmail" required>
                        </div>
                        <div class="inputBox">
                            <span>Contact Number: </span>
                            <input type="number" placeholder="Contact Number" name="RegisterContact" id="RegisterContact" required>
                        </div>
                    </div>

                    <div class="buttons">
                        <input type="submit" name="register_submit" value="Create" class="btn" id="RegisterAccountButton">
                    </div>
                        
                </form>

                

            </div>
        
        </section>

        <!-- js connection -->
        <script src="script.js"></script>
        
    </body>
</html>