<title>Cash Management</title>
<?php 
include("../header.php");
?>
<div class="container-fluid">
<h2>Cash Management</h2>
<h5>Here you can perform all actions</h5><hr>
	<div class="row">
		
		 <div class="col-md-3">
			<a href="cashin.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><b>Cash Receipt</b></button></a><br>
		</div>
		<div class="col-md-3">
			<a href="viewCashin.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><b>View Cash Receipt</b></button></a>
		</div>
		<div class="col-md-3">
			<a href="cashout.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><b>Cash Payment</b></button></a>
		</div>
		<div class="col-md-3">
			<a href="viewCashout.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><b>View Cash Payment</b></button></a>
		</div>
	</div>
	</div>
	<br>
<?php 
include("../footer.php");
?>