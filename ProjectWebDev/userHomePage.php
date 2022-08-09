<?php
    session_start();
    unset($_SESSION["cart"]);

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
    $retailer_result = mysqli_query($data, $retailer_sql);
    
    if (isset($_SESSION["dummy_cart"])){
        echo "
            <script type=\"text/javascript\">

            window.onload = function() {
                modal.classList.toggle('show-modal');
            };

            </script>
        ";

        // print_r($_SESSION["total"]);
        // print_r($_SESSION["invoice"]);
        // foreach($_SESSION["dummy_cart"] as $keys => $values) {
        //     print_r($values["product_name"]);
        // }

        //unset($_SESSION["dummy_cart"]);
    }


?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liza's Frozen Food</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <!-- navigation header starts here -->

    <div class="navigation">
        
        <a href="#" class="logo">
            <img src="Images/Logo.png" alt="Logo">
        </a>

        <ul class="mainLinks">
            <li><a href="#">Home</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#products">Product</a></li>
            <li><a href="#orders">Order</a></li>
            <li><a href="#aboutus">About</a></li>
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

    <!-- home section starts here -->

    <section class="home" id="home">

        <div class="content">
            <h3>Fresh And <span>Frozen</span> Products For You</h3>
            <p>Supplying Fresh and Frozen Products for both Retailers and Wholesalers. Pampanga`s Best * CDO * Purefoods * MJB</p>
            <a href="#orders" class="btn" name="products" id="products">Shop Now</a>
        </div>
    
    </section>

    <!-- home section ends here -->

    <!-- categories section starts  -->

    <section class="categories" id="categories">
        
        <div class="box-container">

            <h1 class="heading"> Product <span>Categories</span> </h1>

            <div class="box">
                <img src="Images/Cat-Pambest.jpg" alt="">
                <h3>Pampanga's Best</h3>
                <p>Upto 10% off Suki Discount</p>
                <a href="#orders" class="btn">View Products</a>
            </div>
            <div class="box">
                <img src="Images/Cat-CDO.jpg" alt="">
                <h3>CDO Products</h3>
                <p>Upto 10% off Suki Discount</p>
                <a href="#orders" class="btn">View Products</a>
            </div>
            <div class="box">
                <img src="Images/Cat-Tender-Juicy.jpg" alt="">
                <h3>Tender Juicy</h3>
                <p>Upto 10% off Suki Discount</p>
                <a href="#orders" class="btn">View Products</a>
            </div>
            <div class="box">
                <img src="Images/Cat-MJB.png" alt="" style="background-color: grey;">
                <h3>MJB</h3>
                <p>Upto 10% off Suki Discount</p>
                <a href="#orders" class="btn" name="aboutus" id="aboutus">View Products</a>
            </div>

        </div>

    </section>

    <!-- categories section ends -->

    <!-- about section starts -->

    <section class="about" >

        <div class="box-container">

            <h1 class="heading" > About <span>Us</span> </h1>
            <div class="subSection">
                <img src="Images/aboutUsCover.png" alt="">
            </div>
            <div class="subSection" id="content">
                <h4>Welcome To Our Shop</h4>
                <h3>Fresh And <span>Frozen</span> Products For You</h3>
                <p>Liza`s Processed Foods is a processed and
