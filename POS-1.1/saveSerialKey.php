<?php 
include ('connect.php');
$currentDate = date('Y-m').'-01';
$serialKey = $_GET['skey'];
$result = mysqli_query($con,"UPDATE subscription SET status='1' WHERE month='$currentDate' AND sub_key='$serialKey'");
echo "Activated";
?>