<?php 
session_start();
include ('../connect.php');
include("../converter.php");
$from = $_REQUEST['from'];
$operation = $_REQUEST['operation'];

/* Sale Invoices Start */

if($from=='saleInvoice' && $operation=='insert'){
	
	$sale_day = $_POST['sale_day'];
	$bilty_No = $_POST['bilty_No'];
	$reference = $_POST['reference'];
	$customer = $_POST['customer'];
	$product = $_POST['product'];
	$qty = $_POST['qty'];
	$price = $_POST['price'];
	$pprice = $_POST['pprice'];
	$total = $_POST['total'];
	$gross = $_POST['gross'];
	$InvDiscount = $_POST['InvDiscount'];
	$grandTotal = $_POST['grandTotal'];
	$received = $_POST['received'];
	$remaining = $_POST['remaining'];

	$menuSaleType = $_POST['menuSaleType'];
	$custName = $_POST['custName'];
	$custPhone = $_POST['custPhone'];
	$custAddress = $_POST['custAddress'];
	$type = "Customer";
	$designation = "Customer";
	$salary = "";
    $contact = $custPhone;
    $phone1 = "";
    $phone2 = "";
    $city = "";
    $address = $custAddress;

    $result8 = mysqli_query($con,"SELECT * FROM accounts WHERE contact='$contact'");
	$fetch8 = mysqli_fetch_array($result8);
	if(mysqli_num_rows($result8)>0){
		$customer = $fetch8['id'];
	} else {
		mysqli_query($con,"INSERT INTO accounts (name,designation,salary,contact,phone1,phone2,city,type,address,active) VALUES('$custName','$designation','$salary','$contact','$phone1','$phone2','$city','$type','$address','1')");
		$customer = mysqli_insert_id($con);
	}

	mysqli_query($con,"INSERT INTO `scounter`(`bilty_No`, `referal`, `customer`,`sale_day`) VALUES ('$bilty_No','$reference','$customer','$sale_day')");
 	$master=mysqli_insert_id($con);

 	foreach ($product  as $key => $value) {

 		mysqli_query($con,"INSERT INTO `sale`(`sale_No`, `barcode`, `qty`, `price`, `grossId`, `discount`, `finalValue`, `received`, `remaining`,`sale_day`,`customer`,`purchase_Price`,`profit`) VALUES ('$master','$product[$key]','$qty[$key]','$price[$key]','$gross','$InvDiscount','$grandTotal','$received','$remaining','$sale_day','$customer','$pprice[$key]','0')");
 	
 		mysqli_query($con,"UPDATE products SET shQty=shQty-'$qty[$key]' WHERE id='$product[$key]'"); 
 		
 		$result = mysqli_query($con,"SELECT * FROM products WHERE id='$product[$key]'");
 		$fetch = mysqli_fetch_array($result);
	 	if ($fetch['shQty']<$fetch['minQ']) {
	 		mysqli_query($con,"UPDATE products SET reorder='1' WHERE id='$product[$key]'");
	 	}
 	}

 	mysqli_query($con,"INSERT INTO `trans`(`day`, `account_id`, `invoice_id`, `amount`, `type`, `remarks`, `status`)VALUES('$sale_day','$customer','$master','$received','SV','$reference','1')");
	$master2 = mysqli_insert_id($con);

 	mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$grandTotal','$sale_day','SV','$customer','$master2','1')");

	if($received>0){
	   mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$received','$sale_day','SV','$customer','$master2','1')");
	}

	echo $master;
}

