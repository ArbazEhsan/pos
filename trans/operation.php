<?php 
include('../connect.php');
include('../converter.php');

$from = $_REQUEST['from'];

if($from='journal'){
	$day = $_POST['day'];
	$customer = getCustomerId($_POST['customer']);
	$product = $_POST['product'];
	$qty = $_POST['qty'];
	$amount = $_POST['amount'];
	$naration = $_POST['naration'];

	mysqli_query($con,"UPDATE products SET shQty=shQty-'$qty' WHERE name='$product'");

	// $result = mysqli_query($con,"SELECT * FROM products WHERE name='$product'");
	// $fetch = mysqli_fetch_array($result);
    mysqli_query($con,"INSERT INTO `expense`(`day`, `product_id`, `qty`, `amount`, `account_id`, `naration`) VALUES ('$day','$product','$qty','$amount','$customer','$naration')");

    echo 'Voucher Created!';
}
?>