Frozen goods online store and it is owned
and managed by Mrs. Mendoza. It basically sells
frozen products such as hotdogs, nuggets, tocino
longanisa, ham, bacon, burger, corned beef and etc. 
It has a physical store located at 1815 Kalawakan Street, Karangalan Village, Manggahan, Pasig City, 
1815 Kalawakan Street Karangalan Village, Pasig, 1611 Metro Manila.
You can also order via online using this platform.</p>
                <a href="#orders" class="btn" name="features" id="features">Shop Now</a>

            </div>
        </div>

    </section>

    <!-- about section ends -->

    <!-- feature section starts here -->

    <section class="features" id="features">

        <div class="box-container">

            <h1 class="heading" > Our <span>Features</span> </h1>
            <div class="box">
                <img src="Images/feature-img-1.png" alt="">
                <h3>Fresh and Frozen</h3>
                <p>Place an order form here!</p>
                <a href="#orders" class="btn">Shop Now</a>
            </div>
            <div class="box">
                <img src="Images/feature-img-2.png" alt="">
                <h3>Free Delivery</h3>
                <p>FREE delivery for every purchase
                of 5,000 worth of frozen and
                processed foods.</p>
                <a href="#orders" class="btn">Shop Now</a>
            </div>
            <div class="box">
                <img src="Images/feature-img-3.png" alt="">
                <h3>Easy Payments</h3>
                <p>FREE delivery for every purchase
                of 5,000 worth of frozen and
                processed foods.</p>
                <a href="#orders" class="btn" name="orders" id="orders">Shop Now</a>

            </div>
        </div>

    </section>

    <!-- feature section ends here -->
    
    <!-- order section starts here -->

    <section class="order" id="order">

        <div class="box-container">

            <h3 class="customHeading">Delivery Address:</h3>
            <!-- <h1 class="heading">Make an <span>Order</span> </h1> -->

            <form id="orderForm" onsubmit="return changeForm();" method="post">

                <div class="flex">
                    <div class="inputBox">
                        <span>Name: </span>
                        <input type="text" placeholder="Full Name" name="OrderName" id="OrderName" value='<?php echo $_SESSION['name']; ?>' readonly>
                    </div>
                    <div class="inputBox">
                        <span>Contact Number: </span>
                        <input type="number" placeholder="Contact Number" name="OrderContact" id="OrderContact" value="<?php echo $_SESSION['contact_number']; ?>" readonly>
                    </div>
                    <div class="inputBox">
                        <span>Type of Purchase: </span>
                        <div class="radioButton">
                            <label class="container">Retail
                                <input type="radio" name="radio" value="Retail" id="retail" required>
                                <span class="checkmark"></span>
                            </label>
                            <label class="container">Wholesale
                                <input type="radio" name="radio" value="Supplier" id="supplier">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="inputBox">
                        <span>Address: </span>
                        <textarea placeholder="Complete Address" name="OrderAddress" id="OrderAddress" cols="30" rows="10" readonly><?php echo $_SESSION['address']; ?></textarea>
                    </div>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>Username: </span>
                        <input type="text" name="OrderUsername" id="OrderUsername" value='<?php echo $_SESSION['username']; ?>' readonly>
                    </div>
                    <div class="inputBox">
                        <span>ID: </span>
                        <input type="text" name="OrderID" id="OrderID" value='<?php echo $_SESSION['user_id']; ?>' readonly>
                    </div>
                    <div class="inputBox">
                        <span>Date: </span>
                        <input type="text" placeholder="mm/dd/yyyy" name="OrderDate" id="OrderDate" readonly>
                    </div>
                    <div class="inputBox">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d965.242182967452!2d121.09918896350199!3d14.600857111562549!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b98b29dddb83%3A0x323e6e5814e639!2s1815%20Kalawakan%20Street%2C%20Karangalan%20Village%2C%20Manggahan%2C%20Pasig%20City!5e0!3m2!1sen!2sph!4v1641831402093!5m2!1sen!2sph"allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <input type="submit" class="form-btn" value="Submit">
                </div>

                <!-- after submitting form, notes and landmark will be placed to a session variable in either supplier or retail page depends on chosen radio button-->


            </form>

        </div>

    </section>

    <!-- order section ends here -->

    <!-- footer section starts  -->
    
    <section class="footer">

        <div class="box-container">

            <div class="box">
                <a href="#" class="logo">
                    <img src="Images/Logo.png" alt="Logo">
                </a>
                <p>Connect with us through social media</p>
                <div class="footer-share">
                    <div id="fb" onclick="parent.open('https://www.facebook.com/')"><img src="Images/FooterIcons/Facebook.png" alt="Facebook"></div>
                    <div id="twitter" onclick="parent.open('https://www.twitter.com/')"><img src="Images/FooterIcons/twitter.png" alt="Twitter"></div>
                    <div id="instagram" onclick="parent.open('https://www.instagram.com/')"><img src="Images/FooterIcons/instagram.png" alt="Instagram"></div>
                </div>
                <div class="inputBox" name="footer_iframe">
                        <iframe  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d965.242182967452!2d121.09918896350199!3d14.600857111562549!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b98b29dddb83%3A0x323e6e5814e639!2s1815%20Kalawakan%20Street%2C%20Karangalan%20Village%2C%20Manggahan%2C%20Pasig%20City!5e0!3m2!1sen!2sph!4v1641831402093!5m2!1sen!2sph"allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <div class="box">
                <h3>Contact Info</h3>
                <div class="footer-icons">
                    <div id="contact1"><img src="Images/FooterIcons/contact.png" alt="Contact1">09215606459</div>
                    <div id="contact2"><img src="Images/FooterIcons/contact.png" alt="Contact2">09215606459</div>
                    <div id="emailAddress"><img src="Images/FooterIcons/email.png" alt="Email Address">mendozalizalopez1234@gmail.com</div>
                    <div id="location"><img src="Images/FooterIcons/location.png" alt="Address">KC29, Pasig - 1611</div>
                </div>
            </div>

            <div class="box">
                <h3>Quick Links</h3>
                <div class="footer-icons">
                    <ul>
                        <li><a href="#" class="links">Home </a></li>
                        <li><a href="#features" class="links">Features </a></li>
                        <li><a href="#products" class="links">Product </a></li>
                        <li><a href="#orders" class="links">Order </a></li>
                        <li><a href="#aboutus" class="links">About </a></li>
                    </ul>
                    
                </div>
            </div>

        </div>

        <div class="credit"> Created By <span> K.D Mendoza and R. Hipolito </span> | All Rights Reserved </div>

    </section>

    <div class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <!-- <h1>Hello, I am a modal!</h1> -->

            <div class="logo">
                <img src="Images/Logo.png" alt="Logo">
            </div>

            <div class="invoiceText">
                <div class="orangeBox"></div>
                <p>Order Successfully Placed</p>
            </div>

            <h2 class="text">Invoice to: </h2>

            <div class="information">

                <div class="box1">
                    <p id="invoiceName"><?php echo $_SESSION['name']; ?></p>
                    <p id="invoiceAddress" style="text-justify: auto;"><?php echo $_SESSION['address']; ?></p>
                    <p id="invoiceID"><?php echo $_SESSION['user_id']; ?></p>
                </div>
                
                <div class="box2">
                    <div class="input">
                        <!-- generate random number -->
                        <p id="invoiceNo">Invoice#: <span><?php echo $_SESSION["invoice"]; ?></span></p>
                        <p id="invoiceDate">Date: <input type="text" name="OrderDate" id="OrderDateModal" readonly></p>
                    </div>
                </div>
            </div>

            <table class="dummy_table2" name = "dummy_table2" id="dummy_table2">
                <tr>
                    <th>No</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <!-- <th>Action</th> -->
                </tr> 

                <?php   
                if(!empty($_SESSION["dummy_cart"]))  
                {  
                    //$total = 0;  
                    $number = 1;
                    foreach($_SESSION["dummy_cart"] as $keys => $values)  
                    {  
                ?>  


                <tr>  
                    <!-- <td><img src="<?php echo $values["product_img"]; ?>" alt=""></td>   -->

                    <td><?php echo $number++; ?></td>  
                    <td><?php echo $values["product_name"]; ?></td>  
                    <td>₱ <?php echo $values["product_price"]; ?></td>  
                    <td><?php echo $values["product_quantity"]; ?></td> 
                    <td>₱ <?php echo number_format($values["product_quantity"] * $values["product_price"], 2); ?></td> 

                </tr>  

                <?php
                    //$total = $total + ($values["product_quantity"] * $values["product_price"]);  
                    }  
                ?>

                <?php  
                }  
                ?> 
                
            </table>

            <h3 class="text" style="font-size: 12pt;">Thank you for your purchase !</h3>

            <div class="bottomPart">
                <div class="paymentInfo">
                    <h3 class="text1">Payment Info: </h3>
                    <div class="paymentInfotext">
                        <p><span>Account #:</span> 09685937542</p>
                        <p><span>Account #:</span> 09662048607</p>
                        <p><span>Mode of Payment:</span> GCASH</p>
                        <!-- <input type="submit" class="form-btn" id="goHome" value="Print"> -->
                        <button class="form-btn" onclick="window.print()">Print</button>
                    </div>
                </div>
                <div class="totalPrice">
                    <p id="subTotal">Sub Total: ₱<span><?php echo number_format($_SESSION["total"], 2); ?></span></p>
                    <p>Tax: <span>0.0%</span></p>
                    <div class="orangeBox2">
                        <p id="finalPrice">TOTAL: ₱<?php echo number_format($_SESSION["total"], 2); ?></p>
                        
                    </div>
                </div>
            </div>

        </div>

        <?php unset($_SESSION["dummy_cart"]); ?>
    </div>


    <!-- js connection -->
    <script src="script.js"></script>

    <script>

        //Para magappear yung modal or yung billing page pop up pag ka place order
        const modal = document.querySelector(".modal");
        //const trigger = document.querySelector(".trigger");
        const closeButton = document.querySelector(".close-button");

        function toggleModal() {
            modal.classList.toggle("show-modal");
        }

        function windowOnClick(event) {
            if (event.target === modal) {
                toggleModal();
            }
        }

        //trigger.addEventListener("click", toggleModal); //When the trigger is clicked, we want to show the modal.
        closeButton.addEventListener("click", toggleModal); //When the close button is clicked, we want to hide the modal.
        window.addEventListener("click", windowOnClick); //When the dark background is clicked, we want to also hide the modal.

    </script>

</body>
</html>