<title>Reports</title>
<?php 
include('../session.php');
include("../header.php");
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
    <!--<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>-->
  </ul>
</nav>
<center><h1>Choose Following</h1></center><hr><br>
<div class="container">
	<div class="row">
		<div class="col-md-5">
			<a href="viewcashin.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true"></i><br><b>Cashin Report</b></button></a>
		</div>
		<div class="col-md-2"></div>
		 <div class="col-md-5">
			<a href="viewSreturn.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>Total Receivable Report</b></button></a><br>
		</div>
	</div>
		
	<div class="row">
		
		<div class="col-md-5">
			<a href="dayend.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>View DayEnd Report</b></button></a>
		</div>
		<div class="col-md-2"></div>
		<div class="col-md-5">
			<a href="productreport.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>View Product Report</b></button></a>
		</div>
	</div><br>
<div class="row">
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
			<a href="productProfit.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true"></i><br><b>Profit & Loss Report</b></button></a>
		</div>
		<div class="col-md-2"></div>
		 <div class="col-md-5">
			<a href="dayendDetail.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>Day End Detail Report</b></button></a><br>
		</div>
	</div>
	<div class="row">
		<!-- <div class="col-md-5">
			<a href="stockreport.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true"></i><br><b>Stock Report</b></button></a>
		</div>
		<div class="col-md-2"></div> -->
		 <!-- <div class="col-md-5">
			<a href="dayendDetail.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>Day End Detail Report</b></button></a><br>
		</div> -->
	</div>
	
	
	</div>
	
	<br>
<?php 
include("../footer.php");
?>