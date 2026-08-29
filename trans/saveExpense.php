<?php include('../connect.php');
include('../converter.php');

  $day      = $_POST['day'];
  $amount   = $_POST['amount'];
  $naration = $_POST['naration'];
  mysqli_query($con,"INSERT INTO expense (amount,day,naration)VALUES('$amount','$day','$naration')");
  $store = mysqli_insert_id($con);
  mysqli_query($con,"INSERT INTO cashout (amount,day,type,naration,expense_Id)VALUES('$amount','$day','expense','$naration','$store')");
/*echo $store;*/
?>