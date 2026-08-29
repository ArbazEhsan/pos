<?php include('../session.php'); include('../connect.php');
include('../converter.php');include('../header.php');

  $id = $_GET['id'];
  if (isset($_POST['btn1'])) {
  	$day      = $_POST['day'];
  	$amount   = $_POST['amount'];
  	$naration = $_POST['naration'];
  	mysqli_query($con,"UPDATE expense SET amount='$amount',day='$day',naration='$naration' WHERE id='$id'");
    mysqli_query($con,"UPDATE cashout SET amount='$amount',day='$day',naration='$naration' WHERE expense_Id='$id'");
  	header("Location:expense.php?Updated");
  }
  $result = mysqli_query($con,"SELECT * FROM expense WHERE id='$id'");
  $fetch  = mysqli_fetch_array($result);
  
?>

<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="expense.php"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body>
</nav>
<center><h1>Edit Expense Detail</h1></center><hr>
<div class="container">
<form  method="post"> 
	<div class="row">
		<div class="col-md-3">
			<input type="date" class="form-control" name="day" value="<?= $fetch['day']; ?>" required>
		</div>
	</div><br>
	
  <div class="row">
    <div class="col-md-3">
      <input type="" name="amount" class="form-control" value="<?= $fetch['amount']; ?>" placeholder="Amount" required>
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-3">
      <input type="" name="naration" class="form-control" value="<?= $fetch['naration']; ?>" placeholder="Naration">
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-3">
      <button name="btn1" class="btn btn-primary">Update</button>
    </div>
  </div>
</form>
</div>