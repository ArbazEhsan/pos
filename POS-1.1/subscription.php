<title>Monthly Payments</title>
<!-- modal start -->
<?php include('modalHeader.php'); ?>
<p style="color: black;">Please, Pay the Monthly Installment in order to countinue the Process, <br> Contact at 03137747660</p>
<div class="row" style="margin-top: -20px">
	<div class="col-md-8">
		<form id="lockForm" method="GET">
		<label>Serial Key</label>
		<input type="text" name="skey" class="form-control" placeholder="Serial Key" autocomplete="off">
		</form>
		<input type="submit" name="sbtn" value="Activate" class="btn btn-primary" style="margin-top: 10px;" onclick="serialKey()" required>
	</div>
</div>
<?php include('modalFooter.php'); ?>
<!-- modal end -->

<?php  
 $currentDate = date('Y-m').'-01';
 $result = mysqli_query($con,"SELECT * FROM subscription WHERE month='$currentDate'");
 $fetch = mysqli_fetch_array($result);
 if ($fetch['status']==0) {
   echo '<script type="text/javascript">$("#myModalSubs").modal("show");</script>';
 }
?>

<script type="text/javascript">
function serialKey(){
	$.ajax({
	    type: "GET",
	    url:"../saveSerialKey.php",
	    data: $('#lockForm').serialize(),
	    success:function(response) {
	      if(response='Activated'){
	      	location.reload();
	      }
	    },
	    error: function (error) {
	      console.log(error);
	      alert("Please, Try Again Latter");
	    }
	});
}
</script>
