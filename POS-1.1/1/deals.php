<title>Deals</title>
<?php
include('../session.php');
include('../connect.php');
include('../header.php');
?>
<div class="container-fluid">
  <h2>Deals</h2>
  <h5>Here you can generate invoices</h5><hr>
  <form method="POST" id="lockForms">
  <div class="row">
    <div class="col-md-2">
      <label>Deal Name</label>
      <input type="text" name="dname" id="dname" class="form-control" autocomplete="off" placeholder="Enter Deal Name" required>
    </div>
    <div class="col-md-2">
      <label>Deal Price</label>
      <input type="number" name="dprice" id="dprice" class="form-control" autocomplete="off" placeholder="Enter Deal Price" required>
    </div>
    <div class="col-md-2">
    <label>Select Category</label>
    <select name="dCat" id="dCat" class="form-control">
		<option selected>--- Select ---</option>
        <?php
        $result=mysqli_query($con,"SELECT * FROM category WHERE status!='0' AND name!='Stock' ORDER BY name");
         while($fetch=mysqli_fetch_array($result)){?> 
            <option value="<?php echo $fetch['id'];?>"><?php echo $fetch['name'];?></option>
        <?php } ?>
	</select>
    </div>
    <!-- <div class="col-md-2">
      <label>Select Items</label>
      <select name="ditems" id="ditems" class="form-control"></select>
    </div> -->
    <div class="col-md-2">
      <label>Qty</label>
      <input type="number" name="dqty" id="dqty" class="form-control" autocomplete="off" placeholder="Enter Qty" required onblur="insertInfo()">
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>           
            <th>Items</th>                    
            <th>Qty</th>            
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="item-details"></tbody>
      </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2">
        <input type="button" id="save" class="btn btn-primary" value="Save" style="margin-top:4px"/>
        <input type="submit" id="submit-hidden" value="submit" style="display:none;">
      </div>
    </div>  
  </form>
</div>
<?php 
include('../footer.php'); 
include('../subscription.php');
?>
<script type="text/javascript">
$(document).ready(function () {
  $('#save').click(function () {
    var qty = $("#qty").val();
    if(!$("#lockForms")[0].checkValidity()){
      $("#lockForms").find("#submit-hidden").click();
    }
    else if(qty==""){
      alert("Please Select Product");
    }
    else {
      var formData = new FormData($("#lockForms")[0]);
      $.ajax({
          url: "operation.php?from=deal&operation=insert",
          type: 'POST',
          data: formData,
          async: false,
          success: function (info) {
            alert("Inserted Successfully");
            location.reload();
          },
          cache: false,
          contentType: false,
          processData: false
      });
    }
  });
});

  function append(argument) {
    var n=($('#item-details tr').length-0)+1;
    var newRow="";
        newRow= '<tr>'+  
      '<td><input type="text" class="form-control itemName" name="itemName[]" id="itemName'+n+'" placeholder="Item Name" autocomplete="off"><input type="hidden" class="form-control itemId" name="itemId[]" id="itemId'+n+'" placeholder="itemId" autocomplete="off"></td>'+ 
      '<td><input type="text" class="form-control qty" name="qty[]" id="qty'+n+'" placeholder="Qty" autocomplete="off"></td>'+
      '<td><a href="#" onclick="remove('+n+')" class="btn btn-danger remove"><i class="fa fa-trash-o"></i></a></td>'+
      '</tr>';
      $("#item-details").append(newRow);
  }
  

  $('body').delegate('.remove','click',function()  {
    $(this).parent().parent().remove();
    n--;
  });

  	function insertInfo() {
  		// var ditem = $("#ditems").val();
		var dcat = $("#dCat").val();
		var dqty = $("#dqty").val();
  		$.ajax({
	        url: "operation.php?from=deal&operation=getInfo&id1="+dcat,
	        type: 'GET',
	        /*data: formData,*/
	        async: false,
	        success: function (info) {
		 		// alert(info);
		 		var num = ($('#item-details tr').length-0)+1;
		   	    append();
		   	    var data = info.split("|");
			    $("#itemName"+num).val(data[0]);
			    $("#itemId"+num).val(dcat);
			    $("#qty"+num).val(dqty);  
			    $("#dCat").focus()
	        },
	        cache: false,
	        contentType: false,
	        processData: false
		});
   	    
  	}

 //  function getItem(id) {
	// 	$.ajax({
	//         url: "operation.php?from=deal&operation=get&id="+id,
	//         type: 'GET',
	//         /*data: formData,*/
	//         async: false,
	//         success: function (info) {
	// 	 		// alert(info);
	// 	 		$("#ditems").html(info);
	//         },
	//         cache: false,
	//         contentType: false,
	//         processData: false
	// 	});
	// }
</script>