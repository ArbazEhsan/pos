<title>Profit & Loss Report</title>
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
	
	$today   = $_POST['today'];
	$fromday = $_POST['fromday'];
	}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
    
  </ul>
</nav>
<center><h1>Profit & Loss Report</h1></center><hr>
<form method="POST">
<div class="container">


<div class="row">
	<div class="col-md-3">
		<label>To date<span style="color: red;">*</span></label>
		<input type="date" class="form-control" name="today" value="<?php echo $today; ?>" required>
		<br>
	</div>
	<div class="col-md-3">
		<label>From date<span style="color: red;">*</span></label>
		<input type="date" class="form-control" name="fromday" value="<?php echo $fromday; ?>" required>
		<br>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<button class="btn btn-primary" name="btn">Generate Report</button>

	</div>
	<!-- <div class="col-md-4 pull-right">
		<input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for Name..">
	</div> -->
</div>
</div>
</form><hr>
<div id="printableArea">
<div class="container-fluid">
	<div class="row">
	<table border="0" width="98%" align="center">
		<tr >
			<td style="width: 18%">115</td>
			<td style="text-align: center;">NARC, Islamabad, SAC & PATCO, Dairy Products</td>
			<td style="float: right;">From: <?php if(isset($_POST['btn'])){
				echo date("d/m/Y", strtotime($_POST['today']));
			}else { echo date("d/m/Y"); } ?></td>
		</tr>
		<tr>
			<td><?php echo $_SESSION['name']; ?></td>
			<td style="text-align: center;">Profit & Loss Report</td>
			<td style="float: right;">To: <?php if(isset($_POST['btn'])){
				echo date("d/m/Y", strtotime($_POST['fromday']));
			}?></td>
		</tr>
	</table>
