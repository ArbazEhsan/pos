<?php include('../session.php');
// if( ($_SESSION['username']=='') && ($_SESSION['password']==''))
// {
//     header("Location:../index.php?msg=Please Login to Continue");
// } ?>
<title>Ledger Menu</title>
<?php include("../header.php");include('../connect.php');
$t = $_REQUEST['t'];
$sql = '';
if($t=='vendor')
{
	$new = 'Vendor';
	$action = 'ledgerV.php' ;
	$sql="SELECT * FROM accounts WHERE type = '$t' AND active!='0' ORDER BY name";
}
elseif($t=='customer')
{
	$new = 'Customer';
	$action = 'ledger.php';
	$sql="SELECT * FROM accounts WHERE type = '$t' AND active!='0' ORDER BY name";
}
elseif($t=='other')
{
	$new = 'Account';
	$action = 'ledger.php';
	$sql="SELECT * FROM accounts WHERE type!='Customer' AND type!='Vendor' AND active!='0' ORDER BY name";
}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body onload="focus1()">
</nav>
<center><h1>Please Fill Following Fields</h1></center><hr>
<form method="POST" action="<?php echo $action; ?>">
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<h3>Select Start Date *</h3>
			<input type="date" class="form-control" name="day1" >
		</div>
		<?php if(isset($_REQUEST['msg']))
		{?>
		<div class="col-md-6">
			<div class="alert alert-danger"><?php echo $_REQUEST['msg']; ?></div>
		</div>
		<?php } ?>
	</div>
	<div class="row">
		<div class="col-md-4">
			<h3>Select End Date *</h3>
			<input type="date" class="form-control" name="day2">
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<h3>Choose <?php echo $new; ?> *</h3>
			  <select autocomplete="off" name="customer" class="form-control" required>
				<option value="0" disabled selected>--- Select ---</option>
				<?php 
	          $result=mysqli_query($con,$sql);
	          while($fetch=mysqli_fetch_array($result)){
	          echo "<option value=".$fetch["id"].">".$fetch["name"]."</option>";}  ?>
			</select>
			  <!-- <input list="group"  id="vendorId" autocomplete="off" name="customer" class="form-control" placeholder="Enter Name"  required onchange="cust(this.value)">
                     <datalist id="group">
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu" role="menu">
                                   <?php
                                    $result=mysqli_query($con,$sql);
                                     while($fetch=mysqli_fetch_array($result))
                                      {
                                      ?> 
                                   <option value="<?php echo $fetch['name'];?>"><?php echo $fetch['name'];?> </option>
                                   <?php } ?>
                                </ul>
                                </datalist> -->
		</div>
	</div>
	<div class="row">
			<div class="col-md-4">
				<h3><input type="hidden" name="t" value="<?php echo $t; ?>"></h3>
				<button class="btn btn-primary" name="btn">Generate Ledger</button>
			</div>
		</div>
</div></form>
<?php include("../footer.php"); ?>