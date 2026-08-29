<title>Sale Invoice Print</title>
<?php
include("../connect.php");
include("../converter.php");
?>
<style type="text/css">
  .lower{
    border-left:1px solid black;
  }
  .main td{
    font-size: 14px;
  }
  .header1{
    width: 60%;
    float: left;
    height: 30px;
    color: white;
  }
  .header1 td{
    text-align: right;
    color: white;
  }
  .header2{
    width: 37%;
    float: left;
    font-weight: bold;
    text-align: right;
    color: white;
  }
  .header2 hr{
    margin-top: 9px;
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
  <br>
  
 <?php
 if(isset($_GET['sale_No']))
 {
  $sale_No=$_GET['sale_No'];
  
  $sql1     = "SELECT * FROM scounter WHERE id = '$sale_No'";
  $result1   = mysqli_query($con,$sql1);
  $fetch1    = mysqli_fetch_array($result1);
  $day = $fetch1['sale_day']; 
  $customer = $fetch1['customer'];
  $result2  = mysqli_query($con,"SELECT * FROM accounts WHERE id='$customer'");
  $fetch2   = mysqli_fetch_array($result2);
  $sql      = "SELECT * FROM scounter WHERE id='$sale_No'";
  $result   = mysqli_query($con,$sql);
  $fetch    = mysqli_fetch_array($result);
 }
 date_default_timezone_set("Asia/Karachi");
 ?>
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
 
  <table class="">
   <br><br>
    <tr><td><h4>Order No: </h4></td><td><h4><?php echo $sale_No. " | ". date("d-m-Y", strtotime($day))." | ". date("h:i-a"); ?></h4></td></tr>
    <!-- <tr><td><h4>Date :</h4></td><td><h4><?php echo $day; ?></h4></td></tr> -->
  </table>
  

</div>
<div class="party">
 <?php
 mysqli_set_charset($con,"utf8");
 ?>
 <table style="margin-top: -20px;">
   <tr><th>Customer :</th><td><?php echo $fetch2['name']." (".$fetch['referal'].")"; ?></td><th>| Address :</th><td><?php echo $fetch2['address']; ?></td></tr>
</table>

</div>
<br>
<center><h3 style="margin-top: -20px;"><u><em>Sale Invoice</em></u></h3></center>
<table class="main" border="1" width="100%" cellpadding="0" cellspacing="0" style="text-align: center;margin-top: -15px;">
 <tr>
   
   <!-- <th>ITEM ID</th> -->
   <th>Sr#</th>
   <th>Product Name</th>
   <th>Qty</th><!-- <th colspan="3">Detail-Eff-Rate</th> --> 
   <th>price</th>  
   <th>Final</th>
 </tr>
 <?php
 $total1=0;
 $dis=0;
      $query3   =   "SELECT * FROM sale WHERE sale_No = '$sale_No' ";
      $run3     =   mysqli_query($con,$query3);
      $counter  =0;$itemDiscount=0;$totalQty=0;$finalValue=0;
      while($fetch3 =  mysqli_fetch_array($run3))
      { $counter++;
             
  ?>
 <tr>
  <td> <?php echo $counter;?> </td>
  <td> <?php  echo getProductName($fetch3['barcode']);?> </td>
  <td><?php echo $fetch3['qty'];?></td>
  <td><?php echo $fetch3['price'];?></td>
  <td><?php echo $fetch3['qty']*$fetch3['price']; ?></td>
   <?php
   $dis = $fetch3['discount'];
   $total1 = $fetch3['grossId'];
   $finalValue=$fetch3['finalValue'];
   $received = $fetch3['received']+0;
   $remaining  = $fetch3['remaining']+0;
   ?>
 </tr>
<?php } ?>
</table><br>
<div style="width: 25%;float: left;">
<table width="100%" cellpadding="0" border="0" cellspacing="0" style="" >
  <tr>
  <td>Gross Amount: </td>
    <td><?php echo $total1; ?></td>
        <!-- <td class="lower">&nbsp;Grand Total:</td>
    <td><b><?php echo $finalValue; ?></b></td> -->
  </tr>
  <tr>
  <td>Disc:</td>
  <td><?php echo $dis; ?></td>
</tr>
<tr>
  <td>Final Amount:</td>
  <td><?php echo $finalValue; ?></td>
</tr>

  <tr><td>Advance:</td><td><?php echo $received; ?></td>
  </tr>
  <tr>
    <td>Remaining:</td><td><?php echo $remaining; ?></td>
    
  </tr>
</table>
</div>
<div style="width: 74%;float: right;">
  <br><br>
  <span style="float: right;">Signature:__________________</span>
</div>
 
 <div style="width: 100%;float: left;margin-top: 20px;border-top:1px solid black; ">
  <center><footer><h6>&copy; <span style="font-family: sans">Designed by Arbaz Ehsan; 03137747660; arbazehsan988@gmail.com</span></h6></footer></center>
 </div>
</body>
</html>