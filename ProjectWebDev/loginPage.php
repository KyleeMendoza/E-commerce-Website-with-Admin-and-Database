<?php

//need laging may gnto sa top ng bawat php pages para magamit yung $_session variable, na parang super global variable
session_start();

$host = "localhost";
$user = "root";
$password = "";
$db = "main_database"; //name of database create in PHPMYADMIN

$error = "";

if (isset($_POST["login_submit"])){ //if submit button is clicked

    $data = mysqli_connect($host, $user, $password, $db); //connect to the database

    if ($data === false){

        die("connection error"); //if connected unsuccessfully, throw error

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){ //if the "method" of the form is "POST"

        $username = $_POST["loginUsername"]; //create variable for the name of the input in that form
        $password = $_POST["loginPassword"];

        $sql = "select * from login where username = '".$username."' AND password = '".$password."' "; //checking if the data entered is existing in the database

        $result = mysqli_query($data, $sql); //getting the datas from the database

        if (mysqli_num_rows($result) > 0){ //check if data entered is existing

            $row = mysqli_fetch_array($result); //getting that row from the database

            if ($row["usertype"] == "user"){ //if matched and the usertype is "user"

                // $_SESSION["username"] = $username;
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["name"] = $row["name"];
                $_SESSION["address"] = $row["address"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["password"] = $row["password"];
                $_SESSION["email_address"] = $row["email_address"];
                $_SESSION["contact_number"] = $row["contact_number"];

                header("location:userHomePage.php"); //go to the logged in form of the website

            }
            elseif ($row["usertype"] == "admin"){ //if matched and the usertype is "admin"
                
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                header("location:adminHomePage.php"); //go to the admin page
                
            }
            else {
                $error = "Username or Password is incorrect !"; //if the datas doesnt match, throw warning
            }

        } else { //if data is not existing
            $error = "Username or Password is incorrect !"; //if the datas doesnt match, throw warning
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
    <title>Login Page</title>
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
            <div id="user-btn" onclick="showLoginForm_notLoggedIn()"><img src="Images/userIcon.png" alt="Logo" title="login"></div>
        </div>

    </div>



    <section class="login" id="login">

        <div class="create">

            <form class="orderForm" action="#" method="POST">

                <div class="flex">

                    <h1 class="heading" > Login <span>Account</span> </h1>

                    <?php 
                        echo "<p style='color:red; font-family: Lato, sans-serif; font-size: 14pt; display: inline-block; position: absolute; top: 370px;'>" . $error . "</p>";
                    ?>

                    <div class="inputBox">
                        <span>Username: </span>
                        <input type="text" placeholder="Full Name" name="loginUsername" id="loginUsername" required>
                    </div>
                    <div class="inputBox">
                        <span>Password: </span>
                        <input type="password" placeholder="Password" name="loginPassword" id="loginPassword" required>
                    </div>
                </div>

                <!-- <p>Forget your password <a href="registerpage.php">Click here</a></p> -->
                <p>Don't have an account ?<a href="registerpage.php">Create now</a></p>

                <div class="buttons">
                    <input type="submit" name="login_submit" value="Login" class="btn" id="LoginAccountButton">
                </div>
                    
            </form>

        </div>

    </section>
    
    <!-- js connection -->
    <script src="script.js"></script>
</body>
</html>