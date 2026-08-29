<?php 
include('../connect.php');
include('../converter.php');
  
$day = $_POST['day'];
$billNo = $_POST['vno'];
$tamnt = $_POST['tamnt'];
$customer = $_POST['customer'];
$remarks = $_POST['remarks'];
$amount = $_POST['amount'];

mysqli_query($con,"INSERT INTO `tcounter`(`day`, `voucher_no`, `total_amnt`, `type`) VALUES ('$day','$billNo','$tamnt','CR')");
$id = mysqli_insert_id($con);
foreach ($customer as $key => $value) {
	mysqli_query($con,"INSERT INTO trans (day, account_id, amount, type, remarks, bill_no, status)VALUES('$day','$customer[$key]','$amount[$key]','CR','$remarks[$key]','$id','1')");
	$idd = mysqli_insert_id($con);
	mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$amount[$key]','$day','CR','$customer[$key]','$idd','1')");
}
echo $id;

?>