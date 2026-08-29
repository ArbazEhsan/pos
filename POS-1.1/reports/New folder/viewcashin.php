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
include("../header.php");include('../connect.php');
if (isset($_POST['btn']))
 { 
	 $startdate = $_POST['startdate'];
	 $enddate   = $_POST['enddate'];
}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="checkpoint.php"><span aria-hidden="true">&larr;</span> Back</a></li>
    
  </ul>
</nav>
<center><h1>View Cash In</h1></center><hr>
<form method="POST">
<div class="container">
	
<div class="row">
	<div class="col-md-3">
		<label>To Date *</label>
		<input type="date" class="form-control" name="startdate" value="<?php echo $startdate; ?>"><br>
	</div>
	<div class="col-md-3">
			<label>From Date *</label>
		<input type="date" class="form-control" name="enddate" value="<?php echo $enddate; ?>"><br>
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
<div class="row">
	<ul>
		<li><center><strong>Cashin Report</strong><u></center></li>
		<li>
		<label>Report: <?php echo $startdate.' to '.$enddate;?></label></li>
	</ul>
</div>
<div class="container-fluid">
<div class="row">
	<table border="1" class="table" id="myTable" width="100%">
		<thead>
		<th>Sr#</th>
		<th>Day</th>
		<th>Sale Inv#</th>
		<th>Customer</th>
		<th>Naration</th>
		<th>Amount</th>
		</thead> 
		<tbody>
		<?php
	if (isset($_POST['btn']))
 	{ 
 	$counter=0;$sum = 0;
  	$result1 = mysqli_query($con,"SELECT * FROM cashin WHERE  day BETWEEN '$startdate' AND '$enddate' ORDER BY day");
  	 while($fetch1=mysqli_fetch_array($result1))
  	 {	
  	    	$counter++;
  	 		$result3 = mysqli_query($con,"SELECT * FROM customer WHERE id='".$fetch1['customer']."'");
  	 		$fetch3=mysqli_fetch_array($result3);
  	 		?>
  	 	<tr>
	       	<td><?php echo $counter; ?></td>
	       	<td><?php echo date("d-m-Y", strtotime($fetch1['day'])); ?></td>
	       	<td onclick="invoice(this.innerHTML)"><?php echo $fetch1['invoiceNo'] ?></td>
	       	<td><?php echo $fetch3['name']; ?></td>
	       	<td style="width: 400px;"><?php echo $fetch1['naration']; ?></td>
	       	<td><?php echo $fetch1['amount']; ?></td>
	       	
	       
       </tr>
<?php $sum = $sum + $fetch1['amount']; 	 }
}?>
	</tbody><tr><td colspan="4"></td><td class="pull-right"><b>Total</b></td><td style="border:2px solid black;font-weight: bold;"><?php echo $sum; ?></td></tr>
	</table>
</div>
</div>
</div><!-- print button div end -->
<input type="button" class="btn btn-info" onclick="printDiv('printableArea')" value="Print" />
<?php 
include("../footer.php");
?>
<script type="text/javascript">
	function invoice(str)
	{
		window.open('../2/print.php?sale_No='+str,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
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
