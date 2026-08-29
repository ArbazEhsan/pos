<?php 
include ('../connect.php');
$from = $_REQUEST['from'];
$operation = $_REQUEST['operation'];

if($from=='swsr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$product = $_POST['product'];
	$data = $data2 = ""; $sum = $sum2 = $gross = 0;
	$result = mysqli_query($con,"SELECT psale.barcode, products.name AS pname FROM psale INNER JOIN products ON psale.barcode=products.id WHERE customer='$product' GROUP BY barcode");
	while ($fetch=mysqli_fetch_array($result)) {
		$result2 = mysqli_query($con,"SELECT SUM(qty) AS sQty, SUM(price*qty) AS final FROM sale WHERE barcode='".$fetch['barcode']."'");
		$fetch2 = mysqli_fetch_array($result2);
		$sum += $fetch2['sQty'];
		$sum2 += $fetch2['final'];
		if ($fetch2['final']>0) {
			$price = $fetch2['final']/$fetch2['sQty'];
		}
		else {
			$price = 0;
		}
		$data.= "<tr>
			<td>".$fetch['barcode']."</td>
			<td>".$fetch['pname']."</td>
			<td>".number_format($price,2)."</td>
			<td>".number_format($fetch2['sQty'],2)."</td>
			<td>".number_format($fetch2['final'],2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='3' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
		</tr>";
	$result3 = mysqli_query($con,"SELECT name, city FROM accounts WHERE id='$product'");
	$fetch3 = mysqli_fetch_array($result3);
	$product = "A/C#".$_POST['product'].": ".$fetch3['name'].", ".$fetch3['city']."";
	$fromDate = date('d-m-Y',strtotime($fromDate));
	$toDate = date('d-m-Y',strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$product;
}

if($from=='pwsr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$product = $_POST['product'];
	$data = $data2 = ""; $sum = $sum2 = $gross = 0;
	$result = mysqli_query($con,"SELECT * FROM accounts WHERE type='Customer' AND active!='0'");
	while ($fetch=mysqli_fetch_array($result)) {
		$result2 = mysqli_query($con,"SELECT SUM(qty) AS sQty, SUM(price*qty) AS final FROM sale WHERE customer='".$fetch['id']."' AND barcode='$product' AND sale_day BETWEEN '$fromDate' AND '$toDate'");
		$fetch2 = mysqli_fetch_array($result2);
		$sum += $fetch2['sQty'];
		$sum2 += $fetch2['final'];
		if($fetch2['final']>0){
			$price = $fetch2['final']/$fetch2['sQty'];
		}
		else {
			$price = 0;
		}
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['city']."</td>
			<td>".number_format($price,2)."</td>
			<td>".number_format($fetch2['sQty'],2)."</td>
			<td>".number_format($fetch2['final'],2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='4' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
		</tr>";

	$result3 = mysqli_query($con,"SELECT name AS pname FROM products WHERE id='$product'");
	$fetch3 = mysqli_fetch_array($result3);
	$product = $fetch3['pname'];
	$fromDate = date('d-m-Y',strtotime($fromDate));
	$toDate = date('d-m-Y',strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$product;
}

if($from=='psdr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = $sql = ""; $gross = $final = 0;
	if(isset($_POST['product'])){
		$product = $_POST['product'];
		$sql = "SELECT sale.*, accounts.name, accounts.city, products.name AS pname FROM sale INNER JOIN accounts ON sale.customer=accounts.id INNER JOIN products ON sale.barcode=products.id WHERE sale.barcode='$product' AND sale.sale_day BETWEEN '$fromDate' AND '$toDate' ORDER BY sale.sale_day";
	}
	else {
		$sql = "SELECT sale.*, accounts.name, accounts.city, products.name AS pname FROM sale INNER JOIN accounts ON sale.customer=accounts.id INNER JOIN products ON sale.barcode=products.id WHERE sale.sale_day BETWEEN '$fromDate' AND '$toDate' ORDER BY sale.sale_day";
	}
	$result = mysqli_query($con,$sql);
	while ($fetch=mysqli_fetch_array($result)) {
		$gross = $fetch['qty']*$fetch['price'];
		$final = $gross-$fetch['discount'];
		$data.= "<tr>
			<td>".date('d-m-Y',strtotime($fetch['sale_day']))."</td>
			<td>".$fetch['sale_No']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['city']."</td>
			<td>".$fetch['barcode']."</td>
			<td>".$fetch['pname']."</td>
			<td>".number_format($fetch['price'],2)."</td>
			<td>".number_format($fetch['qty'],2)."</td>
			<td>".number_format($gross,2)."</td>
			<td>".number_format($fetch['discount'],2)."</td>
			<td>".number_format($final,2)."</td>
		</tr>";
	}
	$fromDate = date('d-m-Y',strtotime($fromDate));
	$toDate = date('d-m-Y',strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='pssr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$product = $_POST['product'];
	$data = $data2 = ""; $sum = $sum2 = $gross = 0;
	$result = mysqli_query($con,"SELECT accounts.id, accounts.name, sale.price, sale.qty, sale.finalValue, products.name AS pname, products.id AS pid FROM sale INNER JOIN accounts ON accounts.id=sale.customer INNER JOIN products ON sale.barcode=products.id WHERE accounts.city='$product' AND sale.sale_day BETWEEN '$fromDate' AND '$toDate'");
	while ($fetch=mysqli_fetch_array($result)) {
		$gross = $fetch['price']*$fetch['qty'];
		$sum += $fetch['qty'];
		$sum2 += $gross;
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['pid']."</td>
			<td>".$fetch['pname']."</td>
			<td>".number_format($fetch['price'],2)."</td>
			<td>".number_format($fetch['qty'],2)."</td>
			<td>".number_format($gross,2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='5' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
		</tr>";
	$fromDate = date('d-m-Y',strtotime($fromDate));
	$toDate = date('d-m-Y',strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$product;
}

if($from=='partywsr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$product = $_POST['product'];
	$data = $data2 = ""; $sum = $sum2 = $gross = 0;
	$result = mysqli_query($con,"SELECT sale.price, sale.qty, sale.finalValue, accounts.name, accounts.city, products.name AS pname, products.id FROM sale INNER JOIN accounts ON sale.customer=accounts.id INNER JOIN products ON sale.barcode=products.id WHERE sale.customer='$product' AND sale.sale_day BETWEEN '$fromDate' AND '$toDate' ORDER BY sale.sale_day");
	while ($fetch=mysqli_fetch_array($result)) {
		$gross = $fetch['qty']*$fetch['price'];
		$sum += $fetch['qty'];
		$sum2 += $gross;
		$product = "A/C#".$_POST['product'].": ".$fetch['name'].", ".$fetch['city']."";
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['pname']."</td>
			<td>".number_format($fetch['price'],2)."</td>
			<td>".number_format($fetch['qty'],2)."</td>
			<td>".number_format($gross,2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='3' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
		</tr>";
	$fromDate = date('d-m-Y',strtotime($fromDate));
	$toDate = date('d-m-Y',strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$product;
}

if($from=='sr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = $sql = ""; 
	if(isset($_POST['product'])){
		$product = $_POST['product'];
		$sql = "SELECT returnsale.*, rscounter.customer, rscounter.day, accounts.name, accounts.city, products.name AS pname FROM returnsale INNER JOIN rscounter ON returnsale.sale_No=rscounter.id INNER JOIN accounts ON rscounter.customer=accounts.id INNER JOIN products ON returnsale.barcode=products.id WHERE returnsale.barcode='$product' AND rscounter.day BETWEEN '$fromDate' AND '$toDate' ORDER BY rscounter.day";
	}
	else {
		$sql = "SELECT returnsale.*, rscounter.customer, rscounter.day, accounts.name, accounts.city, products.name AS pname FROM returnsale INNER JOIN rscounter ON returnsale.sale_No=rscounter.id INNER JOIN accounts ON rscounter.customer=accounts.id INNER JOIN products ON returnsale.barcode=products.id WHERE rscounter.day BETWEEN '$fromDate' AND '$toDate' ORDER BY rscounter.day";
	}
	$result = mysqli_query($con,$sql);
	while ($fetch=mysqli_fetch_array($result)) {
		$gross = $fetch['qty']*$fetch['price'];
		$data.= "<tr>
			<td>".date('d-m-Y',strtotime($fetch['day']))."</td>
			<td>".$fetch['sale_No']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['city']."</td>
			<td>".$fetch['barcode']."</td>
			<td>".$fetch['pname']."</td>
			<td>".number_format($fetch['price'],2)."</td>
			<td>".number_format($fetch['qty'],2)."</td>
			<td>".number_format($gross,2)."</td>
		</tr>";
	}
	$fromDate = date('d-m-Y',strtotime($fromDate));
	$toDate = date('d-m-Y',strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

/* Sales Report end */

/* Purchase Report Start */
if($from=='swpr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$product = $_POST['product'];
	$data = $data2 = ""; $sum = $sum2 = $gross = 0;
	$result = mysqli_query($con,"SELECT accounts.id, accounts.name, psale.price, psale.qty, psale.finalValue, products.name AS pname, products.id AS pid FROM psale INNER JOIN accounts ON psale.customer=accounts.id INNER JOIN products ON psale.barcode=products.id WHERE accounts.city='$product' AND psale.sale_day BETWEEN '$fromDate' AND '$toDate'");
	while ($fetch=mysqli_fetch_array($result)) {
		$gross = $fetch['price']*$fetch['qty'];
		$sum += $fetch['qty'];
		$sum2 += $gross;
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['pid']."</td>
			<td>".$fetch['pname']."</td>
			<td>".number_format($fetch['price'],2)."</td>
			<td>".number_format($fetch['qty'],2)."</td>
			<td>".number_format($gross,2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='5' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
		</tr>";
	$fromDate = date('d-m-Y',strtotime($fromDate));
	$toDate = date('d-m-Y',strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$product;
}

if($from=='pwpr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$product = $_POST['product'];
	$data = $data2 = ""; $sum = $sum2 = $gross = 0;
	$result = mysqli_query($con,"SELECT * FROM accounts WHERE type='Vendor' AND active!='0'");
	while ($fetch=mysqli_fetch_array($result)) {
		$result2 = mysqli_query($con,"SELECT SUM(qty) AS sQty, SUM(price*qty) AS final FROM psale WHERE customer='".$fetch['id']."' AND barcode='$product' AND sale_day BETWEEN '$fromDate' AND '$toDate'");
		$fetch2 = mysqli_fetch_array($result2);
		$sum += $fetch2['sQty'];
		$sum2 += $fetch2['final'];
		if($fetch2['final']>0){
			$price = $fetch2['final']/$fetch2['sQty'];
		}
		else {
			$price = 0;
		}
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['city']."</td>
			<td>".number_format($price,2)."</td>
			<td>".number_format($fetch2['sQty'],2)."</td>
			<td>".number_format($fetch2['final'],2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='4' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
		</tr>";
	$result3 = mysqli_query($con,"SELECT name AS pname FROM products WHERE id='$product'");
	$fetch3 = mysqli_fetch_array($result3);
	$product = $fetch3['pname'];
	$fromDate = date('d-m-Y',strtotime($fromDate));
	$toDate = date('d-m-Y',strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$product;
}

if($from=='partywpr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$product = $_POST['product'];
	$data = $data2 = ""; $sum = $sum2 = $gross = 0;
	$result = mysqli_query($con,"SELECT psale.price, psale.qty, psale.finalValue, accounts.name, accounts.city, products.name AS pname, products.id FROM psale INNER JOIN accounts ON psale.customer=accounts.id INNER JOIN products ON psale.barcode=products.id WHERE psale.customer='$product' AND psale.sale_day BETWEEN '$fromDate' AND '$toDate' ORDER BY psale.sale_day");
	while ($fetch=mysqli_fetch_array($result)) {
		$gross = $fetch['qty']*$fetch['price'];
		$sum += $fetch['qty'];
		$sum2 += $gross;
		$product = "A/C#".$_POST['product'].": ".$fetch['name'].", ".$fetch['city']."";
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['pname']."</td>
			<td>".number_format($fetch['price'],2)."</td>
			<td>".number_format($fetch['qty'],2)."</td>
			<td>".number_format($gross,2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='3' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
		</tr>";
	$fromDate = date('d-m-Y',strtotime($fromDate));
	$toDate = date('d-m-Y',strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$product;
}

if($from=='partywlpr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$product = $_POST['product'];
	$data = $data2 = ""; $sum = $sum2 = $gross = 0;
	$result = mysqli_query($con,"SELECT psale.price, psale.qty, psale.finalValue, accounts.name, accounts.city, products.name AS pname, products.id FROM psale INNER JOIN accounts ON psale.customer=accounts.id INNER JOIN products ON psale.barcode=products.id WHERE psale.customer='$product' AND psale.id=(SELECT max(psale.id) FROM psale) ORDER BY psale.sale_day");
	while ($fetch=mysqli_fetch_array($result)) {
		$gross = $fetch['qty']*$fetch['price'];
		$sum += $fetch['qty'];
		$sum2 += $gross;
		$product = "A/C#".$_POST['product'].": ".$fetch['name'].", ".$fetch['city']."";
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['pname']."</td>
			<td>".number_format($fetch['price'],2)."</td>
			<td>".number_format($fetch['qty'],2)."</td>
			<td>".number_format($gross,2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='3' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
		</tr>";
	$fromDate = date('d-m-Y',strtotime($fromDate));
	$toDate = date('d-m-Y',strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$product;
}

if($from=='pr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = $sql = ""; 
	if(isset($_POST['product'])){
		$product = $_POST['product'];
		$sql = "SELECT returnsale.*, rpcounter.customer, rpcounter.day, accounts.name, accounts.city, products.name AS pname FROM returnsale INNER JOIN rpcounter ON returnsale.sale_No=rpcounter.id INNER JOIN accounts ON rpcounter.customer=accounts.id INNER JOIN products ON returnsale.barcode=products.id WHERE returnsale.barcode='$product' AND rpcounter.day BETWEEN '$fromDate' AND '$toDate' ORDER BY rpcounter.day";
	}
	else {
		$sql = "SELECT returnsale.*, rpcounter.customer, rpcounter.day, accounts.name, accounts.city, products.name AS pname FROM returnsale INNER JOIN rpcounter ON returnsale.sale_No=rpcounter.id INNER JOIN accounts ON rpcounter.customer=accounts.id INNER JOIN products ON returnsale.barcode=products.id WHERE rpcounter.day BETWEEN '$fromDate' AND '$toDate' ORDER BY rpcounter.day";
	}
	$result = mysqli_query($con,$sql);
	while ($fetch=mysqli_fetch_array($result)) {
		$gross = $fetch['qty']*$fetch['price'];
		$data.= "<tr>
			<td>".date('d-m-Y',strtotime($fetch['day']))."</td>
			<td>".$fetch['pur_No']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['city']."</td>
			<td>".$fetch['barcode']."</td>
			<td>".$fetch['pname']."</td>
			<td>".number_format($fetch['price'],2)."</td>
			<td>".number_format($fetch['qty'],2)."</td>
			<td>".number_format($gross,2)."</td>
		</tr>";
	}
	$fromDate = date('d-m-Y',strtotime($fromDate));
	$toDate = date('d-m-Y',strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

/* purchase report end */

/* accounts report start */
if($from=='pdr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = $data2 = $sql = "";
	$counter = $sum = 0;
	if (isset($_POST['product'])) {
		$product = $_POST['product'];
		$sql = "SELECT accounts.id, accounts.name, accounts.city, accounts.type FROM accounts WHERE id='$product' AND active!='0' ORDER BY id";
	}
	else {
		$sql = "SELECT accounts.id, accounts.name, accounts.city, accounts.type FROM accounts WHERE type='Customer' OR type='Vendor' AND active!='0' ORDER BY id";
	}
	$result = mysqli_query($con,$sql);
	while ($fetch=mysqli_fetch_array($result)) {
		$balance = 0;$total = "";
		$counter++;
		$result2 = mysqli_query($con,"SELECT SUM(cr) AS cr, SUM(dr) AS dr FROM ledgers WHERE account_id='".$fetch['id']."'");
		$fetch2 = mysqli_fetch_array($result2);
		$balance = $fetch2['dr']-$fetch2['cr'] + 0;
		
		if($balance>0){
			$balance = 0;
		}
		$sum += abs($balance);
		$data.= "<tr>
			<td>".$counter."</td>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['city']."</td>
			<td>".number_format(abs($balance),2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='4' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td> 
		</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$data2;
}

if($from=='rdr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = $data2 = $sql = "";
	$counter = $payable = $sum = 0;
	if (isset($_POST['product'])) {
		$product = $_POST['product'];
		$sql = "SELECT accounts.id, accounts.name, accounts.city, accounts.type FROM accounts WHERE id='$product' AND active!='0' ORDER BY id";
	}
	else {
		$sql = "SELECT accounts.id, accounts.name, accounts.city, accounts.type FROM accounts WHERE type='Customer' OR type='Vendor' AND active!='0' ORDER BY id";
	}
	$result = mysqli_query($con,$sql);
	while ($fetch=mysqli_fetch_array($result)) {
		$balance = 0; $total = "";
		$counter++;
		$result2 = mysqli_query($con,"SELECT SUM(cr) AS cr, SUM(dr) AS dr FROM ledgers WHERE account_id='".$fetch['id']."'");
		$fetch2 = mysqli_fetch_array($result2);
		$balance = $fetch2['dr']-$fetch2['cr'] + 0;
		if($balance<0){
			$balance = 0;
		}
		$sum += abs($balance);
		$data.= "<tr>
			<td>".$counter."</td>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['city']."</td>
			<td>".number_format(abs($balance),2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='4' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td> 
		</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$data2;
}

if($from=='pcsr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	// $product = $_POST['product'];
	$data = $data2 = "";
	$counter = $inv = $sum = 0;
	$result = mysqli_query($con,"SELECT trans.*, accounts.name FROM trans INNER JOIN accounts ON trans.account_id=accounts.id WHERE trans.day BETWEEN '$fromDate' AND '$toDate' AND trans.type='CR' OR trans.type='SV' ORDER BY trans.day");
	while ($fetch=mysqli_fetch_array($result)) {
		$counter++;
		if($fetch['type']=='SV'){
			$inv = $fetch['invoice_id'];
		}
		else {
			$inv = $fetch['id'];
		}
		$sum += $fetch['amount'];
		$data.= "<tr>
			<td>".$counter."</td>
			<td>".date("d-m-Y", strtotime($fetch['day']))."</td>
			<td>".$inv."</td>
			<td>".$fetch['account_id']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['remarks']."</td>
			<td>".number_format($fetch['amount'],2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='6' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td> 
		</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='pcpsr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	// $product = $_POST['product'];
	$data = "";
	$counter = $inv = $sum = 0;
	$result = mysqli_query($con,"SELECT trans.*, accounts.name FROM trans INNER JOIN accounts ON trans.account_id=accounts.id WHERE trans.day BETWEEN '$fromDate' AND '$toDate' AND trans.type='CO' OR trans.type='PV' ORDER BY trans.day");
	while ($fetch=mysqli_fetch_array($result)) {
		$counter++;
		if($fetch['type']=='PV'){
			$inv = $fetch['invoice_id'];
		}
		else {
			$inv = $fetch['id'];
		}
		$sum += $fetch['amount'];
		$data.= "<tr>
			<td>".$counter."</td>
			<td>".date("d-m-Y", strtotime($fetch['day']))."</td>
			<td>".$inv."</td>
			<td>".$fetch['account_id']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['remarks']."</td>
			<td>".number_format($fetch['amount'],2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='6' style='text-align: right;'><b>Grand Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td> 
		</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='palr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	// $product = $_POST['product'];
	$data = $gsProfittxt = $opIncometxt = ""; $totalSQty = $totalS = $totalPQty = $totalP = $gsProfit = $totalExpense = $opIncome = 0;
	$sql = "SELECT products.name, products.id FROM products WHERE active!='0'";
	$sql2 = "SELECT accounts.name, accounts.id FROM accounts WHERE type='Expense'";
	$data.= "<tr>
			<td colspan='4' class='font-bold'>Sales</td>
			</tr>";
	$result = mysqli_query($con,$sql);
	while ($fetch=mysqli_fetch_array($result)) {
		$result2 = mysqli_query($con,"SELECT SUM(qty) AS saleQty, SUM(price*qty) AS final FROM sale WHERE barcode='".$fetch['id']."' AND sale_day BETWEEN '$fromDate' AND '$toDate'");
		$fetch2=mysqli_fetch_array($result2);
		$totalSQty += $fetch2['saleQty'];
		$totalS += $fetch2['final'];
		if ($fetch2['final']>0) {
			$sPrice = $fetch2['final']/$fetch2['saleQty'];
			$data.= "<tr>
		 		<td>".$fetch['name']."</td>
		 		<td class='align'>".number_format($fetch2['saleQty'],2)."</td>
				<td class='align'>".number_format($fetch2['final'],2)."</td>
				<td class='align'>".number_format($sPrice,2)."</td>
		 		</tr>";
		}
		else {
			$sPrice = 0;
		}
		
	}
	$data.= "<tr>
			<td class='align-center font-bold'>Total Sale</td>
			<td class='align border' style='border-top: 1px solid black;'>".number_format($totalSQty,2)."</td>
			<td class='align border' style='border-top: 1px solid black;'>".number_format($totalS,2)."</td>
			<td></td>
			</tr>
			<tr>
			<td colspan='4' class='font-bold'>Purchases</td>
			</tr>";
	$result3 = mysqli_query($con,$sql);
	while ($fetch3=mysqli_fetch_array($result3)) {
		$result4 = mysqli_query($con,"SELECT SUM(qty) AS psaleQty, SUM(qty*price) AS final FROM psale WHERE barcode='".$fetch3['id']."' AND sale_day BETWEEN '$fromDate' AND '$toDate'");
		$fetch4=mysqli_fetch_array($result4);
		$totalPQty += $fetch4['psaleQty'];
		$totalP += $fetch4['final'];
		if($fetch4['final']>0){
			$pPrice = $fetch4['final']/$fetch4['psaleQty'];
			$data.= "<tr>
		 		<td>".$fetch3['name']."</td>
		 		<td class='align'>".number_format($fetch4['psaleQty'],2)."</td>
				<td class='align'>".number_format($fetch4['final'],2)."</td>
				<td class='align'>".number_format($pPrice,2)."</td>
		 		</tr>";
		} 
		else {
			$pPrice = 0;
		}
		
		
	}
	$data.= "<tr>
			<th class='align-center'>Total Purchases</th>
			<td class='align border' style='border-top: 1px solid black;'>".number_format($totalPQty,2)."</td>
			<td class='align border' style='border-top: 1px solid black;'>".number_format($totalP,2)."</td>
			<td class='align'></td>
			</tr>";
	$gsProfit = $totalS - $totalP;
	$gsProfittxt = number_format(abs($gsProfit),2);
	if ($gsProfit<0) {
		$gsProfittxt = '('.number_format(abs($gsProfit),2).')';
	}
	$data.="<tr>
			<td class='align-center font-bold'>Gross Profit</td>
			<td></td>
			<td class='align border'>".$gsProfittxt."</td>
			<td class='align'></td>
			</tr>
			<tr>
			<td class='font-bold' colspan='4'>Operating Expense</td>
			</tr>";

	$result5 = mysqli_query($con,$sql2);
	while ($fetch5=mysqli_fetch_array($result5)) {
		$result6 = mysqli_query($con,"SELECT SUM(amount) AS expenseAmnt FROM trans WHERE account_id='".$fetch5['id']."' AND day BETWEEN '$fromDate' AND '$toDate'");
		$fetch6=mysqli_fetch_array($result6);
		$totalExpense += $fetch6['expenseAmnt'];
		$data.="<tr>
				<td>".$fetch5['name']."</td>
				<td class='align'></td>
				<td class='align'>".number_format($fetch6['expenseAmnt'],2)."</td>
				<td class='align'></td>
				</tr>";
	}
	$opIncome = $gsProfit - $totalExpense;
	$opIncometxt = number_format(abs($opIncome),2);
	if ($opIncome<0) {
		$opIncometxt = '('.number_format(abs($opIncome),2).')';
	}
	$data.="<tr>
			<td class='align-center font-bold'>Total Operating Expenses</td>
			<td class='align'></td>
			<td class='align border' style='border-top: 1px solid black;'>".number_format($totalExpense,2)."</td>
			<td class='align'></td>
			</tr>
			<tr>
			<td class='align-center font-bold'>Operating Income</td>
			<td></td>
			<td class='align border'>".$opIncometxt."</td>
			<td class='align'></td>
			</tr>
			<tr>
			<td class='align-center border font-bold'>Net Income</td>
			<td class='align border'></td>
			<td class='align border'>".$opIncometxt."</td>
			<td class='align border'></td>
			</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='cb' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	// $product = $_POST['product'];
	$data = ""; $bal = $sum = $sum2 = $sum3 = $inv = 0;
	$result = mysqli_query($con,"SELECT ledgers.*, trans.invoice_id, trans.bill_no, trans.remarks, accounts.name  FROM ledgers INNER JOIN trans ON ledgers.trans_id=trans.id INNER JOIN accounts ON ledgers.account_id=accounts.id WHERE ledgers.day BETWEEN '$fromDate' AND '$toDate'");
	while ($fetch=mysqli_fetch_array($result)) {
		$sum += $fetch['dr'];
		$sum2 += $fetch['cr'];
		if($fetch['invoice_id']>0){
			$inv = $fetch['invoice_id'];
		}
		else {
			$inv = $fetch['bill_no'];
		}
		$data.= "<tr>
				<td>".date("d-m-Y", strtotime($fetch['day']))."</td>
				<td>".$fetch['type']."-".$inv."</td>
				<td>".$fetch['account_id']."</td>
				<td>".$fetch['name']."</td>
				<td>".$fetch['remarks']."</td>
				<td>".number_format($fetch['dr'],2)."</td>
				<td>".number_format($fetch['cr'],2)."</td>
		</tr>";
	}
	$data.="<tr>
			<td colspan='5' style='text-align: right;'><b>Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
		</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='dt' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	// $product = $_POST['product'];
	$data = $data2 = ""; $bal = $sum = $sum2 = $sum3= 0;
	$result = mysqli_query($con,"SELECT * FROM trans WHERE type='CR' OR type='CO'");
	while ($fetch=mysqli_fetch_array($result)) {
		$amnt = $amnt2 = 0;
		if($fetch['type']=='CR'){
			$amnt = $fetch['amount'];
			$bal += $fetch['amount'];
			$sum += $fetch['amount'];
		} else {
			$amnt2 = $fetch['amount'];
			$bal -= $fetch['amount'];
			$sum2 += $fetch['amount'];
		}
		$sum3 = $bal;
		$data.= "<tr>
			<td>".date("d-m-Y", strtotime($fetch['day']))."</td>
			<td>".$fetch['remarks']."</td>
			<td>".number_format($amnt,2)."</td>
			<td>".number_format($amnt2,2)."</td>
			<td>".number_format($bal,2)."</td>
		</tr>";
	}
	$data.="<tr>
			<td colspan='2' style='text-align: right;'><b>Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
			<td style='border:2px solid black'>".number_format($sum3,2)."</td>
		</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='tb' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = ""; $counter = $sum = 0;
	if (isset($_POST['product'])) {
		$product = $_POST['product'];
		$sql = "SELECT accounts.id, accounts.name, accounts.city, accounts.type FROM accounts WHERE active!='0' AND id='$product' ORDER BY id";
	}
	else {
		$sql = "SELECT accounts.id, accounts.name, accounts.city, accounts.type FROM accounts WHERE active!='0' AND type='Customer' OR type='Vendor' ORDER BY id";
	}

	$result = mysqli_query($con,$sql);
	while($fetch = mysqli_fetch_array($result)){
		$balance = 0;$total = "";
		$counter++;
		$result2 = mysqli_query($con,"SELECT SUM(cr) AS cr, SUM(dr) AS dr FROM ledgers WHERE account_id='".$fetch['id']."'");
		$fetch2 = mysqli_fetch_array($result2);
		$balance = $fetch2['dr']-$fetch2['cr'] + 0;
		$sum += abs($balance); 
		if($fetch['type']=='Vendor'){
			if($balance<0){
				$txt = " CR";
			} else {
				$txt = " DR";
			} 
		}
		else {
			if($balance>0){
				$txt = " DR";
			} else {
				$txt = " CR";
			}
		}
		$data.= "<tr>
			<td>".$counter."</td>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['city']."</td>
			<td style='text-align:right'>".number_format(abs($balance),2).$txt."</td>
		</tr>";
	}
	$data.="<tr>
			<td colspan='4' style='text-align: right;'><b>Total</b></td>
			<td style='border:2px solid black;text-align:right'>".number_format($sum,2)."</td>
		</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='tbbh' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = ""; $counter = $sum = 0;
	$product = $_POST['product'];
	$result = mysqli_query($con,"SELECT accounts.id, accounts.name, accounts.city, accounts.type FROM accounts WHERE active!='0' AND type='$product' ORDER BY id");
	while($fetch = mysqli_fetch_array($result)){
		$balance = 0;$total = "";
		$counter++;
		$result2 = mysqli_query($con,"SELECT SUM(cr) AS cr, SUM(dr) AS dr FROM ledgers WHERE account_id='".$fetch['id']."'");
		$fetch2 = mysqli_fetch_array($result2);
		$balance = $fetch2['dr']-$fetch2['cr'] + 0;
		$sum += abs($balance); 
		if($fetch['type']=='Vendor'){
			if($balance<0){
				$txt = " CR";
			} else {
				$txt = " DR";
			} 
		}
		else {
			if($balance>0){
				$txt = " DR";
			} else {
				$txt = " CR";
			}
		}
		$data.= "<tr>
			<td>".$counter."</td>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['city']."</td>
			<td style='text-align:right'>".number_format(abs($balance),2).$txt."</td>
		</tr>";
	}
	$data.="<tr>
			<td colspan='4' style='text-align: right;'><b>Total</b></td>
			<td style='border:2px solid black;text-align:right'>".number_format($sum,2)."</td>
		</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$product;
}

if($from=='coa' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	// $product = $_POST['product'];
	$data = "";
	$accountType = array('Asset','Capital','Customer','Expense','Liability','Vendor');
	for ($i=0; $i<count($accountType);$i++) { 
		$data.="<tr>
			<th colspan='8'style='text-align:center;'>".$accountType[$i]."</th>
			</tr>";
		$result = mysqli_query($con,"SELECT * FROM accounts WHERE active!='0' AND type='".$accountType[$i]."'");
		while($fetch=mysqli_fetch_array($result)) {
			$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".$fetch['city']."</td>
			</tr>";
		}
	}
	$fromDate = date('d-m-Y', strtotime($fromDate));
	$toDate = date('d-m-Y', strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='coabh' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$product = $_POST['product'];
	$data = "";
	$result = mysqli_query($con,"SELECT * FROM accounts WHERE active!='0' AND type='$product'");
	while($fetch=mysqli_fetch_array($result)) {
		$data.= "<tr>
		<td>".$fetch['id']."</td>
		<td>".$fetch['name']."</td>
		<td>".$fetch['city']."</td>
		</tr>";
	}
	$fromDate = date('d-m-Y', strtotime($fromDate));
	$toDate = date('d-m-Y', strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$product;
}

if($from=='pv' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	// $product = $_POST['product'];
	$data = ""; $bal = $sum = $sum2 = 0;
	$result = mysqli_query($con,"SELECT ledgers.*, trans.invoice_id, trans.bill_no, trans.remarks, accounts.name  FROM ledgers INNER JOIN trans ON ledgers.trans_id=trans.id INNER JOIN accounts ON ledgers.account_id=accounts.id WHERE ledgers.type!='CO' AND ledgers.type!='CR' AND ledgers.day BETWEEN '$fromDate' AND '$toDate'");
	while ($fetch=mysqli_fetch_array($result)) {
		$sum += $fetch['dr'];
		$sum2 += $fetch['cr'];
		$inv = $fetch['invoice_id'];
		$data.= "<tr>
				<td>".date("d-m-Y", strtotime($fetch['day']))."</td>
				<td>".$fetch['type']."-".$inv."</td>
				<td>".$fetch['account_id']."</td>
				<td>".$fetch['name']."</td>
				<td>".$fetch['remarks']."</td>
				<td>".number_format($fetch['dr'],2)."</td>
				<td>".number_format($fetch['cr'],2)."</td>
		</tr>";
	}
	$data.="<tr>
			<td colspan='5' style='text-align: right;'><b>Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
		</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='vsbt' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$product = $_POST['product'];
	$data = ""; $bal = $sum = $sum2 = 0;
	$result = mysqli_query($con,"SELECT ledgers.*, trans.invoice_id, trans.bill_no, trans.remarks, accounts.name  FROM ledgers INNER JOIN trans ON ledgers.trans_id=trans.id INNER JOIN accounts ON ledgers.account_id=accounts.id WHERE ledgers.type='$product' AND ledgers.day BETWEEN '$fromDate' AND '$toDate'");
	while ($fetch=mysqli_fetch_array($result)) {
		$sum += $fetch['dr'];
		$sum2 += $fetch['cr'];
		$inv = $fetch['invoice_id'];
		$data.= "<tr>
				<td>".date("d-m-Y", strtotime($fetch['day']))."</td>
				<td>".$fetch['type']."-".$inv."</td>
				<td>".$fetch['account_id']."</td>
				<td>".$fetch['name']."</td>
				<td>".$fetch['remarks']."</td>
				<td>".number_format($fetch['dr'],2)."</td>
				<td>".number_format($fetch['cr'],2)."</td>
		</tr>";
	}
	$data.="<tr>
			<td colspan='5' style='text-align: right;'><b>Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
			<td style='border:2px solid black'>".number_format($sum2,2)."</td>
		</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate."|".$product;
}

if($from=='acb' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = ""; $counter = $sum = 0;
	if (isset($_POST['product'])) {
		$product = $_POST['product'];
		$sql = "SELECT accounts.id, accounts.name, accounts.type FROM accounts WHERE active!='0' AND id='$product' ORDER BY id";
	}
	else {
		$sql = "SELECT accounts.id, accounts.name, accounts.type FROM accounts WHERE active!='0' AND type='Customer' OR type='Vendor' ORDER BY id";
	}

	$result = mysqli_query($con,$sql);
	while($fetch = mysqli_fetch_array($result)){
		$balance = 0;$total = "";
		$counter++;
		$result2 = mysqli_query($con,"SELECT SUM(cr) AS cr, SUM(dr) AS dr FROM ledgers WHERE account_id='".$fetch['id']."'");
		$fetch2 = mysqli_fetch_array($result2);
		$balance = $fetch2['dr']-$fetch2['cr'] + 0;
		$sum += abs($balance); 
		if($fetch['type']=='Vendor'){
			if($balance<0){
				$txt = " CR";
			} else {
				$txt = " DR";
			} 
		}
		else {
			if($balance>0){
				$txt = " DR";
			} else {
				$txt = " CR";
			}
		}
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td style='text-align:right'>".number_format(abs($balance),2).$txt."</td>
		</tr>";
	}
	$data.="<tr>
			<td colspan='2' style='text-align: right;'><b>Total</b></td>
			<td style='border:2px solid black;text-align:right'>".number_format($sum,2)."</td>
		</tr>";
	$fromDate =	date("d-m-Y", strtotime($fromDate));
	$toDate = date("d-m-Y", strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

/* accounts report end */

/* stock report start */

if($from=='pvr' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = $data2 = ""; $sum = $qty = 0;
	if(isset($_POST['product'])){
		$product = $_POST['product'];
		$sql = "SELECT products.id, products.name, products.shQty FROM products WHERE id='$product' ORDER BY name";
	}
	else {
		$sql = "SELECT products.id, products.name, products.shQty FROM products ORDER BY name";
	}
	$result = mysqli_query($con,$sql);
	while ($fetch=mysqli_fetch_array($result)) {
		$amnt = 0;
		$result1 = mysqli_query($con,"SELECT AVG(price) AS sprice FROM sale WHERE barcode='".$fetch['id']."'");
		$fetch1 = mysqli_fetch_array($result1);
		$result2 = mysqli_query($con,"SELECT AVG(price) AS pprice FROM psale WHERE barcode='".$fetch['id']."'");
		$fetch2 = mysqli_fetch_array($result2);
		if ($fetch['shQty']>0) {
			$qty = $fetch['shQty'];
		}
		$amnt = ($fetch1['sprice']*$qty) - ($fetch2['pprice']*$qty);
		$sum += $amnt;
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".number_format($fetch2['pprice'],2)."</td>
			<td>".number_format($qty,2)."</td>
			<td>".number_format($fetch1['sprice'],2)."</td>
			<td>".number_format($amnt,2)."</td>
		</tr>";
	}
	$data.= "<tr>
			<td colspan='5' style='text-align: right;'><b>Total</b></td>
			<td style='border:2px solid black'>".number_format($sum,2)."</td>
		</tr>";
	$fromDate = date('d-m-Y', strtotime($fromDate));
	$toDate = date('d-m-Y', strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='psir' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = $sql = ""; $qty = 0;
	if (isset($_POST['product'])) {
		$product = $_POST['product'];
		$sql = "SELECT * FROM products WHERE active!='0' AND id='$product' ORDER BY name";
	}
	else {
		$sql = "SELECT * FROM products WHERE active!='0' ORDER BY name";
	}
	$result = mysqli_query($con,$sql);
	while ($fetch=mysqli_fetch_array($result)) {
		if($fetch['shQty']<0){
			$qty = 0;
		}
		else {
			$qty = $fetch['shQty'];
		}
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".number_format($qty,2)."</td>
		</tr>";
	}
	$fromDate = date('d-m-Y', strtotime($fromDate));
	$toDate = date('d-m-Y', strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='psor' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = $sql = ""; $qty = 0;
	if (isset($_POST['product'])) {
		$product = $_POST['product'];
		$sql = "SELECT * FROM products WHERE active!='0' AND id='$product' ORDER BY name";
	}
	else {
		$sql = "SELECT * FROM products WHERE active!='0' ORDER BY name";
	}
	$result = mysqli_query($con,$sql);
	while ($fetch=mysqli_fetch_array($result)) {
		if($fetch['shQty']>0){
			$qty = 0;
		}
		else {
			$qty = abs($fetch['shQty']);
		}
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".number_format($qty,2)."</td>
		</tr>";
	}
	$fromDate = date('d-m-Y', strtotime($fromDate));
	$toDate = date('d-m-Y', strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}

if($from=='psior' && $operation=='show'){
	$fromDate = $_POST['fromDate'];
	$toDate = $_POST['toDate'];
	$data = $sql = "";
	if (isset($_POST['product'])) {
		$product = $_POST['product'];
		$sql = "SELECT * FROM products WHERE active!='0' AND id='$product' ORDER BY name";
	}
	else {
		$sql = "SELECT * FROM products WHERE active!='0' ORDER BY name";
	}
	$result = mysqli_query($con,$sql);
	while ($fetch=mysqli_fetch_array($result)) {
		$qty = $qty2 = 0;
		if($fetch['shQty']>0){
			$qty = $fetch['shQty'];
		}
		else {
			$qty2 = abs($fetch['shQty']);
		}
		$data.= "<tr>
			<td>".$fetch['id']."</td>
			<td>".$fetch['name']."</td>
			<td>".number_format($qty,2)."</td>
			<td>".number_format($qty2,2)."</td>
		</tr>";
	}
	$fromDate = date('d-m-Y', strtotime($fromDate));
	$toDate = date('d-m-Y', strtotime($toDate));
	echo $data."|".$fromDate."|".$toDate;
}
/* stock report ends */
?>