
<!-- this is checkout table -->

<!-- <form method="POST" action="retailProducts.php?action=delete"> -->
<table class="dummy_table" name = "dummy_table">
            <tr>
                <th>Order Items</th>
                <th>Item Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr> 

            <?php   
            if(!empty($_SESSION["cart"]))  
            {  
                $total = 0;  
                $total_quantity = 0;
                foreach($_SESSION["cart"] as $keys => $values)  
                {  
            ?>  


            <tr>
                <td><img src="<?php echo $values["product_img"]; ?>" alt=""></td>  
                <td><?php echo $values["product_name"]; ?></td>  
                <td>₱ <?php echo $values["product_price"]; ?></td>  
                <td><?php echo $values["product_quantity"]; ?></td> 
                <td>₱ <?php echo number_format($values["product_quantity"] * $values["product_price"], 2); ?></td>  
                <!-- <td><input type="text" name="hidden_id" value="<?php echo $values["product_id"]; ?>"></td> -->
                <td><input type="button" onclick="deleteItem(<?php echo $values['product_id']; ?>)" class="btn" name="remove" value = "Remove" style="width: 120px; height: 50px; padding: 0px"></input></td>
            </tr>  



            <?php  
                    $total_quantity = $total_quantity + ($values["product_quantity"]);//Counting of total products
                    $_SESSION['total_quantity'] = $total_quantity;//To pass to another page
                    $total = $total + ($values["product_quantity"] * $values["product_price"]);  
                }  
            ?>  

            <tr >  
                <td></td>
                <td></td>
                <td></td>
                <td id="Grandtotal" colspan="3">
                    Grand Total: <span>  ₱ <?php echo number_format($total, 2); ?></span>
                </td>

            </tr>  

            
            <?php  
            }  
            ?> 
            
            
        </table>
    <!-- </form> -->