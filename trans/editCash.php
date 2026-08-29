<?php 
include('../session.php'); include('../connect.php');
include('../converter.php');include('../header.php');

$id = $_GET['id'];
$vno = $_GET['vno'];
$from = $_GET['from'];
$result = mysqli_query($con,"SELECT * FROM trans WHERE id='$id'");
$fetch = mysqli_fetch_array($result);
if (isset($_POST['update'])) {
  $day = $_POST['day'];
  mysqli_query($con,"UPDATE tcounter SET day='$day' WHERE voucher_no='$vno'");
	mysqli_query($con,"UPDATE trans SET day='$day' WHERE id='$id'");
  mysqli_query($con,"UPDATE ledgers SET day='$day' WHERE trans_id='$id'");
  if ($from=='CR') {
    header("Location:viewCashin.php?msg=updated");
  }
  elseif ($from=='CO') {
    header("Location:viewCashout.php?msg=updated");
  }
  
}
  
?>

<center><h1>Update Cash Date</h1></center><hr>
<div class="container">
  <form method="POST">
    <div class="row">
      <div class="col-md-3">
        <input type="date" class="form-control" name="day" value="<?php echo $fetch['day']; ?>" required>
      </div>
      <div class="col-md-3">
        <input type="text" name="vno" class="form-control" placeholder="Voucher No" autocomplete="off" value="<?php echo $vno; ?>" required disabled>
      </div>
    </div><br>
  <div class="row">
      <div class="col-md-3">
        <button class="btn btn-primary" name="update">Update</button>
      </div>
  </div>
  </form>
</div>
<?php include('../footer.php'); include('../subscription.php'); ?>