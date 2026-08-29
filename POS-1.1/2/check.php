<title>Sale/Purchase Return</title>
<?php 
include("../header.php");
?>
<div class="container-fluid">
<h2>Sale/Purchase Return</h2>
<h5>Here you can perform all actions</h5><hr>
	<div class="row">
		
		 <div class="col-md-3">
			<a href="returnS.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><b>Sale Return</b></button></a><br>
		</div>
		<div class="col-md-3">
			<a href="viewsaleReturn.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><b>View Sale Return</b></button></a>
		</div>
		<div class="col-md-3">
			<a href="returnP.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><b>Purchase Return</b></button></a>
		</div>
	</div>
<div class="row">
		
		<div class="col-md-4">
			<a href="viewPreturn.php"><button style="font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><b>View Purchase return</b></button></a>
		</div>
	</div>	
	</div>
	
	<br>
<?php include("../footer.php"); ?>