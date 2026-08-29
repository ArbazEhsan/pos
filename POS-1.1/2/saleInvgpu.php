<?php  
include('../session.php');
include("../connect.php");
include("../header.php");
?>
<style type="text/css">
	#ho:hover{
		background-color: #E9E9E9;
	}
	.inputt {
		text-align: center;
		font-size: 50px;
		width: 70%;
	}
</style>

<div class="container-fluid"><br>
	<table class="table table-bordered">
		<tr>
			<td style="width:72%">
				<h3>Menu</h3>
				<?php 
					$result = mysqli_query($con,"SELECT * FROM category WHERE status='1' AND name!='Stock'");
					while($fetch=mysqli_fetch_array($result)){
				?>
				<div class="col-md-2" id="ho" style="border:1px solid black;padding: 10px;border-radius: 20px;margin: 10px;" data-toggle="modal" data-target="#myModal" onclick="getItem('<?php echo $fetch['name']; ?>','<?php echo $fetch['id']; ?>','menu')">
					<center>
					<img src="../assets/img/<?php echo $fetch['image_url']; ?>" width="60"><br>
					<label><?php echo $fetch['name']; ?></label>
					</center>
				</div>
				<?php }?>
				<!-- <h3>Deals</h3> -->
				<?php 
					$result = mysqli_query($con,"SELECT * FROM dcounter WHERE status='1'");
					while($fetch=mysqli_fetch_array($result)){
				?>
				<div class="col-md-2" id="ho" style="border:1px solid black;padding: 10px;border-radius: 20px;margin: 10px;" data-toggle="modal" data-target="#myModal" onclick="getItem('<?php echo $fetch['dealName']; ?>','<?php echo $fetch['id']; ?>','deal')">
					<center>
					<img src="../assets/img/meals.png" width="60"><br>
					<label><?php echo $fetch['dealName']; ?></label>
					</center>
				</div>
				<?php }?>
			</td>
			<td>
				<div class="col-md-12">
					<form method="POST" id="lockForm3">
					<table class="table table-bordered">
						<thead>
							<tr>
								<td><input type="button" value="Save" id="sigin" accesskey="s"><input type="submit" id="submit-hidden" value="submit" style="display: none;" /><input type="reset" id="reset-hidden" value="reset" style="display: none;" /></td>
								<td>Net Bill <input type="text" class="form-control" id="netBill1" placeholder="Net Bill" disabled required style="font-size:20px;">Entry Date <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required disabled>Sale Type<select class="form-control" name="menuSaleType" id="menuSaleType">
									<option>Sale</option>
									<option>Takeaway</option>
									<option>Delivery</option>
									<option>Dine in</option>
									<option>FoodPanda</option>
									</select>Discount (%)<input type="number" name="invDiscount" id="invDiscount" value="0" class="form-control" placeholder="Discount" onkeyup="dicount(this.value)" onblur="focusToCustPhone()"></td>
							</tr>
						</thead>
					</table>
				
					<table class="table table-bordered">
						<thead>
						<tr>
							<th>Name</td>
							<th>Qty</td>
							<th>Rate</td>
							<th></th>
						</tr>
						</thead>
						<tbody id="item-details"></tbody>
						
					</table>
					
					<table class="table table-bordered">
						<tfoot>
							<tr>
								<td>
									CUST Phone<input type="text" class="form-control" id="custPhone" name="custPhone" placeholder="Cust Phone" onchange="custHistory()" required>
									CUST Name<input type="text" class="form-control" id="custName" name="custName" placeholder="Cust Phone">
									CUST Address<input type="text" class="form-control" id="custAddress" name="custAddress" placeholder="Cust Address">
								</td>
								<td colspan="4">
									Comments<input type="text" class="form-control" id="comments" name="comments" placeholder="Comments">
									Received<input type="number" class="form-control" id="received" name="received" placeholder="Received" onkeyup="receivedAmnt()" required>
									Remaining<input type="number" class="form-control" id="remaining" name="remaining" placeholder="Remaining" disabled>
								</td>
								
							</tr>
						</tfoot>
					</table>
					<table class="table table-bordered">
						<tfoot>
							<tr>
								<td>
									CUST Last Order<textarea name="history" id="history" class="form-control" disabled></textarea>
								</td>
								
							</tr>
						</tfoot>
					</table>
					</form>
				</div>
			</td>
		</tr>
		<!-- <tr>
			<td style="width:72%">
				
			</td>
		</tr> -->
	</table>
	<div class="row">
		
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
                <h4 class="modal-title">Details of <span id="foodName"></span></h4>
                </div>
                <div class="modal-body">
                	<form method="GET" id="lockForms">
                		<table border="0" align="center" width="100%">
                			<tr>
                				<td><div class="form-inline">
                					<br><center>
									<input type="button" value="-" class="minus" onclick="sub()" style="font-size:50px;padding: 15px;"><input type="number" step="1" min="1" max="" name="quantity" id="quantity" value="1" title="Qty" class="inputt" size="4" pattern="" inputmode=""><input type="button" value="+" class="plus" onclick="add()"  style="font-size:50px;padding: 15px;"></center></div><br>
								</td>
                			</tr>
                			<tbody>
                				<tr>
                				<td>
                				<label>Select</label>
                				<select name="flavour" class="form-control" style="width: 100%;" id="item-details2" multiple>
                				</select>
                				</td>
                				</tr>
                			</tbody>
                			<tr>
								<td colspan="2"><hr><input type="button" class="btn btn-primary" value="Submit" onclick="getProductInfo()" />
								<!-- <input type="submit" id="submit-hidden" value="submit" style="display: none;" /><input type="reset" id="reset-hidden" value="reset" style="display: none;" /> -->
								<input type="hidden" id="pid" name="pid" /><input type="hidden" id="menu" name="menu" /></td>
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
	</div>
