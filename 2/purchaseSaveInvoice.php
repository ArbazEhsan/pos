<?php
include('../connect.php');
include('../converter.php');

$sale_day     =$_REQUEST['sale_day'];
$bilty_No     =$_REQUEST['bilty_No'];
$bill_No      =$_REQUEST['bill_No'];
$bill_date    =$_REQUEST['bill_date'];
$customer     =getCustomerId($_REQUEST['vendor']);
$transport    =$_REQUEST['transport']; 
$grossId      =$_REQUEST['grossId'];
$discount     =$_REQUEST['discount1'];
$finalValue   =$_REQUEST['finalValue'];
$received     =$_REQUEST['received'];
$remaining    =$_REQUEST['remaining'];
 $barcode      = $_REQUEST['barcode'];
 $qty          = $_REQUEST['qty'];
 $price        = $_REQUEST['price'];
 $w_price      = $_REQUEST['w_price'];
 $r_price      = $_REQUEST['r_price'];

 $barcode1  = json_decode($barcode, TRUE);
 $price1    = json_decode($price, TRUE);
 $qty1      = json_decode($qty, TRUE);
 $w_price1   = json_decode($w_price, TRUE);
 $r_price1   = json_decode($r_price, TRUE);

 mysqli_query($con,"INSERT INTO `pcounter`(`sale_day`, `bilty_No`, `bill_No`, `bill_date`, `customer`, `transport_By`) VALUES ('$sale_day','$bilty_No','$bill_No','$bill_date','$customer','$transport')");
 $master=mysqli_insert_id($con);

 foreach ($barcode1  as $key => $value) 
 {
 	mysqli_query($con,"UPDATE products SET p_price='$price1[$key]',w_price='$w_price1[$key]',r_price='$r_price1[$key]',shQty=shQty+'$qty1[$key]' WHERE id='$barcode1[$key]'");
 	
 	mysqli_query($con,"INSERT INTO `psale`(`sale_No`, `barcode`, `qty`, `price`, `grossId`, `discount`, `finalValue`, `received`, `remaining`,`sale_day`,`w_price`,`r_price`,`customer`) VALUES ('$master','$barcode1[$key]','$qty1[$key]','$price1[$key]','$grossId','$discount','$finalValue','$received','$remaining','$sale_day','$w_price1[$key]','$r_price1[$key]','$customer')");
 }

 mysqli_query($con,"INSERT INTO `trans`(`day`, `account_id`, `invoice_id`, `amount`, `type`, `remarks`, `status`)VALUES('$sale_day','$customer','$master','$received','PV','$transport','1')");
 $master2=mysqli_insert_id($con);

 mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$finalValue','$sale_day','PV','$customer','$master2','1')");

 if($received>0){

 	mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$received','$sale_day','PV','$customer','$master2','1')");
 }
echo $master;
?>