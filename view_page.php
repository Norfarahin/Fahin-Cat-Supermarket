<?php

include 'config.php';

session_start();

$custid = $_SESSION['custid'];
if(!isset($custid)){
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $quantity = $_POST['quantity'];
    $stock = $_POST['stock'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart1`  JOIN `customer` ON cart1.user_id = customer.id JOIN product on cart1.pid=product.id WHERE product.name = '$product_name' AND user_id = '$custid'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    }elseif ($quantity > $stock) {
      $message[] = 'quantity exceeds current stock!';
   }else{

        mysqli_query($conn, "INSERT INTO `cart1`(user_id, pid,quantity) VALUES('$custid', '$product_id', '$quantity')") or die('query failed');
        $message[] = 'product added to cart';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="quick-view">

    <h1 class="title">product details</h1>

    <?php  
        if(isset($_GET['pid'])){
            $pid = $_GET['pid'];
            $select_products = mysqli_query($conn, "SELECT * FROM `product` WHERE id = '$pid'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
    ?>
    <form action="" method="POST">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">RM<?php echo $fetch_products['price']; ?></div>
         <div class="details"><?php echo $fetch_products['description']; ?></div>
         <div class="category"><?php echo $fetch_products['category']; ?></div>
         <div class="type"><?php echo $fetch_products['type']; ?></div>
         <div class="stock">Stock: <?php echo $fetch_products['stock']; ?></div>
         <div class="date">Expired Date: <?php echo $fetch_products['date']; ?></div>
         <input type="number" name="quantity" value="0" min="0" class="qty">
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input type="hidden" name="stock" value="<?php echo $fetch_products['stock']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
    <?php
            }
        }else{
        echo '<p class="empty">no products details available!</p>';
        }
    }
    ?>

    <div class="more-btn">
        <a href="home.php" class="option-btn">go to home page</a>
    </div>

</section>





<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>