if($from=='saleInvoice' && $operation=='update'){
	
	$orderno = $_POST['orderno'];
	$sale_day = $_POST['sale_day'];
	$bilty_No = $_POST['bilty_No'];
	$reference = $_POST['reference'];
	$customer = $_POST['customer'];
	$product = $_POST['product'];
	$qty = $_POST['qty'];
	$price = $_POST['price'];
	$pprice = $_POST['pprice'];
	$total = $_POST['total'];
	$gross = $_POST['gross'];
	$InvDiscount = $_POST['InvDiscount'];
	$grandTotal = $_POST['grandTotal'];
	$received = $_POST['received'];
	$remaining = $_POST['remaining'];

	mysqli_query($con,"UPDATE `scounter` SET `bilty_No`='$bilty_No',`referal`='$reference',`customer`='$customer',`sale_day`='$sale_day' WHERE id='$orderno'");
 	
 	$result = mysqli_query($con, "SELECT id FROM trans WHERE invoice_id='$orderno' AND type='SV'");
	$fetch = mysqli_fetch_array($result);
	mysqli_query($con,"DELETE FROM sale WHERE sale_No='$orderno'");
	mysqli_query($con,"DELETE FROM ledgers WHERE trans_id='".$fetch['id']."'");
	mysqli_query($con,"DELETE FROM trans WHERE invoice_id='$orderno' AND type='SV'");

 	foreach ($product  as $key => $value) {
	 	mysqli_query($con,"INSERT INTO `sale`(`sale_No`, `barcode`, `qty`, `price`, `grossId`, `discount`, `finalValue`, `received`, `remaining`,`sale_day`,`customer`,`purchase_Price`,`profit`) VALUES ('$orderno','$product[$key]','$qty[$key]','$price[$key]','$gross','$InvDiscount','$grandTotal','$received','$remaining','$sale_day','$customer','$pprice[$key]','0')");
	 	
	 	mysqli_query($con,"UPDATE products SET shQty=shQty-'$qty[$key]' WHERE id='$product[$key]'"); 
 	}

 	mysqli_query($con,"INSERT INTO `trans`(`day`, `account_id`, `invoice_id`, `amount`, `type`, `remarks`, `status`)VALUES('$sale_day','$customer','$orderno','$received','SV','$reference','1')");

	$master = mysqli_insert_id($con);

	mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$grandTotal','$sale_day','SV','$customer','$master','1')");

	if($received>0){
	 	mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$received','$sale_day','SV','$customer','$master','1')");
	}
	echo $master;
}

if($from=='saleInvoice' && $operation=='show'){
	$id = $_REQUEST['id'];
	$result = mysqli_query($con,"SELECT shQty, r_price, p_price FROM products WHERE id='$id'");
	$fetch = mysqli_fetch_array($result);
	$total = 1*$fetch['r_price'];
	echo $fetch['r_price']."|".$total."|".$fetch['p_price'];
}

if($from=='viewSaleInvoice' && $operation=='show'){
	$num = $_REQUEST['num'];
	$data = ''; $counter = $totalRow = 0;
	$result = mysqli_query($con,"SELECT * FROM scounter ORDER BY id DESC");
	$totalRow = mysqli_num_rows($result);
	while($fetch = mysqli_fetch_array($result)){
		$counter++;
		if($_SESSION['type']=='Kitchen'){
			$data.='<tr>
				<td>'.date('d-M-Y', strtotime($fetch['sale_day'])).'</td>
				<td>'.$fetch['id'].'</td>
				<td>'.$fetch['referal'].'</td>
				<td><div onclick="view('.$fetch['id'].')" class="btn btn-primary">View Invoices</div>
	            </td>
		        </tr>';
		} else {
			$data.='<tr>
				<td>'.date('d-M-Y', strtotime($fetch['sale_day'])).'</td>
				<td>'.$fetch['id'].'</td>
				<td>'.$fetch['referal'].'</td>
				<td><div onclick="view('.$fetch['id'].')" class="btn btn-primary">View Invoices</div> <div onclick="del('.$fetch['id'].')" class="btn btn-danger">Delete</div>
	            </td>
		        </tr>';
		  //   $data.='<tr>
				// <td>'.date('d-M-Y', strtotime($fetch['sale_day'])).'</td>
				// <td>'.$fetch['id'].'</td>
				// <td>'.$fetch['referal'].'</td>
				// <td><div onclick="view('.$fetch['id'].')" class="btn btn-primary">View Invoices</div> <a href="editSaleInvoice.php?id='.$fetch['id'].'" class="btn btn-warning">Edit</a> <div onclick="del('.$fetch['id'].')" class="btn btn-danger">Delete</div>
	   //          </td>
		  //       </tr>';
		}
		
		if ($num==$counter) {
			break;
		}
	}
	echo $data."|".$totalRow;
}