</div><br>
<div class="row">
	<table border="0" class="table table-striped" width="100%">
		<thead style="background: green;color: white;">
		<th style="padding: 10px;">Particulars</th>
		<th style="text-align:right;padding: 10px;border-left: 1px solid green;">Qty</th>
		<th style="text-align:right;padding: 10px;">Amount (Rs.)</th>
		<th style="text-align:right;padding: 10px;">Avg Price (Rs.)</th>
		</thead> 
		<tbody>
		<?php
		if (isset($_POST['btn'])) {
		
			$counter  = 0;
			$todate    = $_POST['today'];
			$fromday  = $_POST['fromday'];
		    $date = date('Y-m-d');

		    $sql1 = "SELECT products.name, products.id FROM products";
		    $sql2 = "SELECT accounts.name, accounts.id FROM accounts WHERE type='Expense'";

			echo '<tr>
				<td style="font-weight:bold;">Sales</td>
				<td></td>
				<td></td>
				<td></td>
				</tr>';
			$totalSaleQty = $totalSale = 0;
			$result1 = mysqli_query($con,$sql1);
			while ($fetch1=mysqli_fetch_array($result1)) {
				$result11 = mysqli_query($con,"SELECT SUM(qty) AS saleQty, SUM(finalValue) AS saleFinalValue, AVG(price) AS saleAvgPrice FROM sale WHERE barcode='".$fetch1['id']."' AND sale_day BETWEEN '$todate' AND '$fromday'");
				$fetch11=mysqli_fetch_array($result11);
				$totalSaleQty = $totalSaleQty + $fetch11['saleQty'];
				$totalSale = $totalSale + $fetch11['saleFinalValue'];
				// $avg = $fetch11['salePrice']/$fetch11['saleCount'];
		 	echo '<tr>
		 		<td>'.$fetch1['name'].'</td>
		 		<td style="text-align:right;">'.number_format($fetch11['saleQty'],2).'</td>
				<td style="text-align:right;">'.number_format($fetch11['saleFinalValue'],2).'</td>
				<td style="text-align:right;">'.number_format($fetch11['saleAvgPrice'],2).'</td>
		 		</tr>';
			}	
			echo '<tr>
				<td style="font-weight:bold;text-align:center;">Total Sale</td>
				<td style="font-weight:bold;text-align:right;border-top: 1px solid black;border-bottom:1px solid black;">'.number_format($totalSaleQty,2).'</td>
				<td style="font-weight:bold;text-align:right;border-top: 1px solid black;border-bottom:1px solid black;">'.number_format($totalSale,2).'</td>
				<td></td>
				</tr>';
			
			echo '<tr>
				<td style="font-weight:bold;">Purchases</td>
				<td></td>
				<td></td>
				<td></td>
				</tr>';

			$totalPurQty = $totalPur = 0;
			$result2 = mysqli_query($con,$sql1);
			while ($fetch2=mysqli_fetch_array($result2)) {
				$result22 = mysqli_query($con,"SELECT SUM(qty) AS psaleQty, SUM(finalValue) AS psaleFinalValue, AVG(price) AS purAvgPrice FROM psale WHERE barcode='".$fetch2['id']."' AND sale_day BETWEEN '$todate' AND '$fromday'");
				$fetch22=mysqli_fetch_array($result22);
				$totalPurQty = $totalPurQty + $fetch22['psaleQty'];
				$totalPur = $totalPur + $fetch22['psaleFinalValue'];
		 	echo '<tr>
		 		<td>'.$fetch2['name'].'</td>
		 		<td style="text-align:right;">'.number_format($fetch22['psaleQty'],2).'</td>
				<td style="text-align:right;">'.number_format($fetch22['psaleFinalValue'],2).'</td>
				<td style="text-align:right;">'.number_format($fetch22['purAvgPrice'],2).'</td>
		 		</tr>';
			}	
			echo '<tr>
				<td style="font-weight:bold;text-align:center;">Total Purchase</td>
				<td style="font-weight:bold;text-align:right;border-top: 1px solid black;border-bottom:1px solid black;">'.number_format($totalPurQty,2).'</td>
				<td style="font-weight:bold;text-align:right;border-top: 1px solid black;border-bottom:1px solid black;">'.number_format($totalPur,2).'</td>
				<td></td>
				</tr>';

			$gsProfit = $totalSale - $totalPur;
			$gsProfittxt = $gsProfitColor = '';
			$gsProfitColor = 'green';
			$gsProfittxt = $gsProfit;
			if ($gsProfit<0) {
				$gsProfittxt = '('.number_format(abs($gsProfit)).')';
				$gsProfitColor = 'red';
			}
			echo '<tr>
				<td style="font-weight:bold;text-align:center;">Gross Profit</td>
				<td></td>
				<td style="font-weight:bold;text-align:right;border-top: 1px solid black;border-bottom:1px solid black;color:'.$gsProfitColor.'">'.number_format($gsProfittxt,2).'</td>
				<td></td>
				</tr>
				<tr>
				<td style="font-weight:bold;">Operating Expenses</td>
				<td></td>
				<td></td>
				<td></td>
				</tr>';
		 }
		$totalExpense = $totalExpenseQty = $opIncome = 0;
		$result3 = mysqli_query($con,$sql2);
		while ($fetch3=mysqli_fetch_array($result3)) {

			$result33 = mysqli_query($con,"SELECT SUM(amount) AS expenseAmnt FROM trans WHERE account_id='".$fetch3['id']."' AND day BETWEEN '$todate' AND '$fromday'");
			$fetch33=mysqli_fetch_array($result33);
			$totalExpense = $totalExpense + $fetch33['expenseAmnt'];
			// $totalExpenseQty = $totalExpenseQty + $fetch3['qty'];
		 	echo '<tr>
		 		<td>'.$fetch3['name'].'</td>
		 		<td></td>
				<td style="text-align:right;">'.number_format($fetch33['expenseAmnt'],2).'</td>
				<td></td>
		 		</tr>';
		}

		$opIncome = $gsProfit - $totalExpense;
		 	echo '<tr>
		 		<td style="font-weight:bold;">Total Operating Expenses</td>
		 		<td style="font-weight:bold;text-align:right;border-top: 1px solid black;border-bottom:1px solid black;">'.number_format($totalExpenseQty,2).'</td>
				<td style="font-weight:bold;text-align:right;border-top: 1px solid black;border-bottom:1px solid black;">'.number_format($totalExpense,2).'</td>
				<td></td>
		 		</tr>';
		 		$opIncometxt = $opIncomeColor = '';
		 		$opIncometxt = $opIncome;
		 		$opIncomeColor = 'green';
				if ($opIncome<0) {
					$opIncometxt = '('.number_format(abs($opIncome),2).')';
					$opIncomeColor = 'red';
				}
		 	echo '<tr>
		 		<td style="font-weight:bold;text-align:center;">Operating Income</td>
		 		<td></td>
				<td style="font-weight:bold;text-align:right;color:'.$opIncomeColor.'">'.number_format($opIncometxt,2).'</td>
				<td></td>
		 		</tr>
		 		<td style="font-weight:bold;background:yellow;padding:10px;">Net Income</td>
		 		<td></td>
				<td style="font-weight:bold;text-align:right;border-top: 1px solid black;border-bottom:1px solid black;color:'.$opIncomeColor.'">'.number_format($opIncometxt,2).'</td>
				<td></td>
		 		</tr>';
		 ?>
	
	</tbody><!-- <tr><td colspan="3"></td><td><b>Total</b></td><td style="border:2px solid black"><?php echo $sum; ?></td></tr> -->
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
