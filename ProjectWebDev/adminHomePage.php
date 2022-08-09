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

    $sql = "select * from purchase_history"; 
    $result = mysqli_query($data, $sql);
    $pending_sql = "select * from purchase_history where status='Pending'"; 
    $pending_result = mysqli_query($data, $pending_sql);

    $retailer_sql = "select * from products_db"; 
    $supplier_sql = "select * from sproducts_db"; 
    $retailer_result = mysqli_query($data, $retailer_sql);
    $supplier_result = mysqli_query($data, $supplier_sql);

    $stmt = $data->prepare("SELECT total FROM purchase_history"); //Get all data in total column
    $stmt->execute();
    $array = [];
    foreach ($stmt->get_result() as $row)
    {
        $array[] = $row['total'];
    }
    $number = count($array); //For Total Order
    $total = (array_sum($array)); //Sum of all data in total Column for Total Sales

    $stmt2 = $data->prepare("SELECT total_quantity FROM purchase_history"); //Get all data in total_quantity column
    $stmt2->execute();
    $quantity_array = [];
    foreach ($stmt2->get_result() as $row)
    {
        $quantity_array[] = $row['total_quantity'];
    }
    $total_quantity = (array_sum($quantity_array)); //Sum of all data in total_quantity Column for Total Product
    $total_profit = $total_quantity * 5; // For Total Profit

    if (isset($_POST['view'])){
        //print_r($_POST['hidden_Name']);
        $_SESSION["order_name"] = $_POST['hidden_Name'];

        if ($_POST["hidden_status"] == 'Pending'){
            //redirect to view order after creation
            header("Location: viewOrder.php");
        } else {
            echo "<script>alert ('Order is already Completed! ')</script>"; //print alert
            echo "<script>window.location = 'adminHomePage.php'</script>";
        }

        //print_r($_POST['hidden_status']);

    }

    //display yung number ng pending orders at display sa tabi ng admin icon
    $counter = 0;
    while ($counting = mysqli_fetch_array($pending_result)){
        if ($counting["status"] == "Pending"){
            $counter++;
        }
    }


    $_SESSION["pampanga"] = 0;
    $_SESSION["cdo"] = 0;
    $_SESSION["mjb"] = 0;
    $_SESSION["tj"] = 0;

    while($row = mysqli_fetch_assoc($supplier_result)) {
        if ($row["brand"] == "pampanga") {
            if ($_SESSION["pampanga"] == 0) {
                $_SESSION["pampanga"] = 50 - $row["stock"];
            } else {
                $_SESSION["pampanga"] = $_SESSION["pampanga"] + (50 - $row["stock"]);
            }   
        }
        else if ($row["brand"] == "cdo") {
            if ($_SESSION["cdo"] == 0) {
                $_SESSION["cdo"] = 50 - $row["stock"];
            } else {
                $_SESSION["cdo"] = $_SESSION["cdo"] + (50 - $row["stock"]);
            }   
        }
        else if ($row["brand"] == "mjb") {
            if ($_SESSION["mjb"] == 0) {
                $_SESSION["mjb"] = 50 - $row["stock"];
            } else {
                $_SESSION["mjb"] = $_SESSION["mjb"] + (50 - $row["stock"]);
            }   
        }
        else {
            if ($_SESSION["tj"] == 0) {
                $_SESSION["tj"] = 50 - $row["stock"];
            } else {
                $_SESSION["tj"] = $_SESSION["tj"] + (50 - $row["stock"]);
            }   
        }
    }

    while($row2 = mysqli_fetch_assoc($retailer_result)) {
        if ($row2["brand"] == "pampanga") {
            if ($_SESSION["pampanga"] == 0) {
                $_SESSION["pampanga"] = 50 - $row2["stock"];
            } else {
                $_SESSION["pampanga"] = $_SESSION["pampanga"] + (50 - $row2["stock"]);
            }   
        }
        else if ($row2["brand"] == "cdo") {
            if ($_SESSION["cdo"] == 0) {
                $_SESSION["cdo"] = 50 - $row2["stock"];
            } else {
                $_SESSION["cdo"] = $_SESSION["cdo"] + (50 - $row2["stock"]);
            }   
        }
        else if ($row2["brand"] == "mjb") {
            if ($_SESSION["mjb"] == 0) {
                $_SESSION["mjb"] = 50 - $row2["stock"];
            } else {
                $_SESSION["mjb"] = $_SESSION["mjb"] + (50 - $row2["stock"]);
            }   
        }
        else {
            if ($_SESSION["tj"] == 0) {
                $_SESSION["tj"] = 50 - $row2["stock"];
            } else {
                $_SESSION["tj"] = $_SESSION["tj"] + (50 - $row2["stock"]);
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
    <title>Admin Page</title>
    <link rel="stylesheet" href="adminCSS.css">

    <!-- Bar Graph Script Import -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <!-- Doughnut Graph -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

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
        <a href="logout.php" id="logout-btn" class="btn" style="margin-top: 550px">Log Out</a>
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
                    echo "<span id='cart_count'>$counter</span>";
                    $_SESSION["pending"] = $counter;
                ?>
            </i>
            <span id="adminName">Admin</span>
        </div>
    </div>
    
    <div class="content">

        <h1 class="heading"> Sales <span>Dashboard</span> </h1>

        <div class="container">
            <div class="FirstLineContainer">
                <div class="Box1">
                    <div class="img">
                        <img src="Images/pesos.png" alt="">
                    </div>
                    <div class="wrapper">
                        <div class="text1">
                            <p style="margin: 0; color: #666; font-size: 16pt;">Total Sales</p>
                        </div>
                        <div class="text2">
                            <p  style="margin: 5px 0 0 0;  font-weight: bold; font-size: 20pt;" id="totalSales" ><?php echo $total; ?></p>
                        </div>
                    </div>
                </div>
                <div class="Box1">
                    <div class="img">
                        <img src="Images/pesos.png" alt="">
                    </div>
                    <div class="wrapper">
                        <div class="text1">
                            <p style="margin: 0; color: #666; font-size: 16pt;">Total Profit</p>
                        </div>
                        <div class="text2">
                            <p  style="margin: 5px 0 0 0;  font-weight: bold; font-size: 20pt;" id="totalSales"><?php echo $total_profit; ?></p>
                        </div>
                    </div>
                </div>
                <div class="Box1">
                    <div class="img">
                        <img src="Images/cart2.png" alt="">
                    </div>
                    <div class="wrapper">
                        <div class="text1">
                            <p style="margin: 0; color: #666; font-size: 16pt;">Total Order</p>
                        </div>
                        <div class="text2">
                            <p  style="margin: 5px 0 0 0;  font-weight: bold; font-size: 20pt;" id="totalSales"><?php echo $number; ?></p>
                        </div>
                    </div>
                </div>
                <div class="Box1">
                    <div class="img">
                        <img src="Images/basket.png" alt="">
                    </div>
                    <div class="wrapper">
                        <div class="text1">
                            <p style="margin: 0; color: #666; font-size: 16pt;">Total Products Sold</p>
                        </div>
                        <div class="text2">
                            <p  style="margin: 5px 0 0 0;  font-weight: bold; font-size: 20pt;" id="totalSales"><?php echo $total_quantity; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="SecondLineContainer">
                <div class="Box2">
                    <canvas id="barGraph" style="width:100%;max-width:600px"></canvas>
                </div>
                <div class="Box2-5">
                    <canvas id="doughnutChart" style="width:100%;max-width:600px"></canvas>
                </div>
            </div>
            <div class="ThirdLineContainer">
                <div class="Box3">
                    <h2 style="font-family: Lato, sans-serif; font-size: 18pt; margin-left: 20px; color: #666;">Latest Orders</h2>

                    <table class="table">
                        <tr>
                        <th id="adminNo">No.</th>
                        <th id="adminDate">Date</th>
                        <th id="adminCustomerName">Customer Name</th>
                        <th id="adminAddress">Address</th>
                        <th id="adminTotaPrice">Total Price</th>
                        <th id="adminDate">Invoice</th>
                        <th id="adminStatus">Status</th>
                        <th id="adminAction">Action</th>
                        </tr>
                        <?php   
                            $number = 1; //manual indexing
    
                            while ($array = mysqli_fetch_array($result)){
                                if ($array["status"] == "Pending"){
                        ?>  
                        <tr>  
                            
                            <form action="#" method="post">

                                <td><?php echo $number++; ?></td>  
                                <td><?php echo $array["date"]; ?></td>

                                <td><?php echo $array["name"]; ?></td>
                                <input type="hidden" name="hidden_Name" value="<?php echo $array["name"]; ?>">
                                
                                <td><?php echo $array["address"]; ?></td>   
                                <td>₱ <?php echo $array["total"]; ?></td>  
                                <td><?php echo $array["invoice"]; ?></td>

                                <td><?php 
                                if ($array["status"] == "Pending"){
                                    echo "<p style='color:red;'>" . $array["status"] . "</p>";
                                } else {
                                    echo "<p style='color:green;'>" . $array["status"] . "</p>";
                                }
                                ?></td>
                                
                                <input type="hidden" name="hidden_status" value="<?php echo $array["status"]; ?>">

                                <td><input type="submit" class="btn" name="view" value = "View" style="width: 150px; height: 50px; padding: 0px"></input></td>
                            
                            </form>

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
            </div>
        </div>
    </div>

    <!-- Bar Graph Script -->
    <script>

        const month = new Date().getMonth();
        var current = <?php echo $total; ?>;
        var jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec;
        //jan = feb = mar = apr = may = june = jul = aug = sept = oct = nov = dec = 0;


        var xValues = ["Jan", "Feb", "Apr", "May", "June", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        //var yValues = [10, 9, 8, 8, 9, 11, 7, 10, 11, 13, 16 ];
        switch (month) {
            case 0:
                jan = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;
            case 1:
                feb = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;
            case 2:
                mar = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;
            case 3:
                apr = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;
            case 4:
                may = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;
            case 5:
                june = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;
            case 6:
                july = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;
            case 7:
                aug = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;    
            case 8:
                sept = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;
            case 9:
                oct = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;
            case 10:
                nov = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;
            case 11:
                dec = current;
                var yValues = [jan, feb, mar, apr, may, june, jul, aug, sept, oct, nov, dec];
                break;  
            default:
                console.log("Error");
        }

        var barColors = "orange";
        
        new Chart("barGraph", {
          type: "bar",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {display: false},
            title: {
            display: true,
                text: "Sales Statistics"
            },
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }],
            }
            
          }
        });

    </script>


    <!-- Doughnut Chart Script -->
    <script>

        var xValues = ["Pampanga's Best", "CDO", "MJB", "Tender Juicy"]
        var yValues = [<?php echo $_SESSION["pampanga"]; ?>, <?php echo $_SESSION["cdo"]; ?>, <?php echo $_SESSION["mjb"]; ?>, <?php echo $_SESSION["tj"]; ?>];
        var barColors = [
            "#b91d47",
            "#00aba9",
            "#2b5797",
            "#e8c3b9"
        ];
        
        new Chart("doughnutChart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                backgroundColor: barColors,
                data: yValues
                }]
            },
            options: {
                title: {
                display: true,
                text: "Number of Sales per Product Brand"
                }
            }
        });

    </script>

    <!-- js connection -->
    <script src="script.js"></script>

</body>

</html>