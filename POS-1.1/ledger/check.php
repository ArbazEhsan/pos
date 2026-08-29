<title>C/V ledger</title>
<?php 
include('../session.php');
include("../header.php");
?>
<!-- <nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
    <li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>
  </ul>
</nav> -->
<div class="container-fluid">
	<h2>Ledger</h2>
	<h5>Here you can perform all actions</h5><hr>
	<div class="row">
		<div class="col-md-3">
			<a href="checkpoint.php?t=customer"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><b>Customer Ledger</b></button></a>
		</div>
		 <div class="col-md-3">
			<a href="checkpoint.php?t=vendor"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><b>Vendor Ledger</b></button></a><br>
		</div>
		<div class="col-md-3">
			<a href="checkpoint.php?t=other"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><b>Other Ledger</b></button></a>
		</div>
	</div>
		
	<div class="row">
		
		
		<div class="col-md-2"></div>
		<!-- <div class="col-md-5">
			<a href="productreport.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>View Product Report</b></button></a>
		</div> -->
	</div><br>
<!-- <div class="row">
		<div class="col-md-5">
			<a href="viewcashout.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true"></i><br><b>Cashout Report</b></button></a>
		</div>
		<div class="col-md-2"></div>
		 <div class="col-md-5">
			<a href="viewPreturn.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>Total Payable Report</b></button></a><br>
		</div>
	</div>
	<div class="row">
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