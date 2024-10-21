<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   

   $select_users = mysqli_query($conn, "SELECT * FROM `staff` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

         $_SESSION['staffname'] = $row['name'];
         $_SESSION['staffemail'] = $row['email'];
         $_SESSION['staffgender'] = $row['gender'];
         $_SESSION['staffphone'] = $row['phone'];
         $_SESSION['staffaddress'] = $row['address'];
         $_SESSION['staffid'] = $row['id'];
         header('location:admin_page.php');

   }
   else{
      $select_users1 = mysqli_query($conn, "SELECT * FROM `customer` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users1) > 0){

      $row = mysqli_fetch_assoc($select_users1);

         $_SESSION['custname'] = $row['name'];
         $_SESSION['custemail'] = $row['email'];
         $_SESSION['custphone'] = $row['phone'];
         $_SESSION['custaddress'] = $row['address'];
         $_SESSION['custcity'] = $row['city'];
         $_SESSION['custid'] = $row['id'];
         header('location:home.php');

      }else{
      $message[] = 'incorrect email or password!';
   }

}}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

   
<section class="form-container">
   <form action="" method="post">
      <h3>welcome</h3>
      <img src="images/logo.jpg" alt="" class="image" height="100px" width="100px">
      <h3>fahin cat supermarket</h3>
      <input type="email" name="email" class="box" placeholder="Email" required>
      <input type="password" name="password" class="box" placeholder="Password" required>
      <input type="submit" class="btn" name="submit" value="login">
      <p>don't have an account? <a href="register.php">register here</a></p>
   </form>

</section>

</body>
</html>