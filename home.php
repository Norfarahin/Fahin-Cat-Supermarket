<?php

@include 'config.php';

session_start();

$custid = $_SESSION['custid'];

if(!isset($custid)){
   header('location:login.php');
}

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
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Hai! <?php echo $_SESSION['custname']; ?></h3>
      <h2>WELCOME TO FAHIN CAT SUPERMARKET</h2>
      <p>Bela Kucing Rezeki Murah.</p>
      <a href="about.php" class="btn">More About Us</a>
   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `product` ORDER BY id desc LIMIT 3") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST" class="box">
         <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <div class="price">RM<?php echo $fetch_products['price']; ?></div>
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="stock">Stock: <?php echo $fetch_products['stock']; ?></div>
         <div class="date">Expired Date: <?php echo $fetch_products['date']; ?></div>
         
         <input type="number" name="quantity" value="0" min="1" class="qty">
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
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="shop.php" class="option-btn">load more</a>
   </div>

</section>

<section class="products">

 <h1 class="title">shop by category</h1>
   
 <div class="box-container">
      <form action="" method="POST" class="box">
         <img src="images/food.jpg" alt="" class="image">
         <a href="category.php?category=food" class="btn">Food</a>
      </form>
   </a>


 
      <form action="" method="POST" class="box">
         <img src="images/acc.jpg" alt="" class="image">
         <a href="category.php?category=accessories" class="btn">Accessories</a>
      </form>
   </a>

   <form action="" method="POST" class="box">
         <img src="images/care.jpg" alt="" class="image">
         <a href="category.php?category=care" class="btn">Care</a>
      </form>
   </a>
</div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>