<?php

include 'config.php';

session_start();

$custid = $_SESSION['custid'];

if(!isset($custid)){
   header('location:login.php');
};

if(isset($_POST['order'])){
    $grand_total = mysqli_real_escape_string($conn, $_POST['grand_total']);
    $fee = mysqli_real_escape_string($conn, $_POST['fee']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['flat'].', '. $_POST['city'].', '. $_POST['state'].', '. $_POST['pin_code']);
    // $placed_on = date('d-M-Y');
   

    $cart_total = 0;
    $grand=0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT *,product.name as product_name FROM `cart1`  JOIN `customer` ON cart1.user_id = customer.id JOIN product on cart1.pid=product.id WHERE user_id = '$custid' ") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['product_name'].' ('.$cart_item['quantity'].') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
            $grand=$cart_total+$fee;

            $pid = $cart_item['pid'];
            $qty = $cart_item['quantity'];
            $stock = $cart_item['stock'];
            $updatedstock = $stock-$qty ;

            $update_query = mysqli_query ($conn, "UPDATE product SET stock = '$updatedstock' WHERE id='$pid' ") or die ('query failed');

        }
    }

    $total_products = implode($cart_products, ',');

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$grand'") or die('query failed');

    if($cart_total == 0){
        $message[] = 'your cart is empty!';
    }elseif(mysqli_num_rows($order_query) > 0){
        $message[] = 'order placed already!';
    }else{
            $trackrand = round(microtime(true)) ;   
            $trackname=  'ZR';
            $track = $trackname.$trackrand;

        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method,address, total_products, total_price, tracknum) VALUES('$custid', '$name', '$number', '$email', '$method', '$address', '$total_products', '$grand', '$track')") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart1` WHERE user_id = '$custid'") or die('query failed');
        $message[] = 'order placed successfully!';
        header('location:payment.php');

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="heading">
    <h3>checkout order</h3>
    <p> <a href="home.php">home</a> / checkout </p>
</section>

<section class="display-order">
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart1`  JOIN `customer` ON cart1.user_id = customer.id JOIN product on cart1.pid=product.id WHERE user_id = '$custid'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price; 

    ?>    
    <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo 'RM'.$fetch_cart['price'].' x '.$fetch_cart['quantity']?> <?php echo '= RM '.$total_price; ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
    ?>
    <div class="grand-total">Shipping Fee : <input id="shipping_fee" style="background: none;" readonly></input>
        <br>Grand total : <input id="grand_total" value="<?php echo $grand_total; ?>" style="background: none;"></input></div>
</section>

<section class="checkout">

    <form action="" method="POST">

        <h3>place your order</h3>

        <?php
                $select_cust = mysqli_query($conn, "SELECT * FROM `customer` WHERE id = $custid" ) or die('query failed');
                 if(mysqli_num_rows($select_cust) > 0){
                    while($fetch_products = mysqli_fetch_assoc($select_cust)){
         ?>
         <input type="hidden" name="grand_total" value="<?php echo $grand_total ?>">

        <div class="flex">
            <div class="inputBox">
                <span>your name :</span>
                <input type="text" value="<?php echo $fetch_products['name']; ?>" name="name">
            </div>
            <div class="inputBox">
                <span>your number :</span>
                <input type="number" value="<?php echo $fetch_products['phone']; ?>" name="number" min="0">
            </div>
            <div class="inputBox">
                <span>your email :</span>
                <input type="email" value="<?php echo $fetch_products['email']; ?>" name="email">
            </div>
            <div class="inputBox">
                <span>payment method :</span>
                <select name="method">
                    <option value="credit card">credit card</option>
                </select>
            </div>

             <div class="inputBox">
                <span>shipping fee :</span>
                <select name="fee" id="fee" onchange="leaveChange()">
                    <option value="10">Semenanjung Malaysia</option>
                    <option value="15">Sabah&Sarawak</option>
                </select>

                <div id="message"></div>
                <script type="text/javascript">
                $(document).ready(function() { 
                    var fee = document.getElementById("fee").value;
                    var grandTotal = document.getElementById("grand_total").value;

                    var finalTotal = parseFloat(fee) + parseFloat(grandTotal);
                    document.getElementById("grand_total").value = "RM" + finalTotal;
                    document.getElementById("shipping_fee").value = "RM" + fee;
                });

                function leaveChange() {
                    var fee = document.getElementById("fee").value;
                    var grandTotal = document.getElementById("grand_total").value;

                    var finalTotal = parseFloat(fee) + parseFloat(grandTotal);
                    document.getElementById("grand_total").value = "RM" + finalTotal;
                    document.getElementById("shipping_fee").value = "RM" + fee;
                }
                </script>
            </div>

            <div class="inputBox">
                <span>address :</span>
                <input type="text"  value="<?php echo $fetch_products['address']; ?>" name="flat">
            </div>
           <!--  <div class="inputBox">
                <span>address line 02 :</span>
                <input type="text" name="street" placeholder="e.g. street name">
            </div> -->
            <div class="inputBox">
                <span>city :</span>
                <input type="text"  value="<?php echo $fetch_products['city']; ?>" name="city" placeholder="e.g. melaka tengah">
            </div>
            <div class="inputBox">
                <span>state :</span>
                <input type="text" value="<?php echo $fetch_products['state']; ?>" name="state" placeholder="e.g. melaka">
            </div>
            <div class="inputBox">
                <span>pin code :</span>
                <input type="number" min="0" value="<?php echo $fetch_products['pin']; ?>" name="pin_code" placeholder="e.g. 123456">
            </div>
        </div>
        <input type="submit" name="order" value="place order" class="btn">

    </form>
    <?php
      }
   }else{
      echo '<p class="empty">no update customer select</p>';
   }
?>

</section>




<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>