if($from=='viewSaleInvoice' && $operation=='del'){
	$id = $_REQUEST['id'];
	
	$result = mysqli_query($con, "SELECT id FROM trans WHERE invoice_id='$id' AND type='SV'");
    $fetch = mysqli_fetch_array($result);

    $result2 = mysqli_query($con,"SELECT * FROM sale WHERE sale_No='$id'");
    while($fetch2 = mysqli_fetch_array($result2)){
    	$qty = $fetch2['qty'];
    	$result3 = mysqli_query($con, "UPDATE products SET shQty=shQty+$qty WHERE id='".$fetch2['barcode']."'");
	}
	mysqli_query($con,"DELETE FROM sale WHERE sale_No='$id'");
	mysqli_query($con,"DELETE FROM ledgers WHERE trans_id='".$fetch['id']."'");
	mysqli_query($con,"DELETE FROM trans WHERE invoice_id='$id' AND type='SV'");
	mysqli_query($con,"DELETE FROM scounter WHERE id='$id'");

	echo "1";
}

/* Sale Invoices end */

/* GPUSale Invoices start */

if($from=='gpusale' && $operation=='get'){
	$id = $_GET['id'];
	$menu = $_GET['menu'];
	$data = '';
	
	if($menu=="menu"){

		$data = ''; $counter = 0;
		$result = mysqli_query($con,"SELECT * FROM products WHERE cat_id='$id' AND active!=0 ORDER BY name");
		while($fetch = mysqli_fetch_array($result)){
			$counter++;
		$data.='<option value='.$fetch['id'].'>'.$fetch['name'].'</option>';
		} 
		echo $data;
	} else {
		$data = ''; $counter = 0;
		$result = mysqli_query($con,"SELECT products.id, products.name FROM products INNER JOIN deal ON products.cat_id=deal.items WHERE deal.deal_id='$id'");
		while($fetch = mysqli_fetch_array($result)){
			$counter++;
		$data.='<option value='.$fetch['id'].'>'.$fetch['name'].'</option>';
		} 
		echo $data;
	}
}

if($from=='gpusale' && $operation=='custHistory'){
	$phone = $_GET['phone'];
	$data = '';

	$custId = getCustomerId($phone);
	$result = mysqli_query($con,"SELECT * FROM sale WHERE customer='$custId' ORDER BY id DESC LIMIT 1");
	$fetch = mysqli_fetch_array($result);
	if(mysqli_num_rows($result)>0){

	 echo getProductName($fetch['barcode'],$fetch['type'],$fetch['deal_items']);
	}
}

if($from=='gpusaleInvoice' && $operation=='show'){

	$id = $_REQUEST['id'];
	$cid = $_REQUEST['cid'];
	$qty = $_REQUEST['qty'];
	$menu = $_REQUEST['menu'];
	
	if($menu=='menu'){
	$result = mysqli_query($con,"Select category.name AS cname, products.name, products.shQty, products.r_price, products.p_price FROM products INNER JOIN category ON products.cat_id=category.id WHERE products.id='$id'");

	$fetch = mysqli_fetch_array($result);
	$total = $qty*$fetch['r_price'];
	echo $fetch['r_price']."|".$total."|".$fetch['p_price']."|".$fetch['name']."|".$fetch['cname'];	
	} else {
		$pname = "";
		$pid = explode(",",$id);
		foreach($pid  as $key => $value){
			$result2 = mysqli_query($con,"SELECT * FROM products WHERE id='$pid[$key]'");
			$fetch2 = mysqli_fetch_array($result2);
			$pname .= $fetch2['name'].",";
			
		}
		$result = mysqli_query($con,"Select * FROM dcounter WHERE id='$cid'");
		$fetch = mysqli_fetch_array($result);
		$total = $qty*$fetch['dealPrice'];
		echo $fetch['dealPrice']."|".$total."|".'0'."|".$fetch['dealName']."|".$pname;
	}	
}

