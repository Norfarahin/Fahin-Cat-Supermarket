<?php
	include 'config.php';

	session_start();

	$staffid = $_SESSION['staffid'];

	if(!isset($staffid)){
   	header('location:login.php');
};

	if(isset($_POST['edit'])){
		$id = $_POST['id'];	
		$shipping_status = $_POST['shipping_status'];


	
			$shipping =mysqli_query($conn, "UPDATE orders SET shipping_status= '$shipping_status' WHERE id= '$id'");
			if(mysqli_num_rows($shipping) > 0){
            while($fetch_shipping = mysqli_fetch_assoc($shipping)){
			$_SESSION['success'] = 'Shipping Status updated successfully';
		
		
	}
	
}
}

	header('location:admin_shipping.php');

?>