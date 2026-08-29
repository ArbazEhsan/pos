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
		<div class="col-md-3">
			<a href="add.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><b>Cash In</b></button></a>
		</div>
		<div class="col-md-3">
			<a href="viewCashin.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><b>View Cashin</b></button></a>
		</div>
		<div class="col-md-3">
			<a href="cashout.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><b>Cash Out</b></button></a>
		</div>
		<div class="col-md-3">
			<a href="viewCashout.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><b>View Cashout</b></button></a>
		</div>
	</div><br>
	<div class="row">
		
		
		
		<div class="col-md-2"></div>
		
	</div><br>
	<div class="row">
		
		<!-- <div class="col-md-12">
			<a href="journal.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-arrows fa-3x" aria-hidden="true" ></i><br><b>Journal Voucher</b></button></a>
		</div> -->
		
		<!-- <div class="col-md-2"></div>
		<div class="col-md-5">
			<a href="viewsaleReturn.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-arrows fa-3x" aria-hidden="true" ></i><br><b>View Sale Return</b></button></a>
		</div> -->
	</div><br>
	<div class="row">
		
	</div><br>
</div>
<?php 
include("../footer.php");
?>