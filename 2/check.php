<?php 
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
			<a href="sReturn.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-arrow-right fa-3x" aria-hidden="true"></i><br><b>Sale Return</b></button></a>
		</div>
		
		<div class="col-md-2"></div>
		<div class="col-md-5">
			<a href="viewsaleReturn.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-arrow-left fa-3x" aria-hidden="true" ></i><br><b>View Sale Return</b></button></a>
		</div>
	</div><br>
	<div class="row">
		
		<div class="col-md-5">
			<a href="returnP.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-arrow-down fa-3x" aria-hidden="true"></i><br><b>Purchase Return</b></button></a>
		</div>
		<div class="col-md-2"></div>
		<div class="col-md-5">
			<a href="viewPreturn.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-arrow-down fa-3x" aria-hidden="true" ></i><br><b>View Purchase return</b></button></a>
		</div>
	</div><br>
	<div class="row">
		
	</div><br>
</div>
<?php 
include("../footer.php");
?>