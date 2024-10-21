<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $name = mysqli_real_escape_string($conn, $filter_name);
   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));
   $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));
   $filter_phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
   $phone = mysqli_real_escape_string($conn, $filter_phone);
   $filter_address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
   $address = mysqli_real_escape_string($conn, $filter_address);
   $filter_city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
   $city = mysqli_real_escape_string($conn, $filter_city);
   $filter_state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
   $state = mysqli_real_escape_string($conn, $filter_state);
   $filter_pin = filter_var($_POST['pin'], FILTER_SANITIZE_STRING);
   $pin = mysqli_real_escape_string($conn, $filter_pin);

   $select_users = mysqli_query($conn, "SELECT * FROM `customer` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `customer`(name, email, password, phone, address, city, state, pin) VALUES('$name', '$email', '$pass', '$phone', '$address', '$city', '$state', '$pin')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login.php');
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
   <title>register</title>

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
      <h3>register now</h3>
      <input type="text" name="name" class="box" placeholder="enter your username" required>
      <input type="email" name="email" class="box" placeholder="enter your email" required>
      <input type="phone" name="phone" class="box" placeholder="enter your phone number" required>
      <input type="address" name="address" class="box" placeholder="enter your address" required>
      <input type="city" name="city" class="box" placeholder="enter your city" 
      required>
      <input type="state" name="state" class="box" placeholder="enter your state" 
      required>
      <input type="pin" name="pin" class="box" placeholder="enter your pin code" 
      required>
      <input type="password" name="pass" class="box" placeholder="enter your password" required>
      <input type="password" name="cpass" class="box" placeholder="confirm your password" required>

      <input type="submit" class="btn" name="submit" value="register now">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</section>

</body>
</html>