<?php
	include 'config.php';


	function generateRow($id, $conn){
		$contents = '';
		$id = $_GET['id'];


		$shipping = mysqli_query($conn, "SELECT * FROM `orders` where id='$id'");

		// $stmt->execute(['id'=>$id]);
		$total = 0;
		if(mysqli_num_rows($shipping) > 0){
        while($fetch_shipping = mysqli_fetch_assoc($shipping)){
			// $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE sales_id=:id");
			// $stmt->execute(['id'=>$row['salesid']]);
			// $amount = 0;
			// $amount += $row['total'];
			// foreach($stmt as $details){
			// 	$subtotal = $details['price']*$details['quantity'];
			// 	$amount += $subtotal;
			// }
			// $total += $amount;
			$contents .= '
			<tr>
			

				<td>'.$fetch_shipping['name'].'</td>
				<td>'.$fetch_shipping['address'].'</td>
				<td>'.$fetch_shipping['shipping_status'].'</td>
				<td>'.$fetch_shipping['total_price'].'</td>
				

                           
			</tr>
			';
		}
	      }
	      $shipping = mysqli_query($conn, "SELECT * FROM `orders` where id='$id'");

	      if(mysqli_num_rows($shipping) > 0){
        while($fetch_shipping = mysqli_fetch_assoc($shipping)){

		$contents .= '
			<tr>
				<td colspan="3" align="right"><b>Total</b></td>
				<td>'.$fetch_shipping['total_price'].'</td>
				 <td align="right"><b>RM '.$fetch_shipping['total_price'].'</b></td>
			</tr>
		';}}
		return $contents;
	}

	if(isset($_POST['print'])){

		// $from = date('Y-m-d', strtotime($ex[0]));
		// $to = date('Y-m-d', strtotime($ex[1]));
		// $from_title = date('M d, Y', strtotime($ex[0]));
		$id = isset($_GET['id']);

		require_once('tcpdf/tcpdf.php');  
	    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
	    $pdf->SetCreator(PDF_CREATOR);  
	    $pdf->SetTitle('Shipping Info');  
	    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
	    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
	    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
	    $pdf->SetDefaultMonospacedFont('helvetica');  
	    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
	    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
	    $pdf->setPrintHeader(false);  
	    $pdf->setPrintFooter(false);  
	    $pdf->SetAutoPageBreak(TRUE, 10);  
	    $pdf->SetFont('helvetica', '', 11);  
	    $pdf->AddPage();  
	    $content = '';  
	    $content .= '
	      	<h2 align="center">Fahin Cat Supermarket</h2>
	      	<h4 align="center">SHIPPING INFORMATION</h4>
	      	<h4 align="center"></h4>
	      	<table border="1" cellspacing="0" cellpadding="3">  
	           <tr>  
	           		<th width="15%" align="center"><b>Name</b></th>
	                <th width="30%" align="center"><b>Address</b></th>
					<th width="40%" align="center"><b>Shipping Status</b></th>
					<th width="15%" align="center"><b>Amount</b></th>  
	           </tr>  
	      ';  
	    $content .= generateRow($id, $conn);  
	    $content .= '</table>';  
	    $pdf->writeHTML($content);  
	    $pdf->Output('shipping.pdf', 'I');

	}
	else{
		$_SESSION['error'] = 'Need date range to provide sales print';
		header('location: sales.php');
	}
?>