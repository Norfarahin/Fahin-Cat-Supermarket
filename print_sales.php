<?php
include 'config.php';

	function generateRow($from, $to, $conn){
		$contents = '';
	 	
		// $stmt = $conn->prepare("SELECT *, sum(totalPrice) as total, orders.id AS ordersid FROM orders LEFT JOIN users ON orders.user_id=users.id WHERE placed_on BETWEEN '$from' AND '$to' GROUP BY placed_on,user_id");
		$sales = mysqli_query($conn,"SELECT *, sum(total_price) as total,  orders.id AS ordersid FROM orders LEFT JOIN customer ON orders.user_id=customer.id WHERE placed_on BETWEEN '$from' AND '$to' GROUP BY placed_on,user_id") or die('query failed');

		
		$total = 0;
		if(mysqli_num_rows($sales) > 0){
        while($fetch_sales = mysqli_fetch_assoc($sales)){			// $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE sales_id=:id");
			// $stmt->execute(['id'=>$row['salesid']]);
			$amount = 0;
			$amount += $fetch_sales['total'];
			// foreach($stmt as $details){
			// 	$subtotal = $details['price']*$details['quantity'];
			// 	$amount += $subtotal;
			// }
			$total += $amount;
			$contents .= '
			<tr>
				<td>'.date('M d, Y', strtotime($fetch_sales['placed_on'])).'</td>
				<td>'.$fetch_sales['name'].'</td>
				<td>'.$fetch_sales['total_products'].'</td>
                        <td>RM '.number_format($fetch_sales['total'], 2).'</td>
			</tr>
			';
		}
			}

		$contents .= '
			<tr>
				<td colspan="4" align="right"><b>Total</b></td>
				<td align="right"><b>RM '.number_format($total, 2).'</b></td>
			</tr>
		';
		return $contents;
	}

	if(isset($_POST['print'])){
		$ex = explode(' - ', $_POST['date_range']);
		$from = date('Y-m-d', strtotime($ex[0]));
		$to = date('Y-m-d', strtotime($ex[1]));
		$from_title = date('M d, Y', strtotime($ex[0]));
		$to_title = date('M d, Y', strtotime($ex[1]));


		require_once('tcpdf/tcpdf.php');  
	    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
	    $pdf->SetCreator(PDF_CREATOR);  
	    $pdf->SetTitle('Sales Report: '.$from_title.' - '.$to_title);  
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
	      	<h4 align="center">SALES REPORT</h4>
	      	<h4 align="center">'.$from_title." - ".$to_title.'</h4>
	      	<table border="1" cellspacing="0" cellpadding="3">  
	           <tr>  
	           		<th width="15%" align="center"><b>Date</b></th>
	                <th width="15%" align="center"><b>Buyer Name</b></th>
	                <th width="25%" align="center"><b>Product List</b></th>
					<th width="25%" align="center"><b>Transaction</b></th>
					<th width="15%" align="center"><b>Amount</b></th>  
	           </tr>  
	      ';  
	    $content .= generateRow($from, $to, $conn);  
	    $content .= '</table>';  
	    $pdf->writeHTML($content);  
	    $pdf->Output('sales.pdf', 'I');

	}
	else{
		$_SESSION['error'] = 'Need date range to provide sales print';
		header('location: sales.php');
	}
?>