<?php
include('../connect.php');
include('../converter.php');
 $orderno=$_REQUEST['orderno'];
 $sale_day    = $_REQUEST['sale_day'];
 $bilty_No    = $_REQUEST['bilty_No'];
 $referal     = $_REQUEST['referal'];
 $customer    = getCustomerId($_REQUEST['customer']); 
 
 $grossId      = $_REQUEST['grossId'];
 $discount     = $_REQUEST['discount1'];
 $finalValue   = $_REQUEST['finalValue'];
 $received     = $_REQUEST['received'];
 $remaining    = $_REQUEST['remaining'];

 $barcode      = $_REQUEST['barcode'];
 $qty          = $_REQUEST['qty'];
 $price        = $_REQUEST['price'];

 $barcode1  = json_decode($barcode, TRUE);
 $price1    = json_decode($price, TRUE);
 $qty1      = json_decode($qty, TRUE);


 


 mysqli_query($con,"UPDATE `scounter` SET `bilty_No`=bilty_No,`referal`='referal',`customer`='$customer',`sale_day`='$sale_day' WHERE id='$orderno'");
 $result = mysqli_query($con, "SELECT id FROM trans WHERE invoice_id='$orderno' AND type='SV'");
 $fetch = mysqli_fetch_array($result);
 mysqli_query($con,"DELETE FROM sale WHERE sale_No='$orderno'");
 mysqli_query($con,"DELETE FROM ledgers WHERE trans_id='".$fetch['id']."'");
 mysqli_query($con,"DELETE FROM trans WHERE invoice_id='$orderno' AND type='SV'");

 foreach ($barcode1  as $key => $value) 
 {
 	mysqli_query($con,"INSERT INTO `sale`(`sale_No`, `barcode`, `qty`, `price`, `grossId`, `discount`, `finalValue`, `received`, `remaining`,`sale_day`,`customer`) VALUES ('$orderno','$barcode1[$key]','$qty1[$key]','$price1[$key]','$grossId','$discount','$finalValue','$received','$remaining','$sale_day','$customer')");
 	
 	mysqli_query($con,"UPDATE products SET shQty = shQty - '$qty1[$key]' WHERE id = '$barcode1[$key]'"); 
 }
  
 mysqli_query($con,"INSERT INTO `trans`(`day`, `account_id`, `invoice_id`, `amount`, `type`, `remarks`, `status`)VALUES('$sale_day','$customer','$orderno','$received','SV','$referal','1')");

 $master2=mysqli_insert_id($con);

 mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$finalValue','$sale_day','SV','$customer','$master2','1')");

 if($received>0)
 {
 	mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$received','$sale_day','SV','$customer','$master2','1')");
 }

?>