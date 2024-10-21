<?php

include 'config.php';

session_start();

$custid = $_SESSION['custid'];

if(!isset($custid)){
   header('location:login.php');
};

if(isset($_POST['pay'])){


        $sql = "SELECT MAX(id) AS id FROM orders WHERE user_id = '$custid' AND payment_status = 'pending'";

        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $order_id = $row["id"];


        $sqlUpdate = "UPDATE orders SET payment_status = 'paid' WHERE id = '$order_id'";
        if(!mysqli_query($conn, $sqlUpdate)) {
        echo "<script>alert('Payment Failed'); window.history.go(-1);</script>";
        exit();
   } else 
   {
        mysqli_query($conn, "DELETE FROM `cart1` WHERE user_id = '$custid'") or die('query failed');
        echo "<script>alert('Payment Success'); window.location='orders.php';</script>";
        exit();
   }

        }
    

?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>payment</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<style>
    .invalid-feedback {
  display: none;
  width: 100%;
  margin-top: 0.25rem;
  font-size: 0.875em;
  color: #dc3545;
}

</style>
<section class="checkout1">

    <form action="" method="POST">

        <h3>Card Information</h3>

         <img src="images/visa.png" alt="" class="image"  height="90px" width="250px" style="float:right">

        <br>
        <br>
        <br>
        <br>
        <br>
        <br><br><br>
        <div class="flex">
            <div class="inputBox">
                <span>Card Number :</span>
                <input type="text"  name="name" required min='16' max='16'>
            </div>
            <div class="inputBox">
                <span>Card Holder :</span>
                <input type="text"  name="card" required>
            </div>
            <div class="inputBox">
                <span>Expired Date :</span>
               <input type="text" name="cardExpMonth" required placeholder="MM/YY" required> 
            </div>
            <div class="inputBox">
                <span>CVV :</span> 
                <input type="text" name="cardCVV" required placeholder="123" required> <img src="images/visa_ccv.png" alt="" class="image"  height="90px" width="140px" style="float:right" >
            </div>
        </div>
        <input type="submit" name="pay" value="Pay" class="btn">

    </form>

</section>


<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>