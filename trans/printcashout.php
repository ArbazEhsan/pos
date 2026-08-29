<?php 
// session_start(); if( ($_SESSION['username']=='') && ($_SESSION['password']==''))
// {
//     header("Location:../index.php?msg=Please Login to Continue");
// } ?>
 <title>Cashout Print</title>
<?php error_reporting(0);
include("../connect.php");
?>
<!DOCTYPE html>
<html>
<head>
  <link href="../assets/css/font-awesome.css" rel="stylesheet" />
</head>
<body>
  <html>
<head>
</head>
<body>
 <!--  <table width="100%">
    <tr><td><center><h3><b><u>Ross Feeds</u></b></h3></center></td></tr>
  </table>
  <table width="100%" style="margin-top: -20px;">
    <tr><td><center><i class="fa fa-phone" aria-hidden="true"> 0313 6644551 | 0301 5472924</i></center></td></tr>
  </table><hr> -->
  <br>
  <!-- <div style="width: 100px;">
   <img src="../bt.png" width="120px" style="margin-top:-20px">
 </div> -->
 <div style="margin-top: 0px;">
  <table width="100%">
    <tr>
      <td>
         <center><h3 style="width: 300px;"><u>
        <?php 
          $result4 = mysqli_query($con,"SELECT * FROM company");
          $fetch4 = mysqli_fetch_array($result4);
          echo $fetch4['name'];
        ?>
         </u></h3><center><i class="fa fa-phone" aria-hidden="true" style="margin-top: -10px;">  <?php echo $fetch4['phone1'] ?></i></center>
      </td>
    </tr>
  </table>
 
 </div>
  <br><br>
 <div class="box1">
<div class="nikabox1">
 <?php
 $sale_No = $_GET['sale_No'];
 $run1    = mysqli_query($con,"SELECT * FROM tcounter WHERE id='$sale_No'");
 $fetch1  = mysqli_fetch_array($run1);
 $sale_day= $fetch1['day'];
 ?>
 <div>
  <table>
    <tr>
      <th>Inv #</th>
      <th><?php echo $sale_No. " | ". $sale_day." | ". date("h:i-a"); ?></th>
    </tr>
  </table>
  <table>
    <tr>
      <th>Vch #</th>
      <th><?php echo $fetch1['voucher_no']; ?></th>
    </tr>
  </table>
</div>
</div><br>
<center><h4 style="margin-top: -22px;"><u><em>Cashout Receipt</em></u></h4></center>
<table class="main" border="1" width="100%" cellpadding="0" cellspacing="0" style="text-align: center;margin-top: -20px;">
 <tr>
  <th>Sr#</th>  
  <th>Amount Paid</th>
  <th>Paid By</th>
  <th>Remarks</th>
 </tr>
 <?php
  $run3 = mysqli_query($con,"SELECT * FROM trans WHERE bill_no='$sale_No'");
  $counter=0;$amntPaid=$remaining=0;
  while($fetch3=mysqli_fetch_array($run3)){ 
    $counter++; 
    $amntPaid += $fetch3['amount'];
    $run2 = mysqli_query($con,"SELECT * FROM accounts WHERE id='".$fetch3['account_id']."'");
    $fetch2 = mysqli_fetch_array($run2);
  ?>
 <tr>
  <td><?php echo $counter; ?></td>  
  <td><?php echo $fetch3['amount'] ?></td>
  <td><?php echo $fetch2['name'] ?></td>
  <td><?php echo $fetch3['remarks'] ?></td>
 </tr>
<?php } ?>
</table><br>
<table>
  <tr>
    <th style="text-align: left;">Total: <?php echo $amntPaid; ?></th>
  </tr>
  <tr>
    <td>Signature:________________</td>
  </tr>
</table>
<!-- <table>
  <tr><td>Net Amount: </td><td><?php echo $var; ?></td><td>|Amount Paid</td><td><?php echo $amntPaid;  ?></td></tr>
  <tr><td>Discount(%): </td><td><?php echo $dis; ?></td><td>|Remaining</td><td><?php echo $remaining ?></td></tr>
  <tr><td>Grand Total: </td><td><?php echo $total1; ?></td></tr>
</table> -->
<?php
    $query3   =   "SELECT SUM(final) AS price FROM sale WHERE 
    sale_No = '$sale_No'";
    $run3  =  mysqli_query($con,$query3);
    $fetch3 = mysqli_fetch_array($run3);
    $price =  $fetch3['price'];
    $query4 = "SELECT COUNT(sale_No) AS total
  FROM sale WHERE sale_No = '$sale_No' ";
  $run4    = mysqli_query($con,$query4);
  $fetch4  = mysqli_fetch_array($run4);
  $total   =  $fetch4['total'];
?>
 </div>
 <?php if(isset($_GET['previous']))
 {?>
<!-- <section><hr>
  <center>
    <u><h2>Mini Statement</h2></u>
    <table>
      <tr>
        <td>Previous Balance:</td><td><?php echo $_GET['previous']+0;?></td>
      </tr>
      <tr>
        <td>Today Bill:</td><td><?php echo $total1; ?></td>
      </tr>
      <tr>
        <td>Final Balance:</td><td><?php echo $_GET['totalNow']+0; ?></td>
      </tr>
    </table>
  </center>
</section> -->
 <?php } ?>
 <hr>
 <center><footer><h5>&copy; Designed by Arbaz Ehsan; 03137747660; arbazehsan988@gmail.com</h5></footer></center>
</body>
</html>