<title>Customer Ledger</title>
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
include("../header.php");include('../connect.php');include('function.php');
if (isset($_POST['btn'])) {
	$username = $_POST['username'];
	}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="checkpoint.php"><span aria-hidden="true">&larr;</span> Back</a></li>
    
  </ul>
</nav>
<center><h1>Total Product Cost  Report</h1></center><hr>
<form method="POST">
<div class="container">


<div class="row">
	<div class="col-md-3">
		<label>User Name *</label>
		<input type="text" class="form-control" name="username" value="<?php echo $username; ?>" required=""><br>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<button class="btn btn-primary" name="btn">Generate Report</button>

	</div>
	<div class="col-md-4 pull-right">
		<input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for Name..">
	</div>
</div>
</div>
</form><hr>
<div id="printableArea">
<div class="row">
	<ul>
		<li><label>User Name:</label> <u><b><?php echo $username; ?></b></u></li>
		<li><center><strong>Total Product Cost Report</strong></center>	</li>
		<li><?php date_default_timezone_set("Asia/Karachi"); ?>
		<label>Print Date: <?php echo date("Y-m-d h:i-a"); ?></label></li>
	</ul>
	
</div>
<div class="container-fluid">
<div class="row">
	<table border="1" class="table" id="myTable" width="100%">
		<thead>
		<th>Sr#</th>
		<th>Item#</th>
		<th>Name</th>
		<th>Quantity</th>
		<th>Purchase Rate</th>
		<th>Cost</th>
		</thead> 
		<tbody>
		<?php
		if (isset($_POST['btn'])) {
		
		$counter  = 0; $loss = 0;$sumQty = 0;
		$username = $_POST['username'];
		
		$result3 = mysqli_query($con,"SELECT * FROM products ");
		
		
		while($fetch3 = mysqli_fetch_array($result3))
		{    
			    $prate  = $fetch3['purchasePrice'];
			    $barcode= $fetch3['barcode'];
			    $extra  = $fetch3['urdu'];
				$pqty   = $fetch3['p_qty'];
				$sumQty = $pqty;
				if ($sumQty<0) {
					$sumQty = 0;
				}
				$sumRate= $sumQty*$prate;
				
				

				$counter++;
				
				echo '<tr>
					 <td>'.$counter.'</td>
					 <td>'.$barcode.'</td>
					 <td>'.$extra.'</td>
					 <td>'.$sumQty.'</td>
					 <td>'.$prate.'</td>
					 <td>'.$sumRate.'</td>
					</tr>';
					$sum2 = $sum2 + $sumRate;
			

		?>
		

	<?php  } } ?>
	</tbody><tr><td colspan="4"></td><td><b>Total</b></td><td style="border:2px solid black"><?php echo $sum2; ?></td></tr>
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

function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
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
