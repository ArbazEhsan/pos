<title>Customer Ledger</title>
<?php session_start();
if( ($_SESSION['username']=='') && ($_SESSION['password']==''))
{
    header("Location:../index.php?msg=Please Login to Continue");
}
 ?>
<?php include("../header.php");include('../connect.php');
$day1 = $_POST['day1'];
$day2 = $_POST['day2'];
$cust = $_POST['customer'];
$t    = $_POST['t'];
if($day1=='' && $day2=='')
{
$style = "none";
}
else
{
	$style = "inline";
}
if($t=='vender')
{
	$new = 'Vender';
}
elseif($t=='customer')
{
	$new = 'Customer';
	
}
$result = mysqli_query($con,"SELECT * FROM customer WHERE name='$cust'");
if(mysqli_num_rows($result)<=0)
{
	header("location:checkpoint.php?msg=Customer Not Found. Please add this customer first");
}
else{
$fetch = mysqli_fetch_array($result);
$customer = $fetch['id'];
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="checkpoint.php?t=<?php echo $t?>"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body onload="focus1()">
</nav>
<div class="container-fluid">
<div class="row"  id="printableArea">
		<center><h1>Ross Feeds</h1></center>
		<center><h3  style="margin-top: -12px;">
		<i class="fa fa-phone" aria-hidden="true"> 0313 6644551 | 0301 5472924</i></h3></center>
		<pre style="margin-top: -10px;">
			<h3><?php echo $new; ?>: <?php echo $fetch['name'].' '.$fetch['address'] ?>
			<span style="display:<?php echo $style;?>"> | Ledger From: <?php echo date("d-m-Y", strtotime($day1)).'  To  '. date("d-m-Y", strtotime($day2)) ?></span>
		</pre>
<table  border="1" class="main" width="100%" align="center">
	<thead>
	<tr>
		<th>Date</th>
		<th>Naration</th>
		<th>Invoice#</th>
		<th>Debit</th>
		<th>Credit</th>
		<th>Balance</th>
	</tr>
	</thead>
	<?php
	$sql2 = "SELECT * FROM customerledger WHERE customer = '$customer' && naration = 'Opening Balance' ";	
	 $result2 = mysqli_query($con,$sql2);
	 $fetch2  = mysqli_fetch_array($result2);	
	 $debit = $cr = 0; 
	 if($fetch2['cr']=='')
	 {
	 	$type = $fetch2['db'];
	 	$debit= $fetch2['db']-$cr;
	 	$text = 'Rcvble';
	 }
	 else
	 {
	 	$cr = $type = $debit - $fetch2['cr'];
	 	$text = 'Payable';
	 }
	 ?>
	 <tbody>
	 <tr>
	 			<td colspan="5" class="text-right"><b>Opening Balance</b></td>
	 			<td align="center"><b><?php  $balance = $type;
	 			   echo str_replace("-", "",$balance)." ("."$text)";
	 			   ?></b></td>

	 </tr>
	 <?php
	 if($customer!='' && $day1=='' && $day2=='')
	 {
	 	$sql1 = "SELECT * FROM customerledger WHERE customer = '$customer' && naration != 'Opening Balance' ORDER BY day";		 	
	 }
	 else
	 {
	 	$sql1 = "SELECT * FROM customerledger WHERE customer = '$customer' && naration != 'Opening Balance' && day BETWEEN '$day1' AND '$day2' ORDER BY day";
	 }
	 $result1 = mysqli_query($con,$sql1);
	 $sum     = 0;
	 $counter = 0;	 
	 while($fetch1 = mysqli_fetch_array($result1))
	 {
	 	if($fetch['naration']=='Opening Balance')
	 	{
	 		
	 	}
	 	else
	 	{
	 	
			if($fecth1['db']>0 && $fetch1['cr']=='0' || $fetch1['cr']=='')
			 	{
			 		$balance = $balance+$fetch1['db'];
			 	}
			 	else if($fecth1['cr']>0 && $fetch1['db']=='0' || $fetch1['db']=='')
			 	{
			 		$balance = $balance-$fetch1['cr'];
			 	}
			 	$debit = $debit+$fetch1['db'];
			 	$cr    = $cr+$fetch1['cr'];
	 	}
	 ?>
	<tr>
		<td><?php echo date("d-m-Y", strtotime($fetch1['day'])); ?></td>
		<td style="width:400px;"><?php echo $fetch1['naration']; ?></td>
		<td><?php echo $fetch1['invoiceNo'] ?></td>
		<td><?php echo number_format($fetch1['db'],2); ?></td>
		<td><?php echo number_format($fetch1['cr'],2); ?></td>
		<td><?php echo number_format(str_replace("/","",$balance),2); ?></td>
		
	</tr>
	<?php } ?>
		<tr>
			<td><b></b></td>
			<td></td>
			<td><b>Total</b></td>
			<td><b><?php echo number_format($debit,2); ?> </b></td>
			<td><b><?php echo number_format(str_replace("-","",$cr),2); ?></b></td>
			<td style="text-align: left;font-size: 21px;font-weight: bolder;">
              <?php
        if($balance<0)
        {
        	echo $balance."(Payable)";
        }

        else{

                echo $balance."(Receivable)";
            }       
              ?>
			 </td>
			
		</tr>
		</tbody>
</table>

<center><strong>&copy; XpertWay Solutions (03036911502)</strong></center>
</div><!-- print div end -->
<div class="row">
      <br><input type="button" class="btn btn-primary btn-lg" onclick="printDiv('printableArea')" value="Print" />
    </div>
</div><!-- contaienr fulid -->
<?php } ?>
<?php include("../footer.php"); ?>
<script type="text/javascript">
  function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
