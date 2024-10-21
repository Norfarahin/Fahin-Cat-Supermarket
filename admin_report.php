 
<?php

include 'config.php';

session_start();

$staffid = $_SESSION['staffid'];

if(!isset($staffid)){
   header('location:login.php');
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>report</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

    <!-- fetch data -->
<br>
<br>
    <div class="container">
  <p class="login-text" style="text-align: center;font-size: 3rem; color: purple; font-weight: 800">Sales Report<br></p>
  <br>
  <td><p class="login-text" style="text-align: center; color: black;font-size: 2rem;background-color:#ECF0F1;">You can view Sell Report based on Month or Year<br><br>
    <a href='salesbymonth.php? Id=$row[id]' class = 'btn btn-primary' style="margin-right: 25px;">Month</a><a href='salesbyyear.php? Id=$row[id]' class = 'btn btn-success' style="margin-right: 25px;">Year</a></td><br>
    <br>
   
<td><br><p class="login-text" style="text-align: center;font-size: 2rem">Click to go Home <br><a href='admin_page.php? Id=$row[id]' class = 'btn btn-info'>Home</p></a></td>
</div>
</body>
</html>

