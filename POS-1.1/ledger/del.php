<?php 
include('../connect.php');
$id = $_REQUEST['id'];
if(mysqli_query($con,"DELETE FROM ledger WHERE id='$id'"))
{
	header("location:credit.php");
 }
 ?>
