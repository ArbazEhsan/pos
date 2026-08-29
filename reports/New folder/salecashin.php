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
	$today    = $_POST['today'];
	$fromday  = $_POST['fromday'];
	$customername    = $_POST['customername'];
	}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="checkpoint.php"><span aria-hidden="true">&larr;</span> Back</a></li>
    
  </ul>
</nav>
<center><h1>View Sale's Cash In Report</h1></center><hr>
<form method="POST">
<div class="container">


<div class="row">
	<div class="col-md-3">
		<label>User Name *</label>
		<input type="text" class="form-control" name="username" value="<?php echo $username; ?>"><br>
	</div>

	<div class="col-md-3">
		<label>Customer Name</label>
		<input list="group"  id="vendorId" name="customername" class="form-control" placeholder="Please Select Customer" value="<?php echo $customername; ?>" >
                     <datalist id="group">
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu" role="menu">
                                   <?php
                                    $sql="SELECT * FROM customer";
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
	
	<div class="col-md-3">
		<label>To Date *</label>
		<input type="date" class="form-control" name="today" value="<?php echo $today; ?>"><br>
	</div>

	<div class="col-md-3">
		<label>From Date *</label>
		<input type="date" class="form-control" name="fromday" value="<?php echo $fromday; ?>"><br>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<button class="btn btn-primary" name="btn">Generate Report</button>

	</div>
	<div class="col-md-4 pull-right">
		<!-- <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for Customer.."> -->
	</div>
</div>
</div>
</form><hr>
<div id="printableArea">
<div class="row">
	<ul>
		<li><label>User Name:</label> <u><b><?php echo $username; ?></b></u></li>
		<li><center><strong>View Sale's Cash In Report</strong></center>	</li>
		<li><label>From:&nbsp;</label> <u><b><?php echo $fromday; ?>&nbsp;</b></u>  <label>To:&nbsp;</label> <u><b><?php echo $today; ?></b></u></li>
		<li><?php date_default_timezone_set("Asia/Karachi"); ?>
		<label>Print Date: <?php echo date("Y-m-d h:i-a"); ?></label></li>
	</ul>
	
</div>
<div class="container-fluid">
<div class="row">
	<table border="1" class="table" id="myTable" width="100%">
		<thead>
		<th>Sr#</th>
		<th>Day</th>
		<th>Cash In</th>
		</thead> 
		<tbody>
		<?php
		if (isset($_POST['btn'])) {
		
		$counter  = 0; $loss = 0;
		$username = $_POST['username'];
		$today    = $_POST['today'];
		$fromday  = $_POST['fromday'];
		
		if ($today !='' && $fromday !='') {
			$result4 = mysqli_query($con,"SELECT * FROM cashin WHERE day BETWEEN '$today' AND '$fromday'");
		}
		elseif ($customername !='') {
			$result3 = mysqli_query($con,"SELECT * FROM customer WHERE name='$customername'");
			$fetch3 = mysqli_fetch_array($result3);
			$customerid = $fetch3['id'];
			$result4 = mysqli_query($con,"SELECT * FROM cashin WHERE customer='$customerid'");
		}
		
			while($fetch4 = mysqli_fetch_array($result4))
			{ 
			
			$day = $fetch4['day'];
			$amnt   = $fetch4['amount'];
			$counter++;
				
				echo '<tr>
					 <td>'.$counter.'</td>
					 <td>'.$day.'</td>
					 <td> '.$amnt.'</td>
					</tr>';
					$sum = $sum + $amnt;
					
		?>
		

	<?php }  } ?>
	</tbody><tr><td colspan="1"></td><td><b>Total</b></td><td style="border:2px solid black"><?php echo $sum; ?></td></tr>
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