if($from=='gpusale' && $operation=='insert'){
	
	$sale_day = $_POST['sale_day'];
	$menuType = $_POST['menuType'];
	$menuSaleType = $_POST['menuSaleType'];
	$bilty_No = "";
	$reference = "";
	$customer = "69";
	$tcproduct = $_POST['tcname'];
	$product = $_POST['tpname'];
	$qty = $_POST['pqty'];
	$price = $_POST['prate'];
	$pprice = $_POST['purprice'];
	$total = $_POST['total'];
	$gross = $_POST['netBill'];
	$InvDiscount = $_POST['invDiscount'];

	$grandTotal = $gross-round(($InvDiscount/100*$gross));

	// $grandTotal = $_POST['netBill'];
	// $received = $grandTotal;
	$received = $_POST['received'];
	$comments = $_POST['comments'];
	// $remaining = "0";
	$remaining = $gross-$received;
	$dealItems = implode(" ", $tcproduct);

	$custName = $_POST['custName'];
	$custPhone = $_POST['custPhone'];
	$custAddress = $_POST['custAddress'];
	$type = "Customer";
	$designation = "Customer";
	$salary = "";
    $contact = $custPhone;
    $phone1 = "";
    $phone2 = "";
    $city = "";
    $address = $custAddress;

    $result8 = mysqli_query($con,"SELECT * FROM accounts WHERE contact='$contact'");
	$fetch8 = mysqli_fetch_array($result8);
	if(mysqli_num_rows($result8)>0){
		$customer = $fetch8['id'];
	} else {
		mysqli_query($con,"INSERT INTO accounts (name,designation,salary,contact,phone1,phone2,city,type,address,active) VALUES('$custName','$designation','$salary','$contact','$phone1','$phone2','$city','$type','$address','1')");
		$customer = mysqli_insert_id($con);
	}

	
	mysqli_query($con,"INSERT INTO `scounter`(`bilty_No`, `referal`, `customer`,`sale_day`) VALUES ('$bilty_No','$reference','$customer','$sale_day')");
 	$master=mysqli_insert_id($con);

 	foreach ($product  as $key => $value) {

 		mysqli_query($con,"INSERT INTO `sale`(`sale_No`, `barcode`, `qty`, `price`, `grossId`, `discount`, `finalValue`, `received`, `remaining`,`sale_day`,`customer`,`purchase_Price`,`profit`,`type`,`sale_type`,`comments`,`deal_items`) VALUES ('$master','$product[$key]','$qty[$key]','$price[$key]','$gross','$InvDiscount','$grandTotal','$received','$remaining','$sale_day','$customer','$pprice[$key]','0','$menuType[$key]','$menuSaleType','$comments','$dealItems')");

 		// if($product[$key]='91' || $product[$key]='92' || $product[$key]='93' || $product[$key]='94' || $product[$key]='95' || $product[$key]='91'){
 		// 	mysqli_query($con,"UPDATE products SET shQty=shQty-60 WHERE cat_id='112'");
 		// } else if($product[$key]='4'){
 		// 	mysqli_query($con,"UPDATE products SET shQty=shQty-150 WHERE cat_id='112'");
 		// } else if($product[$key]='3'){
 		// 	mysqli_query($con,"UPDATE products SET shQty=shQty-200 WHERE cat_id='112'");
 		// }
 	
 		if($menuType[$key]=='menu'){

	 		mysqli_query($con,"UPDATE products SET shQty=shQty-'$qty[$key]' WHERE id='$product[$key]'"); 
	 		
	 		$result = mysqli_query($con,"SELECT * FROM products WHERE id='$product[$key]'");
	 		$fetch = mysqli_fetch_array($result);
		 	if ($fetch['shQty']<$fetch['minQ']) {
		 		mysqli_query($con,"UPDATE products SET reorder='1' WHERE id='$product[$key]'");
		 	}
		 	if($fetch['cat_id']=='2'){ // 6 incher
		 		mysqli_query($con,"UPDATE products SET shQty=shQty-50 WHERE id='153'"); // chicken
		 		mysqli_query($con,"UPDATE products SET shQty=shQty-50 WHERE id='154'"); // cheese
		 		mysqli_query($con,"UPDATE products SET shQty=shQty-40 WHERE id='172'"); // mayonnaise

		 	} else if($fetch['cat_id']=='4'){ // 9 incher 
		 		mysqli_query($con,"UPDATE products SET shQty=shQty-90 WHERE id='153'"); // chicken
		 		mysqli_query($con,"UPDATE products SET shQty=shQty-90 WHERE id='154'"); // cheese
		 		mysqli_query($con,"UPDATE products SET shQty=shQty-60 WHERE id='172'"); // mayonnaise
		 	} else if($fetch['cat_id']=='3'){ // 12 incher
		 		mysqli_query($con,"UPDATE products SET shQty=shQty-150 WHERE id='153'"); // chicken
		 		mysqli_query($con,"UPDATE products SET shQty=shQty-150 WHERE id='154'"); // cheese
		 		mysqli_query($con,"UPDATE products SET shQty=shQty-90 WHERE id='172'"); // mayonnaise
		 	}

	 	} else {
	 		// $result = mysqli_query($con,"SELECT * FROM deal WHERE deal_id='$product[$key]'");
	 		// while($fetch = mysqli_fetch_array($result)){
	 			$pid2 = explode(",",$tcproduct[$key]);
	 			foreach ($pid2 as $key2 => $value2) {
	 				
			 		mysqli_query($con,"UPDATE products SET shQty=shQty-'$qty[$key]' WHERE id='".$pid2[$key2]."'"); 
		 		
			 		$result2 = mysqli_query($con,"SELECT * FROM products WHERE id='".$pid2[$key2]."'");
			 		$fetch2 = mysqli_fetch_array($result2);
				 	if ($fetch2['shQty']<$fetch2['minQ']) {
				 		mysqli_query($con,"UPDATE products SET reorder='1' WHERE id='$product[$key]'");
				 	}

				 	if($fetch2['cat_id']=='2'){ // 6 incher
				 		mysqli_query($con,"UPDATE products SET shQty=shQty-50 WHERE id='153'"); // chicken
				 		mysqli_query($con,"UPDATE products SET shQty=shQty-50 WHERE id='154'"); // cheese
				 		mysqli_query($con,"UPDATE products SET shQty=shQty-40 WHERE id='172'"); // mayonnaise

				 	} else if($fetch2['cat_id']=='4'){ // 9 incher 
				 		mysqli_query($con,"UPDATE products SET shQty=shQty-90 WHERE id='153'"); // chicken
				 		mysqli_query($con,"UPDATE products SET shQty=shQty-90 WHERE id='154'"); // cheese
				 		mysqli_query($con,"UPDATE products SET shQty=shQty-60 WHERE id='172'"); // mayonnaise
				 	} else if($fetch2['cat_id']=='3'){ // 12 incher
				 		mysqli_query($con,"UPDATE products SET shQty=shQty-150 WHERE id='153'"); // chicken
				 		mysqli_query($con,"UPDATE products SET shQty=shQty-150 WHERE id='154'"); // cheese
				 		mysqli_query($con,"UPDATE products SET shQty=shQty-90 WHERE id='172'"); // mayonnaise
				 	}
			 	}
		 	// }
	 	}
 	}

 	mysqli_query($con,"INSERT INTO `trans`(`day`, `account_id`, `invoice_id`, `amount`, `type`, `remarks`, `status`)VALUES('$sale_day','$customer','$master','$received','SV','$reference','1')");
	$master2 = mysqli_insert_id($con);

 	mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$grandTotal','$sale_day','SV','$customer','$master2','1')");

	if($received>0){
	   mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$received','$sale_day','SV','$customer','$master2','1')");
	}

	echo $master;
}

