<?php

include('../connect.php');

$from=$_REQUEST['from'];


if($from=='1')

{
  $id=$_GET['barcode'];
$result=mysqli_query($con,"SELECT * FROM products WHERE id='$id'");
$fetch=mysqli_fetch_array($result);

$name=$fetch['name'];
$p_price=$fetch['p_price'];
$w_price=$fetch['w_price'];
$r_price=$fetch['r_price'];
$shQty=$fetch['shQty'];

echo $name.'/'.$p_price.'/'.$w_price.'/'.$r_price.'/'.$shQty;

}

else if($from=='2')
{
  $product = $_GET['product'];
$result=mysqli_query($con,"SELECT * FROM products WHERE name='$product'");
$fetch=mysqli_fetch_array($result);
echo $fetch['id'];

}




?>