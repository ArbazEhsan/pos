<?php include('../session.php'); ?>
<title>Edit Cash In</title><?php include('../header.php');include('../connect.php');
$id = $_REQUEST['id'];
$sql1      = "SELECT * FROM ledger WHERE id = '$id'";
$result1   = mysqli_query($con,$sql1);
$fetch1    = mysqli_fetch_array($result1);
$cst 	   = $fetch1['customer'];
  $sql3      = "SELECT * FROM customer WHERE id = '$cst'";
  $result3   = mysqli_query($con,$sql3);
  $fetch3    = mysqli_fetch_array($result3);
  $customer     = $fetch3['name'];
if(isset($_POST['btn1']))
{
  $day      = $_POST['day'];
  $cust = $_POST['customer'];
  $sql2      = "SELECT * FROM customer WHERE name = '$cust'";
  $result2   = mysqli_query($con,$sql2);
  $fetch2    = mysqli_fetch_array($result2);
  echo $customerId     = $fetch2['id'];
  $amount   = $_POST['amount'];
  $remarks  = $_POST['remarks'];

  if(mysqli_query($con,"UPDATE ledger SET day = '$day',customer='$customerId',cr='$amount',balance='-$amount',remarks='$remarks' WHERE id = '$id'"));
  {
    header("location:credit.php");
  }
}
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="../menu.php"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body onload="focus1()">
</nav>
<center><h1>Make Payment</h1></center><hr>
<div class="container">
<form method="POST">
	<div class="row">
		<div class="col-md-3">
			<input type="date" class="form-control" value="<?php echo $fetch1['day'] ?>" name="day">
		</div>
	</div><br>
	<div class="row">
		<div class="col-md-3">
			<input list="group" id="" name="customer" placeholder="Chooe Customer" value="<?php echo $fetch3['name'] ?>" class="form-control" required>
               <datalist id="group">
                <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                             <?php
                              $sql="SELECT * FROM customer";
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
      <input type="" name="amount" value="<?php echo $fetch1['cr'] ?>" class="form-control" placeholder="Amount">
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-3">
      <input type="" name="remarks" class="form-control" value="<?php echo $fetch1['remarks'] ?>" placeholder="Remarks">
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-3">
      <button name="btn1" class="btn btn-primary">Add</button>
    </div>
  </div>
</form>
</div><!-- main container div end -->


<?php include('../footer.php'); ?>