/* GPUSale Invoices end */

/* Purchase Invoices Start */

if($from=='purchaseInvoice' && $operation=='insert'){
	
	$sale_day = $_POST['sale_day'];
	$vendor_bilty_No = $_POST['vendor_bilty_No'];
	$bilty_date = $_POST['bilty_date'];
	$bilty_No = $_POST['bilty_No'];
	$reference = $_POST['reference'];
	$customer = $_POST['customer'];
	$product = $_POST['product'];
	$qty = $_POST['qty'];
	$price = $_POST['price'];
	$wprice = $_POST['wprice'];
	$rprice = $_POST['rprice'];
	$total = $_POST['total'];
	$gross = $_POST['gross'];
	$InvDiscount = $_POST['InvDiscount'];
	$grandTotal = $_POST['grandTotal'];
	$received = $_POST['received'];
	$remaining = $_POST['remaining'];

	mysqli_query($con,"INSERT INTO `pcounter`(`sale_day`, `bilty_No`, `bill_No`, `bill_date`, `customer`, `transport_By`) VALUES ('$sale_day','$bilty_No','$vendor_bilty_No','$bilty_date','$customer','$reference')");
 	$master = mysqli_insert_id($con);

 	foreach ($product  as $key => $value) {
	 	mysqli_query($con,"UPDATE products SET p_price='$price[$key]',w_price='$wprice[$key]',r_price='$rprice[$key]',shQty=shQty+'$qty[$key]' WHERE id='$product[$key]'");
	 	
	 	mysqli_query($con,"INSERT INTO `psale`(`sale_No`, `barcode`, `qty`, `price`, `grossId`, `discount`, `finalValue`, `received`, `remaining`,`sale_day`,`w_price`,`r_price`,`customer`) VALUES ('$master','$product[$key]','$qty[$key]','$price[$key]','$gross','$InvDiscount','$grandTotal','$received','$remaining','$sale_day','$wprice[$key]','$rprice[$key]','$customer')");
 	}

 	mysqli_query($con,"INSERT INTO `trans`(`day`, `account_id`, `invoice_id`, `amount`, `type`, `remarks`, `status`)VALUES('$sale_day','$customer','$master','$received','PV','$reference','1')");
 	$master2 = mysqli_insert_id($con);

 	mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$grandTotal','$sale_day','PV','$customer','$master2','1')");

	if($received>0){
		mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$received','$sale_day','PV','$customer','$master2','1')");
	}
	echo $master;
}

