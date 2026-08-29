<title>Day End Report</title>
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
	
	$person = $_POST['person'];
	}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
    
  </ul>
</nav>
<center><h1>DayEnd Report</h1></center><hr>
<form method="POST">
<div class="container">


<div class="row">
	<div class="col-md-3">
		<label>Username *</label>
		<input type="text" class="form-control" name="person" value="<?php echo $person; ?>"><br>
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
		
		<li><center><strong>DayEnd Report</strong></center></li>
		<li><b>UserName: <?php echo $person; ?></b></li>
		<li><?php date_default_timezone_set("Asia/Karachi"); ?>
		<label>Print Date: <?php echo date("Y-m-d h:i-a"); ?></label></li>
	</ul>
	
</div>
<div class="container-fluid">
<div class="row">
	<table border="1" class="table" id="myTable" width="100%">
		<thead>
		<th>Sr#</th>
		<th>Total Sale</th>
		<th>Total CashIn</th>
		<th>Total Credit</th>
		<th>Total Cash In Hand</th>
		<th>Total Cash Out</th>
		
		</thead> 
		<tbody>
		<?php
		if (isset($_POST['btn'])) {
		
		$counter  = 0;
		$today    = $_POST['today'];
		
		
		// $result3 = mysqli_query($con,"SELECT *,SUM(qty) AS qty1 FROM purchase WHERE pur_day BETWEEN '$today' AND '$fromday'");
		    $date = date('Y-m-d');
			$result4 = mysqli_query($con,"SELECT SUM(amount) AS sumAmnt FROM trans WHERE day='$date'");
			$fetch4  = mysqli_fetch_array($result4);

			$result7 = mysqli_query($con,"SELECT *,SUM(received)AS sumPaid,SUM(remaining)AS sumRemain,SUM(finalValue)AS sumFinal FROM sale WHERE sale_day = '$date'");
			while($fetch7 = mysqli_fetch_array($result7))
			{ 

			/*$result8 = mysqli_query($con,"SELECT SUM(cr) AS sumCr FROM customerledger WHERE day = '$date'");
			$fetch8  = mysqli_fetch_array($result8);*/
			$result9 = mysqli_query($con,"SELECT SUM(amount) AS sumAmnt1 FROM trans WHERE day='$date'");
			
			$fetch9  = mysqli_fetch_array($result9);
			 
			$counter++;	
				echo '<tr>
					 <td>'.$counter.'</td>
					 <td>'.$fetch7['sumFinal'].'</td>
					 <td>'.$fetch7['sumPaid'].'</td>
					 <td>'.$fetch7['sumRemain'].'</td>
					 <td>'.$fetch9['sumAmnt1'].'</td>
					 <td>'.$fetch4['sumAmnt'].'</td>
					 
					</tr>';
					
					
		?>
		

	<?php  } } ?>
	</tbody><!-- <tr><td colspan="3"></td><td><b>Total</b></td><td style="border:2px solid black"><?php echo $sum; ?></td></tr> -->
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
