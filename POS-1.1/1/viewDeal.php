<title>Deals</title>
<?php
include('../session.php');
include('../connect.php');
include('../header.php');
?>
<div class="container-fluid">
	<h2>Deals</h1>
	<h5>Here you can perform all actions</h6><hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-md-12">
			<table border="0" width="100%">
				<tr>
					<td><!-- <input type="submit" name="add" class="btn btn-success" value="New" data-toggle="modal" data-target="#myModal"> -->
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
						<th>DID</th>
						<th>Name</th>
						<th>Price</th>
						<th>Items</th>
						<th>Operation</th>
					</tr>
				</thead>
				<tbody id="tableData"></tbody>
          		<tfoot>
          			<tr>
						<th>DID</th>
						<th>Name</th>
						<th>Price</th>
						<th>Items</th>
						<th>Operation</th>
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
                <h4 class="modal-title">Product Form</h4>
                </div>
                <div class="modal-body">
                	<form method="POST" id="lockForms" enctype="multipart/form-data">
                		<table border="0" align="center" width="100%">
                			<tr>
                				<td>Select Category</td>
                				<td>
                					<select name="catName" class="form-control">
								        <?php
								        $result=mysqli_query($con,"SELECT * FROM category WHERE status!='0' AND name!='Stock' ORDER BY name");
								         while($fetch=mysqli_fetch_array($result)){?> 
								            <option value="<?php echo $fetch['id'];?>" selected><?php echo $fetch['name'];?></option>
								        <?php } ?>
                					</select>
                					</center><br>
                				</td>
                			</tr>
                			<tr>
                				<td>Name</td>
								<td><input type="text" name="pname" id="pname" class="form-control" autocomplete="off" placeholder="Enter Product Name" required><br></td>
                			</tr>
                			<tr>
                				<td>Weight</td>
								<td><input type="text" name="size" class="form-control" autocomplete="off" placeholder="Enter Weight"><br></td>
                			</tr>
                			<tr>
                				<td>Purchase Price</td>
								<td><input type="number" name="pprice" class="form-control" autocomplete="off" placeholder="Enter Purchase Price"><br></td>
                			</tr>
                			<tr>
                				<td>Wholesale Price</td>
								<td><input type="number" name="wprice" class="form-control" autocomplete="off" placeholder="Enter Wholesale Price"><br></td>
                			</tr>
                			<tr>
                				<td>Reatil Price</td>
								<td><input type="number" name="rprice" class="form-control" autocomplete="off" placeholder="Enter Reatil Price" ><br></td>
                			</tr>
                			<tr>
                				<td>Qty</td>
								<td><input type="number" name="qty" class="form-control" autocomplete="off" placeholder="Enter Qty"><br></td>
                			</tr>
                			<tr>
                				<td>Image</td>
								<td><input type="file" name="myFile" class="form-control" autocomplete="off"><br></td>
                			</tr>
                			<tr>
								<td colspan="2"><hr><input type="button" id="sigin" class="btn btn-primary" value="Submit"/>
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

<!-- Modal start -->
<div class="row">
    <div class="col-md-3">
    <!-- Modal -->
    <div id="myModal2" class="modal fade" role="dialog">
            <div class="modal-dialog" >
			<!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Form</h4>
                </div>
                <div class="modal-body">
                	<form method="POST" id="lockForms2" enctype="multipart/form-data">
                		<table border="0" align="center" width="100%">
                			<tr>
                				<td>Select Category</td>
                				<td>
                					<select name="ucatName" id="ucatName" class="form-control">
								        <?php
								        $result=mysqli_query($con,"SELECT * FROM category WHERE status!='0' AND name!='Stock' ORDER BY name");
								         while($fetch=mysqli_fetch_array($result)){?> 
								            <option value="<?php echo $fetch['id'];?>" selected><?php echo $fetch['name'];?></option>
								        <?php } ?>
                					</select>
                					</center><br>
                				</td>
                			</tr>
                			<tr>
                				<td>Name</td>
								<td><input type="text" name="upname" id="upname" class="form-control" autocomplete="off" placeholder="Enter Product Name" required><br></td>
                			</tr>
                			<tr>
                				<td>Weight</td>
								<td><input type="text" name="usize" id="usize" class="form-control" autocomplete="off" placeholder="Enter Weight"><br></td>
                			</tr>
                			<tr>
                				<td>Enter Purchase Price</td>
								<td><input type="number" name="upprice" id="upprice" class="form-control" autocomplete="off" placeholder="Enter Purchase Price"><br></td>
                			</tr>
                			<tr>
                				<td>Enter Wholesale Price</td>
								<td><input type="number" name="uwprice" id="uwprice" class="form-control" autocomplete="off" placeholder="Enter Wholesale Price"><br></td>
                			</tr>
                			<tr>
                				<td>Enter Reatil Price</td>
								<td><input type="number" name="urprice" id="urprice" class="form-control" autocomplete="off" placeholder="Enter Reatil Price" ><br></td>
                			</tr>
                			<tr>
                				<td>Enter Qty</td>
								<td><input type="number" name="uqty" id="uqty" class="form-control" autocomplete="off" placeholder="Enter Qty"><br></td>
                			</tr>
                			<tr>
                				<td>Image</td>
								<td><input type="file" name="myFile" class="form-control" autocomplete="off"><br></td>
                			</tr>
                			<tr>
								<td colspan="2"><hr><input type="button" id="update" class="btn btn-primary" value="Update"/>
								<input type="submit" id="update-hidden" value="update" style="display: none;" /><input type="hidden" id="pid" name="pid"/></td>
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
		        url: "operation.php?from=product&operation=insert",
		        type: 'POST',
		        data: formData,
		        async: false,
		        success: function (info) {
			 		//alert(info);
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

	$('#update').click(function () {
		if(!$("#lockForms2")[0].checkValidity()){
			$("#lockForms2").find("#update-hidden").click();
		}
		else {
			var formData = new FormData($("#lockForms2")[0]);
			$.ajax({
		        url: "operation.php?from=product&operation=update",
		        type: 'POST',
		        data: formData,
		        async: false,
		        success: function (info) {
			 		//alert(info);
			 		if(info==1){
			 			alert("Updated Successfully");
			 			show();
			 			$('#myModal2').modal('toggle');

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
	        url: "operation.php?from=deal&operation=show&num="+num,
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

	function status(id,status) {
		$.ajax({
	        url: "operation.php?from=deal&operation=status&id="+id+"&status="+status,
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

	function edit(id) {
		$.ajax({
	        url: "operation.php?from=product&operation=edit&id="+id,
	        type: 'GET',
	        async: false,
	        success: function (info) {
		 		// alert(info);
		 		data = info.split("|");
		 		$('#pid').val(data[0]);
		 		$('#upname').val(data[1]);
		 		$('#usize').val(data[2]);
		 		$('#upprice').val(data[3]);
		 		$('#uwprice').val(data[4]);
		 		$('#urprice').val(data[5]);
		 		$('#uqty').val(data[6]);
		 		// $('#ucateName').val(data[7]);
		 		$('#myModal2').modal('toggle');
	        },
	        cache: false,
	        contentType: false,
	        processData: false
	    });
	}

	function del(id) {
		$.ajax({
	        url: "operation.php?from=deal&operation=del&id="+id,
	        type: 'GET',
	        async: false,
	        success: function (info) {
		 		alert("Deleted Successfully");
		 		show();
	        },
	        cache: false,
	        contentType: false,
	        processData: false
	    });
	}
</script>