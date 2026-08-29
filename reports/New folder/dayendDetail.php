<title>Day End Detail Report</title>
  
<body onload="focus()">
<?php 
include("../header.php");include('../connect.php');include('../converter.php');
if (isset($_POST['btn'])) {	
	$day = $_POST['day'];
	}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="checkpoint.php"><span aria-hidden="true">&larr;</span> Back</a></li>
    
  </ul>
</nav>
<style type="text/css">
	.label-header{
    width: 100%;
    height: 35px;
    border-radius: 20px;
    background-color: #E0E0E0;
    color:black;
    margin-top: -10px;
  }
  .main td{
    font-size: 14px;
  }
  th{
  	text-align: center;
  }
  .naration{
  	width: 300px;
  }
</style>
<center><h1>Day End Detail Report</h1></center><hr>
<form method="POST">
<div class="container">
<div class="row">
	<div class="col-md-3">
		<label>Select Date</label>
		<input type="date" class="form-control" name="day" value="<?php echo $day; ?>" required=""><br>
	</div>
	<div class="col-md-3"><br>		
		<button class="btn btn-primary" name="btn">Generate Report</button>
	</div>
</div>

</div>
</form><hr>
<div class="container-fluid">
	<div id="printableArea">
	<div class="row">
	<div class="col-md-12">
	
  			<center><h2>Day End Report  <u><?php echo date("d-m-Y", strtotime($day))?></u></h2></center>
		
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="label-header">
  			<center><h2>Today Sale</h2></center>
		</div>
	</div>
</div>

	
<div class="row">
	<div class="col-md-12">
		<table class="main" border="1" width="100%" cellpadding="0" cellspacing="0" style="text-align: center;margin-top: 10px;">
			<thead>
			<tr>
			<th>Sr#</th>
			<th>Sale#</th>
			<th>Vehicle#</th>
			<th>Customer</th>
			<th>Naration</th>
			<th>Total</th>
			<th>Paid</th>
			<th>Remaining</th>			
			</tr>
			</thead>
			<tbody>
			 <?php $c = 0;			 
			 	$r = mysqli_query($con,"SELECT * FROM scounter WHERE sale_day = '$day'");
			 	while($fetch = mysqli_fetch_array($r))
			 	{ $c++;
			 		$r1 = mysqli_query($con,"SELECT * FROM sale WHERE sale_No='".$fetch['id']."'");
			 		$fetch1 = mysqli_fetch_array($r1);
			 		echo "<tr>".
			 				"<td>".$c."</td>".
			 				"<td>".$fetch['id']."</td>".
			 				"<td>".$fetch['referal']."</td>".
			 				"<td>".getCustomerName($fetch['customer'])."</td>".
			 				"<td class='naration'>".$fetch['naration']."</td>".
			 				"<td>".$fetch1['finalValue']."</td>".
			 				"<td>".$fetch1['amntPaid']."</td>".
			 				"<td>".$fetch1['remaining']."</td>".
			 		     "</tr>";
			 	}
			 ?>
			</tbody>
			<tfoot></tfoot>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="label-header">
  			<center><h2>Today Purchase</h2></center>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="main" border="1" width="100%" cellpadding="0" cellspacing="0" style="text-align: center;margin-top: 10px;">
			<tr>
			<th>Sr#</th>
			<th>Purchase#</th>
			<th>Vehicle#</th>
			<th>Vender</th>
			<th>Naration</th>
			<th>Total</th>
			<th>Paid</th>
			<th>Remaining</th>			
			</tr>
			 <?php $c2 = 0;			 
			 	$r2 = mysqli_query($con,"SELECT * FROM counter WHERE sale_day = '$day'");
			 	while($fetch2 = mysqli_fetch_array($r2))
			 	{ $c2++;
			 		$r3 = mysqli_query($con,"SELECT * FROM purchase WHERE sale_No='".$fetch2['id']."'");
			 		$fetch3 = mysqli_fetch_array($r3);
			 		echo "<tr>".
			 				"<td>".$c2."</td>".
			 				"<td>".$fetch2['id']."</td>".
			 				"<td>".$fetch2['referal']."</td>".
			 				"<td>".getCustomerName($fetch2['customer'])."</td>".
			 				"<td class='naration'>".$fetch2['naration']."</td>".
			 				"<td>".$fetch3['finalValue']."</td>".
			 				"<td>".$fetch3['amntPaid']."</td>".
			 				"<td>".$fetch3['remaining']."</td>".
			 		     "</tr>";
			 	}
			 ?>
		</table>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="label-header">
  			<center><h2>Today Credit's</h2></center>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="main" border="1" width="100%" cellpadding="0" cellspacing="0" style="text-align: center;margin-top: 10px;">
			<tr>
			<th>Sr#</th>
			<th>Sale#</th>
			
			<th>Amount</th>
			<th>Customer</th>
			
			<th>Naration</th>			
			</tr>
			 <?php $c3 = 0;			 
			 	$r4 = mysqli_query($con,"SELECT * FROM cashin WHERE day = '$day'");
			 	while($fetch4 = mysqli_fetch_array($r4))
			 	{ $c3++;
			 		// $r3 = mysqli_query($con,"SELECT * FROM purchase WHERE sale_No='".$fetch2['id']."'");
			 		// $fetch3 = mysqli_fetch_array($r3);
			 		echo "<tr>".
			 				"<td>".$c3."</td>".
			 				"<td>".$fetch4['invoiceNo']."</td>".
			 				
			 				"<td>".$fetch4['amount']."</td>".		 				
			 				"<td>".getCustomerName($fetch4['customer'])."</td>".
			 				
			 				"<td>".$fetch4['naration']."</td>". 				
			 		     "</tr>";
			 	}
			 ?>
		</table>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="label-header">
  			<center><h2>Today Debit's</h2></center>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="main" border="1" width="100%" cellpadding="0" cellspacing="0" style="text-align: center;margin-top: 10px;">
			<tr>
			<th>Sr#</th>
			<th>Purchase#</th>
			
			<th>Amount</th>
			<th>Vender</th>
			
			<th>Naration</th>			
			</tr>
			 <?php $c5 = 0;			 
			 	$r5 = mysqli_query($con,"SELECT * FROM cashout WHERE day = '$day'");
			 	while($fetch5 = mysqli_fetch_array($r5))
			 	{ $c5++;
			 		// $r3 = mysqli_query($con,"SELECT * FROM purchase WHERE sale_No='".$fetch2['id']."'");
			 		// $fetch3 = mysqli_fetch_array($r3);
			 		echo "<tr>".
			 				"<td>".$c5."</td>".
			 				"<td>".$fetch5['invoiceNo']."</td>".
			 				
			 				"<td>".$fetch5['amount']."</td>".		 				
			 				"<td>".getCustomerName($fetch5['customer'])."</td>".
			 				
			 				"<td>".$fetch5['referal']."</td>". 				
			 		     "</tr>";
			 	}
			 ?>
		</table>
	</div>
</div>
</div><!-- container-fluid -->
</div>
<br>
<input type="button" class="btn btn-info" style="margin-left: 10px;" onclick="printDiv('printableArea')" value="Print" />

<script type="text/javascript">
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

















<?php 
include("../footer.php");
?>

<script type="text/javascript">
	function invoice(str)
	{
		window.open('../sale/print.php?sale_No='+str,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
	}
</script>

<script type="text/javascript">
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
function focus()
{
	$('#vendorId').focus();
}

</script>
