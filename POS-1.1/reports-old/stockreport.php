 <title>Stock Report</title>
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
<center><h1>Stock Report</h1></center><hr>
<form method="POST">
<div class="container">
	
<div class="row">
	<div class="col-md-3">
		<label>Product</label>
		<input list="group"  id="pId" name="product" class="form-control" placeholder="Name" autocomplete="off">
	        <datalist id="group">
	        <span class="caret"></span></button>
	        <ul class="dropdown-menu" role="menu">
               <?php
                $sql="SELECT * FROM products";
                $result=mysqli_query($con,$sql);
                 while($fetch=mysqli_fetch_array($result))
                  {
                  ?> 
               <option value="<?php echo $fetch['name'];?>"><?php echo $fetch['name'];?> </option>
               <?php } ?>
            </ul>
            </datalist><br>
	</div>
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
	<!-- <div class="col-md-4 pull-right">
		<input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for Customer..">
	</div> -->
</div>
</div>
</form><hr>
<div id="printableArea">

<div class="container-fluid">
	<div class="row">
	<!-- <ul>
		<li><center><strong>Sales And Stock Statement By Product</strong><u></center></li>
		<li>
		<label>Report: <?php echo $startdate.' to '.$enddate;?></label></li>
	</ul> -->
	<table border="0" width="98%" align="center">
		<tr >
			<td>115</td>
			<td style="text-align: center;">NARC, Islamabad, SAC & PATCO, Dairy Products</td>
			<td style="float: right;">From: 4/17/21</td>
		</tr>
		<tr>
			<td>Milk 1 Liter</td>
			<td style="text-align: center;">Sales And Stock Statement By Product</td>
			<td style="float: right;">To: 4/17/21</td>
		</tr>
	</table>
</div><br>
<div class="row">
	<table border="0" class="table-striped" id="myTable" width="100%">
		<thead style="border: 1px solid black; border-left: none;border-right: none;">
			<th>Date</th>
			<th>PID</th>
			<th>Name</th>
			<!-- <th>Open</th> -->
			<!-- <th>Purchase</th> -->
			<!-- <th>Production</th> -->
			<!-- <th>Sale Rtn.</th> -->
			<th>Total Stk.</th>
			<th>Sales</th>
			<!-- <th>Mixing</th> -->
			<!-- <th>Pur. Rtn.</th> -->
			<th>Clos. Stk</th>
		</thead> 
		<tbody>
		<?php
		if (isset($_POST['btn'])){
			$name = $_POST['product'];
	 		$startdate = $_POST['startdate']; 
	 		$enddate = $_POST['enddate'];
	 		if ($name!='' && $startdate!='' && $enddate!='') {
	 			$sql = "SELECT stock.*,products.name FROM stock INNER JOIN products ON stock.barcode=products.id ORDER BY stock.day";
	 		}
	 		elseif ($name!='' && $startdate=='' && $enddate=='') {
	 		}
	 		elseif ($name=='' && $startdate!='' && $enddate!='') {
	 		}
	 		elseif ($name=='' && $startdate=='' && $enddate=='') {
	 			$sql = "SELECT stock.*,products.name FROM stock INNER JOIN products ON stock.barcode=products.id ORDER BY stock.day";
	 		}
		 	$counter=$sum=$sum1=$sum2=0;
		 	$result1 = mysqli_query($con,$sql);
		  	while($fetch1=mysqli_fetch_array($result1)){
		  		$result1 = mysqli_query($con,"SELECT * FROM sale WHERE barcode='".$fetch1['barcode']."'");	
		  	    $counter++;
		  	    $sum += $fetch1['qty'];
		  	    $sum1 += $fetch1['qty'];
		  	    $sum2 += $fetch1['qty'];
		  	    ?>
		  	 	<tr>
			       	<td><?php echo date("d/m/Y", strtotime($fetch1['day'])); ?></td>
			       	<td><?php echo $fetch1['barcode']; ?></td>
			       	<td><?php echo $fetch1['name']; ?></td>
			       	<td><?php echo $fetch1['qty']; ?></td>
			       	<td><?php echo $fetch1['name']; ?></td>
			       	<td><?php echo $fetch1['name']; ?></td>
		       </tr>
		<?php }}?>
		</tbody>
		<tr>
			<td colspan="2"></td>
			<td><b>Total</b></td>
			<td style="border:2px solid black;font-weight: bold;"><?php echo $sum; ?></td>
			<td style="border:2px solid black;font-weight: bold;"><?php echo $sum1; ?></td>
			<td style="border:2px solid black;font-weight: bold;"><?php echo $sum2; ?></td>
		</tr>
	</table>
</div>
</div>
</div><!-- print button div end --><br>
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
