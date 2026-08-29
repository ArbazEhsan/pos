<title>Total Payable's</title>
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
if(isset($_POST['btn']))
{	$person = $_POST['person'];
	$fromday = $_POST['fromday'];
	$today = $_POST['today'];
	$customername = $_POST['customername'];
}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="checkpoint.php"><span aria-hidden="true">&larr;</span> Back</a></li>
    <!--<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>-->
  </ul>
</nav>
<center><h1>Payable Report</h1></center><hr>
<form method="POST">
<div class="container">
	<div class="row">
	
	<div class="col-md-4">
		<label>User Name *</label>
		<input type="" class="form-control" name="person" value="<?php echo $person; ?>"><br>
	</div>
	<div class="col-md-4">
		<label>Vender Name</label>
		<input type="" class="form-control" name="customername" value="<?php echo $customername; ?>" list='group'>  
		<datalist id="group">
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu" role="menu">
                                   <?php
                                    $sql="SELECT * FROM customer WHERE type='vender'";
                                    $result=mysqli_query($con,$sql);
                                     while($fetch=mysqli_fetch_array($result))
                                      {
                                      ?> 
                                   <option value="<?php echo $fetch['name'];?>"><?php echo $fetch['name'];?> </option>
                                   <?php } ?>
                                </ul>
                                </datalist><br>
	</div>
</div>
<div class="row">
	
	<div class="col-md-4">
		<label>From Date *</label>
		<input type="date" class="form-control" name="fromday" value="<?php echo $fromday; ?>"><br>
	</div>
	<div class="col-md-4">
		<label>To Date *</label>
		<input type="date" class="form-control" name="today" value="<?php echo $today; ?>"><br>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<button class="btn btn-primary" name="btn">Generate Report</button>

	</div>
	<div class="col-md-4 pull-right">
		<input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for Vender..">
	</div>
</div>
</div>
</form><hr>
<div id="printableArea">
<div class="row">
	<ul>
		<li><label>User Name:</label> <u><b><?php echo $person; ?></b></u></li><li>
		<li><center><strong>Total Payable Report</strong></center></li>
		<li><?php date_default_timezone_set("Asia/Karachi"); ?>
		<label>Print Date: <?php echo date("d-m-Y h:i-a"); ?></label></li>
	</ul>
	
</div>
<div class="container-fluid">
<div class="row">
	<table border="1" class="table" id="myTable" width="100%">
		<thead>
		<th>Sr#</th>
		<th>Day</th>
		<th>Vender</th>
		<th>Payables (Rs.)</th>
		</thead> 
		<tbody>
		<?php
		if (isset($_POST['btn'])) {		
			$counter = 0;	$total1=0;		$sum=0;
		 if ($customername !='' && $fromday=='' && $today=='') {

		 	$result1 = mysqli_query($con,"SELECT * FROM customer WHERE type='vender' AND name='$customername'");
		 	$fetch1 = mysqli_fetch_array($result1);
            $id = $fetch1['id'];		 	
		 	$result2 = mysqli_query($con,"SELECT id,customer,day,SUM(cr) AS credit,SUM(db) AS debit FROM customerledger WHERE customer='$id' GROUP BY customer");
		 }
		 elseif($customername =='' && $fromday!='' && $today!='') {		 	
		 	$result2 = mysqli_query($con,"SELECT *,id,customer,SUM(cr) AS credit,SUM(db) AS debit FROM customerledger WHERE day BETWEEN '$fromday' AND '$today' && type='vender' GROUP BY customer");
		 }
		 elseif ($customername !='' && $fromday!='' && $today!='') {
		 	$result1 = mysqli_query($con,"SELECT * FROM customer WHERE type='customer' AND name='$customername'");
		 	$fetch1 = mysqli_fetch_array($result1);
		 	$id = $fetch1['id'];		 	
		 	$result2 = mysqli_query($con,"SELECT id,customer,day, SUM(cr) AS credit,SUM(db) AS debit FROM customerledger WHERE day BETWEEN '$fromday' AND '$today' && type='vender' GROUP BY customer");
		 }
		/*$result2 = mysqli_query($con,"SELECT id,customer,SUM(cr) AS credit,SUM(db) AS debit FROM customerledger GROUP BY customer");*/
		while($fetch2 = mysqli_fetch_array($result2))
		{  
			if ($fetch2['credit'] > $fetch2['debit'])
			{
				$counter++;
			 	$total1 = $fetch2['credit']-$fetch2['debit'];

			 	$result3 = mysqli_query($con,"SELECT * FROM customer WHERE 
			 		id=".$fetch2['customer']."");
			 	$fetch3 = mysqli_fetch_array($result3);

			 	echo '<tr>
				<td>'.$counter.'</td>
				<td>'.date("d-m-Y", strtotime($fetch2["day"])).'</td>
				<td>'.$fetch3["name"].'</td>
				<td>'.$total1.'</td>
				</tr>';
				$sum = $sum+$total1;
			}
			
			
			?>
			

	<?php 
} 
}
	?>

 	</tbody><tr><td colspan="2"></td><td><b>Total</b></td><td style="border:2px solid black"><?php echo $sum; ?></td></tr>
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
    td = tr[i].getElementsByTagName("td")[1];
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