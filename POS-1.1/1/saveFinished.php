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
	// $fQty = $_POST['fQty'];

	$fSize = $cSize = $qty2 = 0;
	$result = mysqli_query($con,"SELECT * FROM products WHERE id='$fgoods'");
	$fetch = mysqli_fetch_array($result);
	$fSize = $fetch['size'];
	$result2 = mysqli_query($con,"SELECT * FROM products WHERE id='$product[0]'");
	$fetch2 = mysqli_fetch_array($result2);
	$cSize = $fetch2['size']*$qty[0];
	if($fSize>0 && $cSize>0) {
		$qty2 = $cSize/$fSize;
		mysqli_query($con,"UPDATE products SET shQty=shQty+'$qty2' WHERE id='$fgoods'");
		$p = $q = '';
		foreach ($product as $key => $value) {
			$p .= $product[$key].',';
			$q .= $qty[$key].',';
			mysqli_query($con,"UPDATE products SET shQty=shQty-'$qty[$key]' WHERE id='$product[$key]'");
		}
		mysqli_query($con,"INSERT INTO `finished`(`day`, `finish_good`, `fQty`, `consume`, `qty`) VALUES ('$day','$fgoods','$qty2','$p','$q')");

		echo 1;
	}
	else {
		echo 0;
	}
}



?>