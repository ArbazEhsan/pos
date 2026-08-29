<?php 

function profit($id)
{
	$sum1=0;$profit =0;$loss=0;
	include('../connect.php');
	$result1 = mysqli_query($con,"SELECT * FROM sale WHERE sale_No='$id'");
					while($fetch1  = mysqli_fetch_array($result1)){
 					$salerate1= $fetch1['price'];
      				$barcode1 = $fetch1['barcode'];

	$result2 = mysqli_query($con,"SELECT * FROM products WHERE  barcode='$barcode1'");
					$fetch2  = mysqli_fetch_array($result2);
					$prate1  = $fetch2['purchasePrice'];
					$sum1=$salerate1-$prate1;
					if($sum1>0)
					{
						$profit +=$sum1;
					}
					else if ($sum1<0)
					{
						$loss += $sum1;
					}
	}
return $loss+$profit;
}
function pr($id)
{
	$sum1=0;$profit =0;
	include('../connect.php');
	$result1 = mysqli_query($con,"SELECT * FROM sale WHERE sale_No='$id'");
					while($fetch1  = mysqli_fetch_array($result1)){
 					$salerate1= $fetch1['price'];
      				$barcode1 = $fetch1['barcode'];

	$result2 = mysqli_query($con,"SELECT * FROM products WHERE  barcode='$barcode1'");
					$fetch2  = mysqli_fetch_array($result2);
					$prate1  = $fetch2['purchasePrice'];
					$sum1=$salerate1-$prate1;
					if($sum1>0)
					{
						$profit +=$sum1;
					}
					else if ($sum1<0)
					{
						$loss += $sum1;
					}
	}
return $profit;
}

?>