<?php
include('../connect.php');
include('../converter.php');

	
 $sale_day    = $_REQUEST['sale_day'];
 $pprice      = $_REQUEST['pprice'];
 $profit      = $_REQUEST['profit'];
 $bilty_No    = $_REQUEST['bilty_No'];
 $referal     = $_REQUEST['referal'];
 $customer    = getCustomerId($_REQUEST['customer']); 
 
 $grossId     = $_REQUEST['grossId'];
 $discount    = $_REQUEST['discount1'];
 $finalValue  = $_REQUEST['finalValue'];
 $received    = $_REQUEST['received'];
 $remaining   = $_REQUEST['remaining'];

 $barcode     = $_REQUEST['barcode'];
 $qty         = $_REQUEST['qty'];
 $price       = $_REQUEST['price'];

 $barcode1  = json_decode($barcode, TRUE);
 $price1    = json_decode($price, TRUE);
 $qty1      = json_decode($qty, TRUE); 
 $pprice    = json_decode($pprice, TRUE); 
 $profit    = json_decode($profit, TRUE); 


 mysqli_query($con,"INSERT INTO `scounter`(`bilty_No`, `referal`, `customer`,`sale_day`) VALUES ('$bilty_No','$referal','$customer','$sale_day')");
 $master=mysqli_insert_id($con);

 foreach ($barcode1  as $key => $value) 
 {

 	mysqli_query($con,"INSERT INTO `sale`(`sale_No`, `barcode`, `qty`, `price`, `grossId`, `discount`, `finalValue`, `received`, `remaining`,`sale_day`,`customer`,`purchase_Price`,`profit`) VALUES ('$master','$barcode1[$key]','$qty1[$key]','$price1[$key]','$grossId','$discount','$finalValue','$received','$remaining','$sale_day','$customer','$pprice[$key]','$profit[$key]')");
 	
 	mysqli_query($con,"UPDATE products SET shQty = shQty - '$qty1[$key]' WHERE id = '$barcode1[$key]'"); 
 	$res = mysqli_query($con,"SELECT * FROM products WHERE id = '$barcode1[$key]'");
 	$fet = mysqli_fetch_array($res);
 	if ($fet['shQty']<$fet['minQ']) {
 		mysqli_query($con,"UPDATE products SET reorder='1' WHERE id='$barcode1[$key]'");
 	}
 }

 mysqli_query($con,"INSERT INTO `trans`(`day`, `account_id`, `invoice_id`, `amount`, `type`, `remarks`, `status`)VALUES('$sale_day','$customer','$master','$received','SV','$referal','1')");

$master2=mysqli_insert_id($con);

 mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$finalValue','$sale_day','SV','$customer','$master2','1')");

 if($received>0)
 {
   mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$received','$sale_day','SV','$customer','$master2','1')");
 }

echo $master;
?>