if($from=='purchaseInvoice' && $operation=='update'){
	
	$orderno = $_POST['orderno'];
	$sale_day = $_POST['sale_day'];
	$vendor_bilty_No = $_POST['vendor_bilty_No'];
	$bilty_date = $_POST['bilty_date'];
	$bilty_No = $_POST['bilty_No'];
	$reference = $_POST['reference'];
	$customer = $_POST['customer'];
	$product = $_POST['product'];
	$qty = $_POST['qty'];
	$price = $_POST['price'];
	$wprice = $_POST['wprice'];
	$rprice = $_POST['rprice'];
	$total = $_POST['total'];
	$gross = $_POST['gross'];
	$InvDiscount = $_POST['InvDiscount'];
	$grandTotal = $_POST['grandTotal'];
	$received = $_POST['received'];
	$remaining = $_POST['remaining'];

	mysqli_query($con,"UPDATE `pcounter` SET sale_day='$sale_day',bilty_No='$bilty_No',bill_No='$vendor_bilty_No',bill_date='$bilty_date',customer='$customer',transport_By='$reference' WHERE id='$orderno'");
 	
 	mysqli_query($con,"DELETE FROM psale WHERE sale_No='$orderno'");

	$result = mysqli_query($con, "SELECT id FROM trans WHERE invoice_id='$orderno' AND type='PV'");
	$fetch = mysqli_fetch_array($result);

	mysqli_query($con,"DELETE FROM ledgers WHERE trans_id='".$fetch['id']."'");
	mysqli_query($con,"DELETE FROM trans WHERE invoice_id='$orderno' AND type='PV'");

 	foreach ($product  as $key => $value) {
	 	mysqli_query($con,"UPDATE products SET p_price='$price[$key]',w_price='$wprice[$key]',r_price='$rprice[$key]',shQty=shQty+'$qty[$key]' WHERE id='$product[$key]'");

	 	mysqli_query($con,"INSERT INTO `psale`(`sale_No`, `barcode`, `qty`, `price`, `grossId`, `discount`, `finalValue`, `received`, `remaining`,`sale_day`,`w_price`,`r_price`,`customer`) VALUES ('$orderno','$product[$key]','$qty[$key]','$price[$key]','$gross','$InvDiscount','$grandTotal','$received','$remaining','$sale_day','$wprice[$key]','$rprice[$key]','$customer')");
	}

 	mysqli_query($con,"INSERT INTO `trans`(`day`, `account_id`, `invoice_id`, `amount`, `type`, `remarks`, `status`)VALUES('$sale_day','$customer','$orderno','$received','PV','$reference','1')");
	$master = mysqli_insert_id($con);

	mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$grandTotal','$sale_day','PV','$customer','$master','1')");
	if($received>0){
	 	mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$received','$sale_day','PV','$customer','$master','1')");
	}
	echo $master;
}