</div>

<?php 
include('../footer.php'); 
include('../subscription.php');
?>

<script type="text/javascript">
	function getItem(name,id,from) {
		$("#foodName").html(name);
		$("#pid").val(id);
		$("#menu").val(from);
		$.ajax({
	        url: "operation.php?from=gpusale&operation=get&id="+id+"&menu="+from,
	        type: 'GET',
	        /*data: formData,*/
	        async: false,
	        success: function (info) {
		 		// alert(info);
		 		$("#item-details2").html(info);
	        },
	        cache: false,
	        contentType: false,
	        processData: false
		});
	}

	function add(){
		var x = Number($(".inputt").val());
		if(x>0){
			x = x+1;
			$(".inputt").val(x);
		}
	}

	function sub(){
		var x = Number($(".inputt").val());
		if(x>1){
			x = x-1;
			$(".inputt").val(x);
		}
	}

	function append(argument) {
    var n=($('#item-details tr').length-0)+1;
    var newRow="";
        newRow= '<tr>'+  
        '<td><span id="pname'+n+'"></span><input type="hidden" class="form-control pname" name="tpname[]" id="tpname'+n+'" placeholder="pname" autocomplete="off"><input type="hidden" class="form-control pcname" name="tcname[]" id="tcname'+n+'" placeholder="pcname" autocomplete="off"></td>'+
      	'<td><span id="qty'+n+'"></span><input type="hidden" class="form-control pqty" name="pqty[]" id="pqty'+n+'" placeholder="pqty" autocomplete="off"></td>'+  
      	'<td><span id="rate'+n+'"></span><input type="hidden" class="form-control prate" name="prate[]" id="prate'+n+'" placeholder="prate" autocomplete="off"><input type="hidden" class="form-control purprice" name="purprice[]" id="purprice'+n+'" placeholder="purprice" autocomplete="off"><input type="hidden" class="form-control total" name="total[]" id="total'+n+'" placeholder="total" autocomplete="off"><input type="hidden" class="form-control netBill" name="netBill" id="netBill" placeholder="netBill" autocomplete="off"><input type="hidden" class="form-control sale_day" name="sale_day" id="sale_day" placeholder="sale_day" value="<?php echo date('Y-m-d'); ?>" autocomplete="off"><input type="hidden" class="form-control menuType" name="menuType[]" id="menuType'+n+'" placeholder="netBill" autocomplete="off"></td>'+
      	'<td><a href="#" onclick="remove('+n+')" class="btn btn-danger remove"><i class="fa fa-trash-o"></i></a></td>'+
      	'</tr>';
      	$("#item-details").append(newRow);
  	}

  	$('body').delegate('.remove','click',function()  {
	    $(this).parent().parent().remove();
	    total();
	    $("#gross").focus();
	    n--;
	});

	function getProductInfo() {
		var from = $("#menu").val();
		var cid = $("#pid").val();
		var pid = $("#item-details2").val();
		var qty = $("#quantity").val();
		var num = ($('#item-details tr').length-0)+1;
	    $.ajax({
	        url: "operation.php?from=gpusaleInvoice&operation=show&id="+pid+"&qty="+qty+"&menu="+from+"&cid="+cid,
	        type: 'GET',
	        async: false,
	        success: function (info) {
	          // alert(info);
	          append();
	          var data = info.split("|");
	          $("#prate"+num).val(data[0]);
	          if(from=='menu'){
	          	$("#tpname"+num).val(pid);
	          } else {
	          	$("#tpname"+num).val(cid);
	          }
	          $("#tcname"+num).val(pid);
	          $("#menuType"+num).val(from);
	          $("#pqty"+num).val(qty);
	          $("#total"+num).val(data[1]);
	          $("#purprice"+num).val(data[2]);

	          /* showing results */
	          $("#rate"+num).html(data[0]);
	          $("#pname"+num).html(data[4]+" - "+data[3]);
	          $("#qty"+num).html(qty);
	          $('#myModal').modal('toggle');
	          total();
	          $("#menuSaleType").focus();
	        },
	        cache: false,
	        contentType: false,
	        processData: false
	    });
	}

	function total() {
	    var z = 0;
	    $("#item-details tr").each(function() {
	      var x = $(this).find('.total').val();
	      z = Number(z)+Number(x);
	    });   
	    $(".netBill").val(z);
	    $("#netBill1").val(z);
	    $("#remaining").val(z);
	}

	function dicount(val) { 
	    var z = $(".netBill").val();
	    var y = Math.round(val/100*z);
	    var c = z-y;
	    $("#netBill1").val(c);
	}

	function focusToCustPhone() {
	    $("#custPhone").focus();
	}

	function receivedAmnt(){
	    var received = $("#received").val();
	    var grandTotal = $("#netBill1").val();
	    var remain = Number(grandTotal)-Number(received);
	    $("#remaining").val(remain);
	}

	function custHistory(){
		var phone = $("#custPhone").val();
	    $.ajax({
	        url: "operation.php?from=gpusale&operation=custHistory&phone="+phone,
	        type: 'GET',
	        // data: formData,
	        async: false,
	        success: function (info) {
	        	// alert(info);
	        	$("#history").html(info);
	        },
	        cache: false,
	        contentType: false,
	        processData: false
	    });
	}

$(document).ready(function () {
$('#sigin').click(function () {
	if(!$("#lockForm3")[0].checkValidity()){
		$("#lockForm3").find("#submit-hidden").click();
	}
	else {
		if($("#netBill").val()!=""){
		var formData = new FormData($("#lockForm3")[0]);
		$.ajax({
	        url: "operation.php?from=gpusale&operation=insert",
	        type: 'POST',
	        data: formData,
	        async: false,
	        success: function (info) {
		 		 // alert(info);
		 		window.open('salePrint.php?sale_No='+info,'popUpWindow','height=500,width=500,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
            	location.reload();
	        },
	        cache: false,
	        contentType: false,
	        processData: false
	    });
		} else {
			alert("Please Select Product");
		}
	}
	});
});
</script>