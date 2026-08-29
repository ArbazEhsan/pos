<title>Rights</title>
<?php
include('../session.php');
include('../connect.php');
include('../header.php');
?>
<div class="container-fluid">
	<h2>User Rights</h1>
	<h5>Here you can perform all actions</h6><hr>
	<div class="row">
		<div class="col-md-4">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Emp#</th>
						<th>A/C Title</th>
						<th>Type</th>
						<th>Password</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$result=mysqli_query($con,"SELECT * FROM user WHERE id='".$_SESSION['id']."'");
						while($fetch=mysqli_fetch_array($result)){ ?>
					<tr>
						<td><?php echo $fetch['id'] ?></td>
						<td><?php echo $fetch['username'] ?></td>
						<td><?php echo $fetch['type'] ?></td>
						<td><?php echo $fetch['password'] ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-md-12">
			<table border="0" width="100%">
				<tr>
					<td><input type="submit" name="add" class="btn btn-success" value="New" data-toggle="modal" data-target="#myModal">
					&nbsp;&nbsp;Show
						<select name="show" id="show" onchange="show()" style="font-size: 14px;">
							<option>10</option>
							<option>25</option>
							<option>50</option>
							<option>100</option>
							<option>200</option>
						</select>
						entries	</td>
					<!-- <td style="text-align: right;">Search:</td> -->
					<td><input type="text" name="search" id="myInput" class="form-control" placeholder="Search By Name" autocomplete="off" autofocus="on" style="float: right; width: 50%" onkeyup="myFunction()"><span style="float: right;margin-top: 9px;">Search:&nbsp;</span></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped table-bordered" id="myTable">
				<thead>
					<tr>
						<th>Emp#</th>
						<th>Name</th>
						<th>Type</th>
						<th>Password</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="tableData"></tbody>
          		<tfoot>
          			<tr>
						<th>Emp#</th>
						<th>Name</th>
						<th>Type</th>
						<th>Password</th>
						<th></th>
					</tr>
					<tr>
						<td colspan="8"><span id="resultCount">Showing 1 to 10 of 96 entries</span></td>
					</tr>
          		</tfoot>
			</table>
		</div>
	</div>
</div>

<!-- Modal start -->
<div class="row">
    <div class="col-md-3">
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog" >
			<!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create User</h4>
                </div>
                <div class="modal-body">
                	<form method="POST" id="lockForms">
                		<table border="0" align="center" width="100%">
                			<tr>
                				<td>User Name</td>
								<td><input type="text" name="uname" id="uname" placeholder="Enter Username" autocomplete="off" autofocus class="form-control" required><br></td>
                			</tr>
                			<tr>
                				<td>Password</td>
								<td><input type="text" name="pass" id="udesignation" placeholder="Enter Password" class="form-control" required><br></td>
                			</tr>
                			<tr>
                				<td>Type</td>
								<td>
								<select name="type" id="type" class="form-control" required>
									<option value="Kitchen">Kitchen-Employee</option>
									<option value="SaleCounter">SaleCounter-Employee</option>
									<option value="Admin">Admin</option>
								</select><br></td>
                			</tr>
                			<tr>
								<td colspan="2"><hr><input type="button" id="sigin" class="btn btn-primary" value="Create"/>
								<input type="submit" id="submit-hidden" value="submit" style="display: none;" /><input type="reset" id="reset-hidden" value="reset" style="display: none;" /></td>
							</tr>
                		</table>
                	</form>
                </div>
            <div class="modal-footer">
            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
          	</div>
        </div>
      </div>
    </div>
	</div>
</div>
<!-- Modal end -->

<?php 
include('../footer.php'); 
include('../subscription.php');
?>
<script type="text/javascript">
function myFunction() {
	var input, filter, table, tr, td, i;
	input = document.getElementById("myInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");

	for (i = 0; i < tr.length; i++) {
	td = tr[i].getElementsByTagName("td")[1];
		if (td) {
		  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
		    tr[i].style.display = "";
		  } else {
		    tr[i].style.display = "none";
		  }
		} 
	}
}

$(document).ready(function () {
	$('#sigin').click(function () {
		if(!$("#lockForms")[0].checkValidity()){
			$("#lockForms").find("#submit-hidden").click();
		}
		else {
			var formData = new FormData($("#lockForms")[0]);
			$.ajax({
		        url: "operation.php?from=accounts&operation=insert",
		        type: 'POST',
		        data: formData,
		        async: false,
		        success: function (info) {
			 		// alert(info);
			 		if(info==1){
			 			alert("Inserted Successfully");
			 			show();
			 			$("#lockForms").find("#reset-hidden").click();
			 			$('#myModal').modal('toggle');
			 		}
			 		else {
			 			alert("Failed try again");
			 		}
		        },
		        cache: false,
		        contentType: false,
		        processData: false
		    });
		}
	});

	show();
});

	function show() {
		var num = $('#show').val();
		$.ajax({
	        url: "operation.php?from=accounts&operation=show&num="+num,
	        type: 'GET',
	        async: false,
	        success: function (info) {
		 		//alert(info);
		 		var data = info.split("|");
		 		$('#tableData').html(data[0]);
		 		$('#resultCount').html('Showing 1 to '+num+' of '+data[1]+' entries')
	        },
	        cache: false,
	        contentType: false,
	        processData: false
	    });
	}

	function del(id) {
		$.ajax({
	        url: "operation.php?from=accounts&operation=delete&id="+id,
	        type: 'GET',
	        async: false,
	        success: function (info) {
		 		//alert(info);
		 		show();
	        },
	        cache: false,
	        contentType: false,
	        processData: false
	    });
	}

	
</script>