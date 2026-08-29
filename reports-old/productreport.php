<title>Product Wise Report</title>
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
include("../header.php");include('../connect.php');include('function.php');
if (isset($_POST['btn'])) {
	
	$product = $_POST['product'];
	$today = $_POST['startdate'];
	$fromday = $_POST['enddate'];
}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
    
  </ul>
</nav>
<center><h1>Product Report</h1></center><hr>
<form method="POST">
<div class="container">
<div class="row">
	<div class="col-md-3">
		<label>To Date<span style="color: red;">*</span></label>
		<input type="date" class="form-control" name="startdate" value="<?php echo $today; ?>" required><br>
	</div>
	<div class="col-md-3">
		<label>From Date<span style="color: red;">*</span></label>
		<input type="date" class="form-control" name="enddate" value="<?php echo $fromday; ?>" required><br>
	</div>
	<div class="col-md-3">
		<label>Product</label>
		<select class="form-control" name="product" value="<?php echo $product; ?>" required>
		<option value="0" disabled selected>--- Select ---</option>
		<?php 
          $sql="SELECT * FROM products WHERE active='1' ORDER BY name";
          $result=mysqli_query($con,$sql);
          while($fetch=mysqli_fetch_array($result)){
          echo "<option value=".$fetch["id"].">".$fetch["name"]."</option>";}  ?>
		</select><br>
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
			<td style="text-align: center;">Product Wise</td>
			<td style="float: right;">To: <?php if($_POST['enddate']!=''){
				echo date("d/m/Y", strtotime($_POST['enddate']));
			}?></td>
		</tr>
	</table>
</div><br>
<div class="row">
	<table border="1" class="table" id="myTable" width="100%">
		<thead>
			<tr>
				<th>Product</th>
				<th>PID</th>
				<th>Supplier</th>
				<th>Purchase Qty</th>
				<th>Sale Qty</th>
			</tr>
		</thead> 
		<tbody>
		<?php
		if (isset($_POST['btn'])) {
		
			$counter = $sum = $sump = 0;
			$product = $_POST['product'];
			$today = $_POST['startdate'];
			$fromday = $_POST['enddate'];

			if($product!='' && $today!='' && $fromday !=''){

				$result2 = mysqli_query($con,"SELECT * FROM products WHERE id='$product' AND active!='0'");
			}
			else if($product=='' && $today!='' && $fromday !=''){

				$result2 = mysqli_query($con,"SELECT * FROM products WHERE active!='0'");
			}
		}
		while($fetch2=mysqli_fetch_array($result2)){
			
			$result3 = mysqli_query($con,"SELECT SUM(sale.qty) AS sumQty FROM sale WHERE sale.barcode='".$fetch2['id']."' AND sale.sale_day BETWEEN '$today' AND '$fromday'");	
			$fetch3  = mysqli_fetch_array($result3);
			$result4 = mysqli_query($con,"SELECT SUM(psale.qty) AS sumPQty, accounts.name AS vname FROM psale INNER JOIN accounts ON psale.customer=accounts.id WHERE psale.barcode='".$fetch2['id']."' AND psale.sale_day BETWEEN '$today' AND '$fromday'");
			$fetch4  = mysqli_fetch_array($result4);
				echo '<tr>
					 <td>'.$fetch2['name'].'</td>
					 <td>'.$fetch2['id'].'</td>
					 <td>'.$fetch4['vname'].'</td>
					 <td>'.number_format($fetch4['sumPQty'] ,2).'</td>
					 <td>'.number_format($fetch3['sumQty'] ,2).'</td>
					</tr>';
					$sum += $fetch3['sumQty'];
					$sump += $fetch4['sumPQty'];
			} ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="3" style="text-align: right;">Total</th>
			<th style="border:2px solid black"><?php echo number_format($sump,2); ?></th>
			<th style="border:2px solid black"><?php echo number_format($sum,2); ?></th>
		</tr>
	</tfoot>
	</table>
</div>
</div>
</div><!-- print button div end -->
<input type="button" class="btn btn-info" onclick="printDiv('printableArea')" value="Print" accesskey="p" />

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
    td = tr[i].getElementsByTagName("td")[0];
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
