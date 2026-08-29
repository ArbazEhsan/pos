<?php
include('../connect.php');
include('../converter.php');
$orderno=$_REQUEST['orderno']; 
$sale_day     =$_REQUEST['sale_day'];
$bilty_No     =$_REQUEST['bilty_No'];
$bill_No      =$_REQUEST['bill_No'];
$bill_date    =$_REQUEST['bill_date'];
$customer     =getCustomerId($_REQUEST['customer']);
$transport_By =$_REQUEST['transport'];
$grossId      =$_REQUEST['grossId'];
$discount     =$_REQUEST['discount1'];
$finalValue   =$_REQUEST['finalValue'];
$received     =$_REQUEST['received'];
$remaining    =$_REQUEST['remaining'];

 $barcode      = $_REQUEST['barcode'];
 $qty          = $_REQUEST['qty'];
 $p_price      = $_REQUEST['p_price3'];
 $w_price      = $_REQUEST['w_price3'];
 $r_price      = $_REQUEST['r_price3'];

 $barcode1  = json_decode($barcode, TRUE);
 $price1    = json_decode($p_price, TRUE);
 $qty1      = json_decode($qty, TRUE);
 $w_price1   = json_decode($w_price, TRUE);
 $r_price1   = json_decode($r_price, TRUE);

 mysqli_query($con,"UPDATE `pcounter` SET sale_day='$sale_day',bilty_No='$bilty_No',bill_No='$bill_No',bill_date='$bill_date',customer='$customer',transport_By='$transport_By' WHERE id='$orderno'");

 mysqli_query($con,"DELETE FROM psale WHERE sale_No='$orderno'");

 $result = mysqli_query($con, "SELECT id FROM trans WHERE invoice_id='$orderno' AND type='PV'");
 $fetch = mysqli_fetch_array($result);

 mysqli_query($con,"DELETE FROM ledgers WHERE trans_id='".$fetch['id']."'");
 mysqli_query($con,"DELETE FROM trans WHERE invoice_id='$orderno' AND type='PV'");

 foreach ($barcode1  as $key => $value) 
 {
 	mysqli_query($con,"UPDATE products SET p_price='$price1[$key]',w_price='$w_price1[$key]',r_price='$r_price1[$key]',shQty=shQty+'$qty1[$key]' WHERE id='$barcode1[$key]'");

 	mysqli_query($con,"INSERT INTO `psale`(`sale_No`, `barcode`, `qty`, `price`, `grossId`, `discount`, `finalValue`, `received`, `remaining`,`sale_day`,`w_price`,`r_price`,`customer`) VALUES ('$orderno','$barcode1[$key]','$qty1[$key]','$price1[$key]','$grossId','$discount','$finalValue','$received','$remaining','$sale_day','$w_price1[$key]','$r_price1[$key]','$customer')");
 }

 mysqli_query($con,"INSERT INTO `trans`(`day`, `account_id`, `invoice_id`, `amount`, `type`, `remarks`, `status`)VALUES('$sale_day','$customer','$orderno','$received','PV','$transport_By','1')");
 $master2=mysqli_insert_id($con);

  mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$finalValue','$sale_day','PV','$customer','$master2','1')");
 if($received>0)
 {
 	mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$received','$sale_day','PV','$customer','$master2','1')");
 }

echo $master2;
?>