<?php 
	include 'config.php';

	session_start();

	$staffid = $_SESSION['staffid'];

	if(!isset($staffid)){
   	header('location:login.php');
};

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		
		$shipping =mysqli_query($conn,"SELECT * FROM orders WHERE id='$id'");
		if(mysqli_num_rows($shipping) > 0){
        while($fetch_shipping = mysqli_fetch_assoc($shipping)){
        

		echo json_encode($fetch_shipping);
		}
	}
		}
?>