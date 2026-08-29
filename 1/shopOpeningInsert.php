<?php
include("../connect.php");
//$shop_qty= $_REQUEST["shop_qty"];
$location= $_REQUEST["location"];
$barcode= $_REQUEST["barcode"];

	foreach ($barcode as $key => $value2)
	{
         
 		$sql2= "UPDATE products set location = '$location[$key]' WHERE id= '$barcode[$key]'";
 		mysqli_query($con,$sql2);
		header("Location:location.php?msg= Adjusted"); //query string ?msg=
         	
}

?>
