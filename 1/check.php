<title>Inventory Management</title>
<?php 
include("../header.php");
?>
<div class="container-fluid">
<h2>Inventory Management</h2>
<h5>Here you can perform all actions</h5><hr>
	<div class="row">
		
		 <div class="col-md-3">
			<a href="../1/countsheet.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><b>Count Sheet</b></button></a><br>
		</div>
		<div class="col-md-3">
			<a href="../1/bulkprice.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><b>Bulk Price Editing</b></button></a>
		</div>
		<div class="col-md-3">
			<a href="finished.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><b>Finshed Goods</b></button></a>
		</div>
	</div>
<div class="row">
		
		<div class="col-md-4">
			<a href="location.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><b>Bulk Location Editing</b></button></a>
		</div>
		<div class="col-md-3">
			<a href="../1/stockopening.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><b>Stock Opening</b></button></a>
		</div>
		<!--  <div class="col-md-5">
			<a href="viewPreturn.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>Total Payable Report</b></button></a><br>
		</div> -->
	</div>
<!-- 	<div class="row">
		<div class="col-md-5">
			<a href="productProfit.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true"></i><br><b>Product Profit Report</b></button></a>
		</div>
		<div class="col-md-2"></div>
		 <div class="col-md-5">
			<a href="dayendDetail.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>Day End Detail Report</b></button></a><br>
		</div>
	</div> -->
	
	
	</div>
	
	<br>
<?php 
include("../footer.php");
?>