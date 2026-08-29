
 <title>Return Sale Invoice Print</title>
<?php
include("../connect.php");

?>
<!-- <style>
  @media (max-width: 600px){
    .main{
      width: 80%;
    }
    .party{
    
    }
  }
</style> -->
<style type="text/css">
  .lower{
    border-left:1px solid black;
  }
  .main td{
    font-size: 14px;
  }
  @media (max-width: 600px){
  .main td{
    font-size: 12px;
  }
}
</style>
<!DOCTYPE html>
<html>
<head>
  <link href="../assets/css/font-awesome.css" rel="stylesheet" />
</head>
<body>
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
         </u></h3><i class="fa fa-phone" aria-hidden="true" style="margin-top: -10px;">  <?php echo $fetch4['phone1'] ?></i></center>
      </td>
    </tr>
  </table>
 
 </div>
 <div class="box1">
<div class="nikabox1">
 <?php
 if(isset($_GET['sale_No']))
 {
  $sale_No  = $_GET['sale_No'];
  $sql1     = "SELECT * FROM rscounter WHERE id = '$sale_No'";
  $result1   = mysqli_query($con,$sql1);
  $fetch1    = mysqli_fetch_array($result1);
  $sale_day = $fetch1['day'];
  $customer = $fetch1['customer'];
  $sql      = "SELECT * FROM sale WHERE sale_No='$sale_No'";
  $result   = mysqli_query($con,$sql);
  $fetch    = mysqli_fetch_array($result);
 }
 date_default_timezone_set("Asia/Karachi");
 ?>
 <div>
  <script type="text/javascript">
  function printHide(argument) {
    document.getElementById('hide').style.visibility = 'hidden';
    window.print();
  }
</script>
  <table class=""><br><br>
    <tr><td><h4>Sale # </h4></td><td><h4><?php echo $sale_No. " | ". $sale_day." | ". date("h:i-a"); ?></h4></td></tr>
    <!-- <tr><td><h4>Date :</h4></td><td><h4><?php echo $sale_day; ?></h4></td></tr> -->
  </table>
</div>
</div>
<div class="party">
 <?php
 mysqli_set_charset($con,"utf8");
  $query2   =   "SELECT * FROM accounts WHERE id = '$customer'";
  $run2     =    mysqli_query($con,$query2);
    while($fetch2   =   mysqli_fetch_array($run2))
    {
 ?>
 <table style="margin-top: -20px;">
   <tr><td><h5>Customer :</h5></td><td><h4><?php echo $fetch2['name'] ?></h4></td></tr>
</table>
<table style="margin-top: -20px;">
   <tr><th><h5>Reference: </h4></th><td><u><h5><?php echo $fetch1['ref'] ?></h5></u></td></tr>
 </table>
</div>
<?php } ?>
<center><h3 style="margin-top: -20px;"><u><em>Return Sale Invoice</em></u></h3></center>
<table class="main" border="1" width="100%" cellpadding="0" cellspacing="0" style="text-align: center;margin-top: -15px;">
 <tr>
   <th>Sr #</th>
   <th>Qty</th>
   <th>Item</th>
   <th>Price</th>
   <th>Total</th>
 </tr>
 <?php
      $query3   =   "SELECT * FROM returnsale WHERE sale_No = '$sale_No' ";
      $run3     =   mysqli_query($con,$query3);$counter=0;$totalQty=0;$payable=$paid=$remain=0;
      while($fetch3 =  mysqli_fetch_array($run3))
      { $counter++;
       $paid = $fetch3['amnt_Paid']; $remain = $fetch3['remaining'];
        $test4     = $fetch3['barcode'];
        mysqli_set_charset($con,'utf8');
        $query4   =  "SELECT * FROM products WHERE id = '$test4'";
        $run4     =  mysqli_query($con,$query4);
        $fetch4   =  mysqli_fetch_array($run4);
  ?>
 <tr>
  <td><?php echo $counter; ?></td>
  <td><?php echo $fetch3['qty']; ?></td>
  <td><?php echo $fetch4['name'] ?></td>
  <td><div><?php echo $fetch3['price']; ?></div></td>
  <td><?php echo $fetch3['qty']*$fetch3['price'] ?></td>
  <?php
   $payable   = $payable + ($fetch3['price']*$fetch3['qty']);
   $totalQty  = $totalQty+$fetch3['qty'];
   ?>
 </tr>
<?php } ?>
</table>
  <table width="100%" cellpadding="0" cellspacing="0" style="" >
  <tr>
    <td>T.Items:</td>
    <td><?php echo $counter; ?> | </td>
    <td>Qty:</td>
    <td><?php echo $totalQty; ?> | </td>
  
  </tr>
  <tr>
    
    <td>Amount Paid: </td>
    <td><?php echo $paid; ?> |</td>
    <td>Remaining: </td>
    <td><?php echo $remain; ?> |</td>
    <td>Grand Total:</td>
    <td><?php echo $payable ?></td>
  </tr>
  
  <tr>
    <!-- <td>Items Disc</td>
    <td><?php echo $itemDiscount; ?></td>
    <td  class="lower">Grand Total: </td>
    <td><?php echo $total1; ?></td> -->
  </tr>
</table>
<?php
    $query3   =   "SELECT SUM(finalValue) AS price FROM sale WHERE 
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
<section><hr>
  <center>
    <u><h2>Mini Statement</h2></u>
    <table>
      <tr>
        <td>Previous Balance:</td><td><?php echo $_GET['previous'];?></td>
      </tr>
      <tr>
        <td>Today Bill:</td><td><?php echo $total1; ?></td>
      </tr>
      <tr>
        <td>Final Balance:</td><td><?php echo $_GET['totalNow']; ?></td>
      </tr>
    </table>
  </center>
</section>
 <?php } ?>
 <hr>
 <center><footer><h6><br>&copy;<span style="font-family: sans;"> Designed by Arbaz Ehsan; 03137747660; arbazehsan988@gmail.com</span></h6></footer></center>
</body>
</html>