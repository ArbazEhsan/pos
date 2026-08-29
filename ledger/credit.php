<?php include('../session.php'); ?>
<title>Edit Cash In</title><?php include('../header.php');include('../connect.php');?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="../menu.php"><span aria-hidden="true">&larr;</span> Menu</a></li>
    <!--<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>-->
  </ul>
</nav>
<center><h1>Cashin Detail</h1></center><hr>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-hover table-striped">
				<tr>
					<th>Day</th>
					<th>Customer</th>
					<th>Amount</th>
					<th>Remarks</th>
					<th>Operation</th>
				</tr>
				<?php 
					$result = mysqli_query($con,"SELECT * FROM ledger WHERE type='cr'");
					while($fetch = mysqli_fetch_array($result))
					{				
				?>
				<tr>
				<td><?php echo $fetch['day']; ?></td>
				<td><?php echo $fetch['customer']; ?></td>
				<td><?php echo $fetch['cr']; ?></td>
				<td><?php echo $fetch['remarks']; ?></td>
				<td><a href="del.php?id=<?php echo $fetch['id'] ?>" class="btn btn-danger" onclick="return func()">Delete</a> <a href="edit.php?id=<?php echo $fetch['id'] ?>" class="btn btn-primary">Edit</a></td>
			</tr>
				<?php } ?>
			</table>
		</div>
	</div>
</div>


<?php include('../footer.php'); ?>
<script type="text/javascript">
  function func()
  {
    text = confirm("Warning: Are you sure you want to delete?");
    if(text == true)
    {
      return ture;
    }
    else
    {
      return false;
    }
  }
</script>