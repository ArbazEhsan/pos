<?php 
include('../connect.php');
include('../converter.php');
 
$from = $_GET['from'];
if($from=='finished'){
	$id = $_GET['id'];
	$result = mysqli_query($con,"SELECT size FROM products WHERE id='$id'");
	$fetch = mysqli_fetch_array($result);
	echo $fetch['size'];
}
else {
	$day = $_POST['day'];
	$fgoods = $_POST['fgoods'];
	$product = $_POST['product'];
	$qty = $_POST['qty'];
	$fQty = $_POST['fQty'];

	$result = mysqli_query($con,"SELECT * FROM products WHERE id='$fgoods'");
	$fetch = mysqli_fetch_array($result);
	$qty2 = 0;
	if($fetch['size']>0){
		$qty2 = $fQty/$fetch['size'];
		mysqli_query($con,"UPDATE products SET shQty=shQty+'$qty2' WHERE id='$fgoods'");

		$p = $q = '';
		foreach ($product as $key => $value) {
			$p .= $product[$key].',';
			$q .= $qty[$key].',';
			mysqli_query($con,"UPDATE products SET shQty=shQty-'$qty[$key]' WHERE id='$product[$key]'");
		}
		mysqli_query($con,"INSERT INTO `finished`(`day`, `finish_good`, `fQty`, `consume`, `qty`) VALUES ('$day','$fgoods','$fQty','$p','$q')");

		echo 1;
	}
	else {
		echo 0;
	}
}



?>