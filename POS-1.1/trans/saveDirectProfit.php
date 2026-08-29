<?php include('../connect.php');
include('../converter.php');
  $day      = $_POST['day'];
  $amount   = $_POST['amount'];
  $naration = $_POST['naration'];

  mysqli_query($con,"INSERT INTO cashin (day,naration,type,amount)VALUES('$day','$naration','Direct Profit','$amount')");
  $store = mysqli_insert_id($con);
  mysqli_query($con,"INSERT INTO shopledger (cr,day,type,naration,cashin_Id)VALUES('$amount','$day','Direct Profit','$naration','$store')");
/*echo $store;*/
?>