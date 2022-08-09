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

    $users_sql = "select * from login"; 
    $users_result = mysqli_query($data, $users_sql);









    if (isset($_POST["delete"])){
        $name = $_POST["hidden_name"];

        $delete_sql = mysqli_query($data, "DELETE FROM login WHERE name='$name'");

        if($delete_sql){
            echo "<script>alert ('User has been Deleted! ')</script>"; //print alert
            echo "<script>window.location = 'adminHomePage.php'</script>";
        }
        //print_r($_POST["hidden_name"]);
    }

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users List</title>
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
        <h1 class="heading" > List of <span>Accounts</span> </h1>

        <div class="contents" style="top: 200px;">

            <form action="#" method="POST">

                <table class="table" id="table">

                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Email Address</th>
                        <th>Contact Number</th>
                        <th>Action</th>
                        <!-- <th>Date</th> -->
                    </tr> 

                    <?php   
        
                        while ($array = mysqli_fetch_array($users_result)){
                    ?>  

                    <tr>  

                        <form action="#" method="post">
                            <td><?php echo $array["name"]; ?></td>
                            <input type="hidden" name="hidden_name" value="<?php echo $array["name"]; ?>">
                            <td><?php echo $array["address"]; ?></td>
                            <td><?php echo $array["username"]; ?></td>
                            <td><?php echo $array["password"]; ?></td>
                            <td><?php echo $array["email_address"]; ?></td>
                            <td><?php echo $array["contact_number"]; ?></td>
                            <td><input type="submit" class="btn delete" name="delete" value = "Delete" style="width: 120px; height: 50px; padding: 0px; font-size: 16pt;"></input></td>
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