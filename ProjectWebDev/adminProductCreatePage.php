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


    if (isset($_POST["add"])){

        if ($_SERVER["REQUEST_METHOD"] == "POST"){ //if the "method" of the form is "POST"

            $product_brand = $_POST["brand"]; 
            $product_name = $_POST["name"]; 
            $rstock = $_POST["rstock"]; 
            $rprice = $_POST["rprice"]; 
            $sstock = $_POST["sstock"]; 
            $sprice = $_POST["sprice"]; 

            $supply_check = "SELECT * FROM sproducts_db WHERE name = '$product_name'";
            $retail_check = "SELECT * FROM products_db WHERE name = '$product_name'";
            $sc = mysqli_query($data, $supply_check);
            $rc = mysqli_query($data, $retail_check);

            if ($product_brand == "" || $product_name == "" || $rstock == "" || $rprice == "" || $sstock == "" || $sprice == ""){
                echo "<script>alert ('Please fill all inputs')</script>";
                echo "<script>window.location = 'adminProductCreatePage.php'</script>";
            }

            else if (mysqli_num_rows($sc) > 0 || mysqli_num_rows($rc) > 0) {

                echo "<script>alert ('Product Already Exists.')</script>";
                echo "<script>window.location = 'adminProductCreatePage.php'</script>";

            }
            
            else {

                $supply_query = "insert into sproducts_db (name,brand,stock,price) values ('$product_name','$product_brand','$sstock','$sprice')";
                $retail_query = "insert into products_db (name,brand,stock,price) values ('$product_name','$product_brand','$rstock','$rprice')";
                mysqli_query($data, $supply_query);
                mysqli_query($data, $retail_query);
                $_SESSION["number"]++;

                //redirect to login after creation
                //header("Location: adminProductCreatePage.php");
                echo "<script>alert ('Product has been created.')</script>";
                echo "<script>window.location = 'adminProductCreatePage.php'</script>";
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
    <title>Add Product</title>
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

    <section class="productCreate">
        <h1 class="heading" > Add <span>Products</span> </h1>
        <div class="contents">
            <table class="table">

                <tr>
                    <th>No.</th>
                    <th>Product Brand</th>
                    <th>Product name</th>
                    <th>Retail Stock</th>
                    <th>Retail Price</th>
                    <th>Supplier Stock</th>
                    <th>Supplier Price</th>
                    <th>Action</th>
                    <!-- <th>Date</th> -->
                </tr> 

                <tr>  
                    <form action="#" method="post">

                        <td><?php echo $_SESSION["number"]; ?></td>

                        <td><input type="text" name="brand" placeholder="Product Brand"></td>
                        <td><input type="text" name="name" placeholder="Product Name"></td>
                        <td><input type="number" name="rstock" ></td>
                        <td>₱<input type="number" name="rprice" ></td>
                        <td><input type="number" name="sstock" ></td>
                        <td>₱<input type="number" name="sprice" ></td>
                        <td><input type="submit" class="btn" name="add" value = "Add" style="width: 120px; height: 50px; padding: 0px; font-size: 16pt;"></input></td>
                    
                    </form>
                    
                </tr>

                <!-- <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2" ><input type="button" class="btn" name="insert" value = "+ insert" style="width: 120px; height: 50px; padding: 0px; font-size: 16pt;"></input></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> -->

            </table>
        </div>
    </section>
    
</body>
</html>