<title>Total Receivable's</title>
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
include("../header.php");include('../connect.php');include('../converter.php');
if(isset($_POST['btn']))
{	$person = $_POST['person'];
	$fromday = $_POST['fromday'];
	$today = $_POST['today'];
	$customername = $_POST['customername'];
}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
    <!--<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>-->
  </ul>
</nav>
<center><h1>Receivable Report</h1></center><hr>
<form method="POST">
<div class="container">
	<div class="row">
	
	<!-- <div class="col-md-4">
		<label>User Name *</label>
		<input type="" class="form-control" name="person" value="<?php echo $person; ?>"><br>
	</div> -->
	<!-- <div class="col-md-4">
		<label>Customer Name</label>
		<input type="" class="form-control" name="customername" value="<?php echo $customername; ?>" list='group'>  
		<datalist id="group">
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu" role="menu">
                                   <?php
                                    $sql="SELECT * FROM accounts WHERE type='customer'";
                                    $result=mysqli_query($con,$sql);
                                     while($fetch=mysqli_fetch_array($result))
                                      {
                                      ?> 
                                   <option value="<?php echo $fetch['name'];?>"><?php echo $fetch['name'];?> </option>
                                   <?php } ?>
                                </ul>
                                </datalist><br>
	</div> -->

	<div class="col-md-3">
		<label>From Date<span style="color: red;">*</span></label>
		<input type="date" class="form-control" name="fromday" value="<?php echo $fromday; ?>"><br>
	</div>
	<div class="col-md-3">
		<label>To Date<span style="color: red;">*</span></label>
		<input type="date" class="form-control" name="today" value="<?php echo $today; ?>"><br>
	</div>
</div>
<div class="row">
	
	
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
		<li><label>User Name:</label> <u><b><?php echo $person; ?></b></u></li><li>
		<li><center><strong>Total Receivable</strong></center></li>
		<li><?php date_default_timezone_set("Asia/Karachi"); ?>
		<label>Print Date: <?php echo date("d/m/Y h:i-a"); ?></label></li>
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
			<td style="float: right;">From: <?php if($_POST['fromday']!=''){
				echo date("d/m/Y", strtotime($_POST['fromday']));
			}else { echo date("d/m/Y"); } ?></td>
		</tr>
		<tr>
			<td><?php echo $_SESSION['name']; ?></td>
			<td style="text-align: center;">Total Receivable</td>
			<td style="float: right;">To: <?php if($_POST['today']!=''){
				echo date("d/m/Y", strtotime($_POST['today']));
			}?></td>
		</tr>
	</table>
</div><br>
<div class="row">
	<table border="1" class="table" id="myTable" width="100%">
		<thead>
		<th>A/C#</th>
		<th>Title of A/C</th>
		<th>Address</th>
		<th>City</th>
		<th>Debit</th>
		<th>Credit</th>
		<th>Bal</th>
		</thead> 
		<tbody>
		<?php
		if (isset($_POST['btn'])) {	
		$fromday = $_POST['fromday'];
		$today = $_POST['today'];
		$customername = $_POST['customername'];	

			$counter = 0;	$total1=0;	$sum=0;
		 if ($fromday=='' && $today=='')
		 {
		 	
		 	$sql = "SELECT ledgers.*,accounts.*,SUM(ledgers.cr) AS credit,SUM(ledgers.dr) AS debit FROM ledgers INNER JOIN accounts ON ledgers.account_id = accounts.id WHERE accounts.type='Customer' GROUP BY ledgers.account_id";
		 	$result1 = mysqli_query($con,$sql);
		 }
		 elseif($fromday!='' && $today!='') {		 	
		 	// $result2 = mysqli_query($con,"SELECT *,id,customer,SUM(cr) AS credit,SUM(db) AS debit FROM customerledger WHERE day BETWEEN '$fromday' AND '$today' GROUP BY customer");
		 	$sql = "SELECT ledgers.*,accounts.*,SUM(ledgers.cr) AS credit,SUM(ledgers.dr) AS debit FROM ledgers INNER JOIN accounts ON ledgers.account_id = accounts.id WHERE accounts.type='Customer' AND ledgers.day BETWEEN '$fromday' AND '$today' GROUP BY ledgers.account_id";
		 	$result1 = mysqli_query($con,$sql);
		 }
		/*$result2 = mysqli_query($con,"SELECT id,customer,SUM(cr) AS credit,SUM(db) AS debit FROM customerledger GROUP BY customer");*/
		while($fetch1 = mysqli_fetch_array($result1))
		{    
			$bal = $fetch1['debit']-$fetch1['credit'];
		 	echo '<tr>
			<td>'.$fetch1['id'].'</td>
			<td>'.$fetch1["name"].'</td>
			<td>'.$fetch1['address'].'</td>
			<td>'.$fetch1['city'].'</td>
			<td>'.$fetch1['debit'].'</td>
			<td>'.$fetch1['credit'].'</td>
			<td>'.abs($bal).'</td>
			</tr>';
			$sum = $sum+$fetch1['debit'];
			$sum1 = $sum1+$fetch1['credit'];
		?>
			

	<?php 
} 
}
	?>

 	</tbody><tr><td colspan="3"></td><td><b>Total</b></td><td style="border:2px solid black"><?php echo $sum; ?></td><td style="border:2px solid black"><?php echo $sum1; ?></td><td></td></tr>
	<!-- <tr>
	<td colspan="5"></td>
	<td><b><?php echo $db ?></b></td>
	<td><b><?php echo $cr ?></b></td>
	</tr>
	<tr>
	<td colspan="7" style="text-align: right;font-size: 18px;font-weight: bolder;">Balance:</td><td style="border:2px solid black;font-size: 17px;"><b><?php echo $sum." ".$show; ?></b></td></tr>  -->
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