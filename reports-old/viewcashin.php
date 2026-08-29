 <script type="text/javascript">
	function invoice(str,source)
	{
		if (source=='SV') {
			window.open('../2/print.php?sale_No='+str,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
		}
		else {
			window.open('../trans/printcashin.php?sale_No='+str,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
		}
		
	}
</script>
 <title>View Cashin</title>
<style type="text/css">
	ul li{
		float: left;
		list-style: none;
		margin-right: 5%;
		line-height: 10px;
		margin-bottom: 10px;
	}

#myTable th, #myTable td {
    text-align: left; /* Left-align text */
    padding: 12px; /* Add padding */
}

#myTable tr {
    /* Add a bottom border to all table rows */
    border-bottom: 1px solid #ddd; 
}

#myTable tr.header, #myTable tr:hover {
    /* Add a grey background color to the table header and on hover */
    background-color: #f1f1f1;
}
</style>
<body onload="focus()">
<?php 
session_start();
include("../header.php");include('../connect.php');
if (isset($_POST['btn']))
 { 
	 $startdate = $_POST['startdate'];
	 $enddate   = $_POST['enddate'];
}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
    
  </ul>
</nav>
<center><h1>View Cash In</h1></center><hr>
<form method="POST">
<div class="container">
	
<div class="row">
	<div class="col-md-3">
		<label>To Date<span style="color: red;">*</span></label>
		<input type="date" class="form-control" name="startdate" value="<?php echo $startdate; ?>" required><br>
	</div>
	<div class="col-md-3">
			<label>From Date<span style="color: red;">*</span></label>
		<input type="date" class="form-control" name="enddate" value="<?php echo $enddate; ?>" required><br>
	</div>
	
</div>
<div class="row">
	<div class="col-md-4">
		<button class="btn btn-primary" name="btn">Generate Report</button>

	</div>
	<div class="col-md-4 pull-right">
		<input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for Customer..">
	</div>
</div>
</div>
</form><hr>
<div id="printableArea">
<!-- <div class="row">
	<ul>
		<li><center><strong>Cashin Report</strong><u></center></li>
		<li>
		<label>Report: <?php echo $startdate.' to '.$enddate;?></label></li>
	</ul>
</div> -->
<div class="container-fluid">
	<div class="row">
	<table border="0" width="98%" align="center">
		<tr >
			<td style="width: 18%">115</td>
			<td style="text-align: center;">
			<?php 
				$result4 = mysqli_query($con,"SELECT * FROM company");
				$fetch4 = mysqli_fetch_array($result4);
				echo $fetch4['name'];
			?>
			</td>
			<td style="float: right;">From: <?php if($_POST['startdate']!=''){
				echo date("d/m/Y", strtotime($_POST['startdate']));
			}else { echo date("d/m/Y"); } ?></td>
		</tr>
		<tr>
			<td><?php echo $_SESSION['name']; ?></td>
			<td style="text-align: center;">Cashin</td>
			<td style="float: right;">To: <?php if($_POST['enddate']!=''){
				echo date("d/m/Y", strtotime($_POST['enddate']));
			}?></td>
		</tr>
	</table>
</div><br>
<div class="row">
	<table border="1" width="100%" class="table table-striped">
		<thead>
			<tr>
				<th>Sr#</th>
				<th>Date</th>
				<th>Inv#</th>
				<th>Customer</th>
				<th>Remarks</th>
				<th>Amount</th>
			</tr>
		</thead> 
		<tbody>
		<?php
	if (isset($_POST['btn']))
 	{ 
 	$counter=0;$sum = 0;
  	$result1 = mysqli_query($con,"SELECT * FROM trans WHERE day BETWEEN '$startdate' AND '$enddate' AND type='SV' OR type='CR' ORDER BY day");
  	 while($fetch1=mysqli_fetch_array($result1))
  	 {	
  	    	$counter++;
  	 		$result3 = mysqli_query($con,"SELECT * FROM accounts WHERE id='".$fetch1['account_id']."'");
  	 		$fetch3=mysqli_fetch_array($result3);

  	 		$invoiceNo = $invTxt = '';
  	 		// $invoiceNo = $fetch1['id'];
  	 		// $invTxt = $fetch1['type'];
	        if($fetch1['type']=='CR'){
	          $invoiceNo = $fetch1['bill_no'];
	          $invTxt = 'CR';
	        }
	        else {
	          $invoiceNo = $fetch1['invoice_id'];
	          $invTxt = 'SV';
	        }
  	 	?>
  	 	<tr>
	       	<td><?php echo $counter; ?></td>
	       	<td><?php echo date("d-M-Y", strtotime($fetch1['day'])); ?></td>
	       	<td onclick="invoice(this.innerHTML,'<?php echo  $invTxt ?>')"><?php echo  $invoiceNo ?></td>
	       	<td><?php echo $fetch3['name']; ?></td>
	       	<td><?php echo $fetch1['remarks']; ?></td>
	       	<td><?php echo number_format($fetch1['amount'],0); ?></td>
	       	
	       
       </tr>
<?php $sum = $sum + $fetch1['amount']; 	 }
}?>
	</tbody><tr style="border: 1px solid black; border-right: none; border-left: none;"><td colspan="4"></td><td class="pull-right"><b>Total</b></td><td style="border:2px solid black;font-weight: bold;"><?php echo number_format($sum,0); ?></td></tr>
	</table>
</div>
</div>
</div><!-- print button div end -->
<input type="button" class="btn btn-info" onclick="printDiv('printableArea')" value="Print" />
<?php 
include("../footer.php");
?>


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

function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>
