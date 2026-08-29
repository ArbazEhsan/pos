<title>Accounts</title>
<?php
include('../session.php');
include('../connect.php');
include('../header.php');
?>
<div class="container-fluid">
	<h2>Accounts</h2>
	<h5>Here you can perform all actions</h5><hr>
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
						<th>Type</th>
						<th>A/C#</th>
						<th>A/C Title</th>
						<th>Designation</th>
						<th>Salary</th>
						<th>Contact</th>
						<th>P.#1</th>
						<th>P.#2</th>
						<th>City</th>
						<th>Address</th>
						<th>Operation</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody id="tableData"></tbody>
          		<tfoot>
          			<tr>
						<th>Type</th>
						<th>A/C#</th>
						<th>A/C Title</th>
						<th>Designation</th>
						<th>Salary</th>
						<th>Contact</th>
						<th>P.#1</th>
						<th>P.#2</th>
						<th>City</th>
						<th>Address</th>
						<th>Operation</th>
						<th>Status</th>
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
                <h4 class="modal-title">Accounts Form</h4>
                </div>
                <div class="modal-body">
                	<form method="POST" id="lockForms">
                		<table border="0" align="center" width="100%">
                			<tr>
                				<td>Enter Type</td>
								<td><select class="form-control" name="type" required>
									<option disabled selected>-- Select Type --</option>
									<option>Asset</option>
									<option>Capital</option>
									<option>Customer</option>
									<option>Expense</option>
									<option>Liability</option>
									<option>Vendor</option>
								</select><br></td>
                			</tr>
                			<tr>
                				<td>A/C Title</td>
								<td><input type="text" name="name" placeholder="Enter A/C Title" class="form-control" required><br></td>
                			</tr>
                			<tr>
                				<!-- <td>Designation</td>
								<td><input type="text" name="designation" placeholder="Enter Designation" class="form-control"><br></td> -->
								<td>Designation</td>
								<td><select class="form-control" name="designation" required>
									<option disabled selected>-- Select Type --</option>
									<option>Assistant Manager</option>
									<option>General Manager</option>
									<option>Branch Manager</option>
									<option>Store Manager</option>
									<option>Accountant</option>
									<option>Kitchen Manager</option>
									<option>Cashier</option>
									<option>Dishwasher</option>
									<option>Drive-thru Operator</option>
									<option>Executive Chef</option>
									<option>Fast Food Cook</option>
									<option>Line Cook</option>
									<option>Short Order Cook</option>
									<option>Waiter</option>
									<option>Swiper</option>
									<option>Guard</option>
								</select><br></td>
                			</tr>
                			<tr>
                				<td>Salary</td>
								<td><input type="text" name="salary" placeholder="Enter Salary" class="form-control"><br></td>
                			</tr>
                			<tr>
                				<td>Contact Person</td>
								<td><input type="number" name="contact" placeholder="Enter Contact Person" class="form-control"><br></td>
                			</tr>
                			<tr>
                				<td>Phone#1</td>
								<td><input type="number" name="phone1" placeholder="Enter Phone#1" class="form-control"><br></td>
                			</tr>
                			<tr>
                				<td>Phone#2</td>
								<td><input type="number" name="phone2" placeholder="Enter Phone#2" class="form-control"><br></td>
                			</tr>
                			<tr>
                				<td>City</td>
								<td><input type="text" name="city" placeholder="Enter City" class="form-control"><br></td>
                			</tr>
                			<tr>
                				<td>Address</td>
								<td><input type="text" name="address" placeholder="Enter Address" class="form-control"></td>
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
                	<form method="POST" id="lockForms2">
                		<table border="0" align="center" width="100%">
                			<tr>
                				<td>Enter Type</td>
								<td><select class="form-control" name="utype" id="utype" required>
									<option disabled selected>-- Select Type --</option>
									<option>Asset</option>
									<option>Capital</option>
									<option>Customer</option>
									<option>Expense</option>
									<option>Liability</option>
									<option>Vendor</option>
								</select><br></td>
                			</tr>
                			<tr>
                				<td>A/C Title</td>
								<td><input type="text" name="uname" id="uname" placeholder="Enter A/C Title" class="form-control" required><br></td>
                			</tr>
                			<tr>
                				<td>Designation</td>
								<td><input type="text" name="udesignation" id="udesignation" placeholder="Enter Designation" class="form-control"><br></td>
                			</tr>
                			<tr>
                				<td>Salary</td>
								<td><input type="text" name="usalary" id="usalary" placeholder="Enter Salary" class="form-control"><br></td>
                			</tr>
                			<tr>
                				<td>Contact Person</td>
								<td><input type="number" name="ucontact" id="ucontact" placeholder="Enter Contact Person" class="form-control"><br></td>
                			</tr>
                			<tr>
                				<td>Phone#1</td>
								<td><input type="number" name="uphone1" id="uphone1" placeholder="Enter Phone#1" class="form-control"><br></td>
                			</tr>
                			<tr>
                				<td>Phone#2</td>
								<td><input type="number" name="uphone2" id="uphone2" placeholder="Enter Phone#2" class="form-control"><br></td>
                			</tr>
                			<tr>
                				<td>City</td>
								<td><input type="text" name="ucity" id="ucity" placeholder="Enter City" class="form-control"><br></td>
                			</tr>
                			<tr>
                				<td>Address</td>
								<td><input type="text" name="uaddress" id="uaddress" placeholder="Enter Address" class="form-control"></td>
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
	td = tr[i].getElementsByTagName("td")[2];
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
		        url: "operation.php?from=accounts&operation=update",
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

	function status(id,status) {
		$.ajax({
	        url: "operation.php?from=accounts&operation=status&id="+id+"&status="+status,
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

	function setDefault(id) {
		$.ajax({
	        url: "operation.php?from=accounts&operation=default&id="+id,
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
	        url: "operation.php?from=accounts&operation=edit&id="+id,
	        type: 'GET',
	        async: false,
	        success: function (info) {
		 		// alert(info);
		 		data = info.split("|");
		 		$('#pid').val(data[0]);
		 		$('#utype').val(data[1]);
		 		$('#uname').val(data[2]);
		 		$('#ucontact').val(data[3]);
		 		$('#uphone1').val(data[4]);
		 		$('#uphone2').val(data[5]);
		 		$('#ucity').val(data[6]);
		 		$('#uaddress').val(data[7]);
		 		$('#udesignation').val(data[8]);
		 		$('#usalary').val(data[9]);
		 		$('#myModal2').modal('toggle');
	        },
	        cache: false,
	        contentType: false,
	        processData: false
	    });
	}
</script>