if($from=='purchaseInvoice' && $operation=='show'){
	$id = $_REQUEST['id'];
	$result = mysqli_query($con,"SELECT shQty, r_price, p_price, w_price FROM products WHERE id='$id'");
	$fetch = mysqli_fetch_array($result);
	$total = $fetch['shQty']*$fetch['p_price'];
	echo $fetch['p_price']."|".$total."|".$fetch['w_price']."|".$fetch['r_price'];
}

if($from=='viewPurchaseInvoice' && $operation=='show'){
	$num = $_REQUEST['num'];
	$data = ''; $counter = $totalRow = 0;
	$result = mysqli_query($con,"SELECT * FROM pcounter ORDER BY id DESC");
	$totalRow = mysqli_num_rows($result);
	if($num=='All'){
		$num = $totalRow;
	}
	while($fetch = mysqli_fetch_array($result)){
		$counter++;
		$data.='<tr>
				<td>'.date('d-M-Y', strtotime($fetch['sale_day'])).'</td>
				<td>'.$fetch['id'].'</td>
				<td>'.getCustomerName($fetch['customer']).'</td>
				<td>'.$fetch['bilty_No'].'</td>
				<td><div onclick="view('.$fetch['id'].')" class="btn btn-primary">View Invoices</div> <a href="editPurchaseInvoice.php?id='.$fetch['id'].'" class="btn btn-warning">Edit</a> <div onclick="del('.$fetch['id'].')" class="btn btn-danger">Delete</div>
	            </td>
		        </tr>';
		if ($num==$counter) {
			break;
		}
	}
	echo $data."|".$totalRow;
}

if($from=='viewPurchaseInvoice' && $operation=='del'){
	$id = $_REQUEST['id'];
	
	$result = mysqli_query($con, "SELECT id FROM trans WHERE invoice_id='$id' AND type='PV'");
    $fetch = mysqli_fetch_array($result);
    mysqli_query($con,"DELETE FROM psale WHERE sale_No='$id'");
    mysqli_query($con,"DELETE FROM ledgers WHERE trans_id='".$fetch['id']."'");
    mysqli_query($con,"DELETE FROM trans WHERE invoice_id='$id' AND type='PV'");
    mysqli_query($con,"DELETE FROM pcounter WHERE id='$id'");

	echo "1";
}

/* Purchase Invoices end */

/* Sale Return start */

if($from=='getSaleInvoice' && $operation=='show'){
	$customerId = $_REQUEST['id'];
	$result = mysqli_query($con,"SELECT * FROM scounter WHERE customer='$customerId' AND type!='RS'");
	if(mysqli_num_rows($result)>0){
		while($fetch=mysqli_fetch_array($result)){
			echo '<option>'.$fetch['id'].'</option>';
		}	
	}
	else{
		echo "<option>No Invoice Found</option>";
	} 		
}

if($from=='insertSInvoice' && $operation=='show'){
	$saleNo = $_REQUEST['id'];
	$table = ''; $counter = $amnt = $i = 0;
	$result = mysqli_query($con,"SELECT sale.*, products.name FROM sale INNER JOIN products ON sale.barcode=products.id WHERE sale_No='$saleNo' GROUP BY id");

	while($fetch=mysqli_fetch_array($result)){ 	
		$counter++;$i++;
		$amnt = $fetch["qty"]*$fetch["price"];
		$table .='<tr>
            <td><select class="form-control product" name="product[]" required><option value="0" disabled selected>--- Select ---</option>
            '.$result=mysqli_query($con,"SELECT * FROM products WHERE active='1' ORDER BY name");
		    // while($fetch=mysqli_fetch_array($result)){
		    // 	'<option value="'.$fetch["id"].'">'.$fetch["name"].'</option>'
		    // }
		    '</select></td>
            <td><input type="number" readonly value="'.$fetch["price"].'" name="price[]" class="form-control"></td>
            <td><input type="number" style="width:150px;" value="'.$fetch["qty"].'" name="qty[]" class="form-control qty"></td>
            <td><input type="number" style="width:150px;" value="'.$amnt.'" name="amnt[]" class="form-control amnt" readonly></td>
           </tr>';   
    }
    echo $table; 		
}

/* Sale Return end */
?>