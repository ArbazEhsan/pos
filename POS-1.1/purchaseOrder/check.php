<?php 
include("../header.php");
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="../menu.php"><span aria-hidden="true">&larr;</span> Back</a></li>
    <!--<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>-->
  </ul>
</nav>
<center><h1>Choose Following</h1></center><hr><br>

<div class="container">
	<!-- <div class="row">
		<div class="col-md-5">
			<a href="order.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-server" aria-hidden="true"></i><br><b>Make New Order</b></button></a>
		</div>
		<div class="col-md-2"></div>
		<div class="col-md-5">
			<a href="preOrder.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-danger btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>View Pre Orders</b></button></a>
		</div>
	</div><br>
	<div class="row">
		<div class="col-md-5">
			<a href="reorder.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>Re-Order</b></button></a>
		</div>
				<div class="col-md-2"></div>
				<div class="col-md-5">
			<a href="showStep1.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-danger btn-block"><i class="fa fa-server" aria-hidden="true"></i><br><b>View Final Orders List</b></button></a>
		</div>
		
	</div><br> -->
	<div class="row">
		<div class="col-md-5">
			<a href="../2/returnP.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-info btn-block"><i class="fa fa-arrow-down fa-3x" aria-hidden="true"></i><br><b>Purchase Return</b></button></a>
		</div>
		<div class="col-md-2"></div>
		<div class="col-md-5">
			<a href="../2/viewPreturn.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-danger btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>View Purchase return</b></button></a>
		</div>
	</div><br>
	<!-- <div class="row">
		<div class="col-md-12">
			<a href="viewInvoices.php"><button style="height: 130px; font-size: 166%; border-radius: 50px;" class="alert alert-success btn-block"><i class="fa fa-hand-o-down fa-3x" aria-hidden="true" ></i><br><b>View Purchase Invoices</b></button></a>
		</div>
	</div><br> -->
	

</div>
<?php 
include("../footer.php");
?>
<!-- <body onload="table()">
	<script type="text/javascript">
function table()
{
  var x=prompt("Enter a number:",2);
  var alertBody = '';
  for (var i=1; i<10; i++) {
    alertBody += x + "*" + i +"="+x*i + '\n';
  
  }
  alert(alertBody);
}
	</script> -->