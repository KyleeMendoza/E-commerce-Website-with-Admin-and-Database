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

    $retailer_sql = "select * from products_db"; 
    $supplier_sql = "select * from sproducts_db"; 
    $order_sql = "select * from user_orders"; 

    $retailer_result = mysqli_query($data, $retailer_sql);
    $supplier_result = mysqli_query($data, $supplier_sql);
    $order_result = mysqli_query($data, $order_sql);


    
    //generate random num for invoice number
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

    if(isset($_GET["action"]))          //if dedelete yung item sa cart mula checkoutpage
    {  
        if($_GET["action"] == "delete")  
        {  
            foreach($_SESSION["cart"] as $keys => $values)  
            {  
                if($values["product_id"] == $_GET["id"])
                {  
                    unset($_SESSION["cart"][$keys]);  
                    echo '<script>alert("Item Removed")</script>';
                    echo '<script>window.location="checkoutpage.php"</script>';  
                    
                }  

                $total = $total + ($values["product_quantity"] * $values["product_price"]);  
                
            }  
            // foreach($_SESSION["cart"] as $keys => $values) {
            //     echo $values["product_name"];
            // }
            // echo $_GET["id"]; 
        }
    } 


    //pag kinlick yung place order button
    if (isset($_POST['place_order'])) {

        // print_r($_POST["hidden_Invoice"]);
        // print_r($_POST["hidden_Total"]);

        // $data = mysqli_connect($host, $user, $password, $db);
        // if ($data === false){
    
        //     die("connection error"); //if connected unsuccessfully, throw error
    
        // }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){ //if the "method" of the form is "POST"
    
            //create variable from post hidden input
            $invoice = $_POST["hidden_Invoice"]; 
            $total = $_POST["hidden_Total"];
            $user_name = $_SESSION["name"]; //get name
            $user_id = $_SESSION["user_id"];
            $address = $_SESSION["address"];
            $total_quantity = $_SESSION["total_quantity"];//For total_quantity column

            if ($total == 0){ //if nothing has been purchased, do nothing

                echo "<script>alert ('You have an empty cart.')</script>"; //print alert
                echo "<script>window.location = 'userHomePage.php#orders'</script>";

            } else {

                if ($_SESSION["userType"] == "supplier"){ //check natin if supplier, para alam natin anong db need kunin

                    // foreach($_SESSION["cart"] as $keys => $values) { //scan all items in cart
                    //     $name = $values["product_name"]; //get item name
                    //     $quantity = $values["product_quantity"]; //get item quantity
                    //     print_r($name);

                    //     while($row = mysqli_fetch_assoc($supplier_result)) //scan each rows of supplier db 
                    //     {
                    //         //print_r($row["name"]);
                    //         if ($row["name"] == $name){ //if item name from db == item name in cart
                    //             $newStock = $row["stock"] - $quantity; //bawasan ang stock sa db
                    //             mysqli_query($data, "UPDATE sproducts_db SET stock='$newStock' WHERE name='$name'"); //implement
                    //             //break;
                    //             //print_r($row["name"]);
                    //             //print_r($name);
                    //         }
                    //     }
                    // }
                    while($row = mysqli_fetch_assoc($supplier_result)){ //scan each rows of supplier db 
                        foreach($_SESSION["cart"] as $keys => $values) {
                            if ($row["name"] == $values["product_name"]){
                                $name = $values["product_name"];
                                //print_r($name);
                                $newStock = $row["stock"] - $values["product_quantity"];
                                mysqli_query($data, "UPDATE sproducts_db SET stock='$newStock' WHERE name='$name'");
                            }
                        }
                    }

                } else {
                    
                    // foreach($_SESSION["cart"] as $keys => $values) {
                    //     $name = $values["product_name"];
                    //     $quantity = $values["product_quantity"];

                    //     while($row = mysqli_fetch_assoc($retailer_result))
                    //     {
                    //         if ($row["name"] == $name){
                    //             $newStock = $row["stock"] - $quantity;
                    //             mysqli_query($data, "UPDATE products_db SET stock='$newStock' WHERE name='$name'");
                    //             //break;
                    //         }   
                    //     }
                    // }
                    while($row = mysqli_fetch_assoc($retailer_result)){ //scan each rows of supplier db 
                        foreach($_SESSION["cart"] as $keys => $values) {
                            if ($row["name"] == $values["product_name"]){
                                $name = $values["product_name"];
                                //print_r($name);
                                $newStock = $row["stock"] - $values["product_quantity"];
                                mysqli_query($data, "UPDATE products_db SET stock='$newStock' WHERE name='$name'");
                            }
                        }
                    }
                }

                $total_price = 0;  
                foreach($_SESSION["cart"] as $keys => $values) {
                    

                    $name = $values["product_name"];
                    $quantity = $values["product_quantity"];
                    $price = $values["product_price"];

                    $total_price = $quantity * $price;

                    $order_query = "insert into user_orders (name,product_name,product_quantity,product_price) values ('$user_name', '$name', '$quantity', '$total_price')";
                    mysqli_query($data, $order_query);

                }


                //save to database purchase history
                $query = "insert into purchase_history (user_id,name,invoice,address,total,total_quantity) values ('$user_id','$user_name','$invoice','$address','$total','$total_quantity')";

                mysqli_query($data, $query);

                $_SESSION["dummy_cart"] = $_SESSION["cart"];

                unset($_SESSION["cart"]); //remove cart items after sql insert
                unset($_SESSION["userType"]); //remove user type baka magbago ng order type e 

                //redirect to login after creation
                header("Location: userHomePage.php");

                die;
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
    <title>Checkout Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="fullPageContainerCheckOutPage">
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
    
        <section class="home" id="home">
    
            <div class="content">
                <h3>Fresh And <span>Frozen</span> Products For You</h3>
                <p>Supplying Fresh and Frozen Products for both Retailers and Wholesalers. Pampanga`s Best * CDO * Purefoods * MJB</p>
                <a href="#" class="btn" name="products" id="products">Shop Now</a>
            </div>
        
        </section>
    
    
    
        <!-- Main content -->
        <section class="checkout" id="checkout">
    
            <div class="details">
                <h1 class="heading">Delivery <span>Details</span> </h1>
    
                <div class="subdetails">

                    <p>Name: <span id="checkoutName"><?php echo $_SESSION['name']; ?></span></p>
                    <p>Contact: <span id="checkoutContact"><?php echo $_SESSION['contact_number']; ?></span></p>
                    <p>Address: <span id="checkoutAddress"><?php echo $_SESSION['address']; ?></span></p>
                    <p>Date: <input type="text" placeholder="mm/dd/yyyy" name="OrderDate" id="OrderDate" readonly></p>

                </div> 
    
            </div>
                            
            <div class="tableSection">

                <form action="#" method="post" id="formPost">
                    <?php
                        include('cartTable.php'); //import cartTable
                        //get total price
                        $total = 0;
                        if (isset($_SESSION["cart"])){ //if may laman cart session
                            foreach($_SESSION["cart"] as $keys => $values)  
                            {
                                $total = $total + ($values["product_quantity"] * $values["product_price"]); //get its total para pwede madisplay
                            }
                            $_SESSION["total"] = $total;
                        }
                        
                    ?>
                    <!-- lagayan ng invoice at total -->
                    <input type="hidden" name="hidden_Invoice" value="<?php $invoice_id = random_num(10); echo $invoice_id; $_SESSION["invoice"] = $invoice_id?>"> 
                    <input type="hidden" name="hidden_Total" value="<?php echo $total; ?>">

                    <input type="submit" name="place_order" id="place_order" class="trigger" value="Place Order">
                </form>

            </div>

            
        </section>
        <!-- Main content -->

    </div>

    

<!-- js connection -->
<script src="script.js"></script>

</body>
</html>


