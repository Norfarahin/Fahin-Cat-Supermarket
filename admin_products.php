<?php

include 'config.php';

session_start();

$staffid = $_SESSION['staffid'];

if(!isset($staffid)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $description = mysqli_real_escape_string($conn, $_POST['description']);
   $category = mysqli_real_escape_string($conn, $_POST['category']);
   $type = $_POST['type'];
   $date = mysqli_real_escape_string($conn, $_POST['date']);
   $stock = $_POST['stock'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;



   $select_product_name = mysqli_query($conn, "SELECT name FROM `product` WHERE name = '$name' ") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already exist!';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `product`(name, description, price, image, category, type, stock, date) VALUES('$name', '$description', '$price', '$image', '$category', '$type', '$stock', '$date')") or die('query failed');

      if($insert_product){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folter);
            $message[] = 'product added successfully!';
         }
      }
   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `product` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `product` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `cart1` WHERE pid = '$delete_id'") or die('query failed');
   $message[] = 'product deleted successfully!';
   // header('location:admin_products.php');


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add product</h3>
      <select name="category"  class="box">
         <option value="">select category</option>
         <option value="Food">Food</option>
         <option value="Accessories">Accessories</option>
         <option value="Care">Care</option>
      </select>
      <input type="text" class="box" required placeholder="enter product name" name="name">

      <select name="type"  class="box">
         <option value="">select type</option>
         <option value="Dry">Dry</option>
         <option value="Moist">Moist</option>
         <option value="Canned or Wet">Canned or Wet</option>
         <option value="Bed">Bed</option>
         <option value="Bowls & Feeders">Bowls & Feeders</option>
         <option value="Carries">Carriers</option>
         <option value="Collars, Tags & Leashes">Collars, Tags & Leashes</option>
         <option value="Funiture & Scratches">Funiture & Scratches</option>
         <option value="Toys">Toys</option>
         <option value="Syampoo">Syampoo</option>
         <option value="Dental">Dental</option>
         <option value="Flea Treatment">Flea Treatment</option>
         <option value="Ear Cleaner">Ear Cleaner</option>
         <option value="Medicine">Medicine</option>
      </select>

      <input type="text" min="0" class="box" required placeholder="enter product price" name="price">
      <textarea name="description" class="box" required placeholder="enter product description" cols="30" rows="10"></textarea>
      <input type="number" class="box" placeholder="enter stock" name="stock">
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <span>Expired Date</span>
      <input type="date" class="box"  placeholder="enter product date" name="date">
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `product` ORDER BY id desc") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <div class="price">RM<?php echo $fetch_products['price']; ?></div>
         <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <h3><div class="description">Description : <?php echo $fetch_products['description']; ?></div></h3>
         <h3><div class="category">Category : <?php echo $fetch_products['category']; ?></div></h3>
         <h3><div class="type">Type : <?php echo $fetch_products['type']; ?></div></h3>
         <h3><div class="stock">Stock : <?php echo $fetch_products['stock']; ?></div></h3>
         <h3><div class="date">Expired Date : <?php echo $fetch_products['date']; ?></div></h3>
         <a href="admin_update_product.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>
   

</section>



 








<script src="js/admin_script.js"></script>

</body>
</html>