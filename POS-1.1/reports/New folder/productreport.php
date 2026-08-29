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
	
	$person = $_POST['person'];
	$customer = $_POST['customer'];
	$today = $_POST['today'];
	$fromday = $_POST['fromday'];
	}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="checkpoint.php"><span aria-hidden="true">&larr;</span> Back</a></li>
    
  </ul>
</nav>
<center><h1>Product Report</h1></center><hr>
<form method="POST">
<div class="container">
<div class="row">
	<div class="col-md-3">
		<label>Username *</label>
		<input type="text" class="form-control" name="person" value="<?php echo $person; ?>" required=""><br>
	</div> 
	<div class="col-md-3">
		<label>Customer</label>
		<input list="group"  id="vendorId" name="customer" class="form-control" value="<?php echo $_POST['customer']; ?>">
                     <datalist id="group">
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu" role="menu">
                                   <?php
                                    $sql="SELECT * FROM customer WHERE type='customer'";
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
		<label>To Date</label>
		<input type="date" class="form-control" name="today" value="<?php echo $today; ?>" ><br>
	</div>
	<div class="col-md-3">
		<label>From Date</label>
		<input type="date" class="form-control" name="fromday" value="<?php echo $fromday; ?>" ><br>
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
		
		<li><center><strong>Product Report</strong></center></li>
		
		<li><?php date_default_timezone_set("Asia/Karachi"); ?>
		<label>Print Date: <?php echo date("d-m-Y h:i-a"); ?></label></li>
		<li>Report From: <b><?php echo $today." To ".$fromday; ?></b></li>
	</ul>
	
</div>
<div class="container-fluid">
<div class="row">
	<table border="1" class="table" id="myTable" width="100%">
		<thead>
		<th>Sr#</th>
		<th>Customer</th>
		<th>Name</th>
		<th>Quantity</th>
		</thead> 
		<tbody>
		<?php
		if (isset($_POST['btn'])) {
		
		$counter  = 0;$sum  = 0;
		$person   = $_POST['person'];
		$customer = $_POST['customer'];
		$today    = $_POST['today'];
		$fromday  = $_POST['fromday'];
		$result1 = mysqli_query($con,"SELECT * FROM customer WHERE name='$customer'");
			$fetch1  = mysqli_fetch_array($result1);
		if($customer !='' && $today =='' && $fromday =='')
		{
			$result2 = mysqli_query($con,"SELECT *,SUM(qty)AS sumQty FROM sale WHERE  customer='".$fetch1['id']."' GROUP BY barcode ");
		}
		else if($today !='' && $fromday !='' && $customer == ''){
		
			$result2 = mysqli_query($con,"SELECT *,SUM(qty) AS sumQty FROM sale WHERE  day BETWEEN '$today' AND '$fromday' GROUP BY barcode,customer");
			
		}
		else if($customer!='' && $today!='' && $fromday !='')
		{
			$result2 = mysqli_query($con,"SELECT *,SUM(qty) AS sumQty FROM sale WHERE customer='".$fetch1['id']."' && day BETWEEN '$today' AND '$fromday' GROUP BY barcode");	
		}
		}
		while ($fetch2 = mysqli_fetch_array($result2)) {
			
			$id = $fetch2['barcode'];
			$result8 = mysqli_query($con,"SELECT * FROM products WHERE id = '$id'");
			$fetch8  = mysqli_fetch_array($result8);			
			 $result9 = mysqli_query($con,"SELECT * FROM customer WHERE id='".$fetch2['customer']."'");
			$fetch9  = mysqli_fetch_array($result9);
			$counter++;	
				echo '<tr>
					 <td>'.$counter.'</td>
					 <td>'.$fetch9['name'].'</td>
					 <td>'.$fetch8['product'].'</td>
					 <td>'.$fetch2['sumQty'].'</td>
					</tr>';
					$sum = $sum + $fetch2['sumQty'];
					
		?>

	<?php  } ?>
	</tbody><tr><td colspan="2"></td><td><b>Total</b></td><td style="border:2px solid black"><?php echo $sum; ?></td></tr>
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
