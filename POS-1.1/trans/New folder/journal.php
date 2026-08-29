
<title>Journal Voucher</title><?php include('../session.php'); include('../header.php');include('../connect.php');
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body>
</nav>
<center><h1>Journal Voucher</h1></center><hr>
<div class="container">
<form method="POST" id="formId"> 
  <div class="row">
		<div class="col-md-3">
			<input type="date" class="form-control" name="day" value="<?php echo date('Y-m-d'); ?>">
		</div>
    <div class="col-md-3">
      <input list="group" id="customer" name="customer" placeholder="Choose Account" class="form-control" autocomplete="off" required>
        <datalist id="group">
          <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu">
             <?php
              $sql="SELECT * FROM accounts WHERE active='1' ORDER BY type";
              $result=mysqli_query($con,$sql);
               while($fetch=mysqli_fetch_array($result))
                {
                ?> 
             <option value="<?php echo $fetch['name'];?>"><?php echo $fetch['type'];?> </option>
             <?php } ?>
          </ul>
          </datalist>
    </div>
	</div><br>
	<div class="row">
    <div class="col-md-3">
      <input list="group1" id="product" name="product" placeholder="Choose Product" class="form-control" autocomplete="off">
        <datalist id="group1">
          <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu">
           <?php
            $sql1="SELECT * FROM products WHERE active='1' ORDER BY name";
            $result1=mysqli_query($con,$sql1);
             while($fetch1=mysqli_fetch_array($result1))
              {
              ?> 
           <option value="<?php echo $fetch1['name'];?>"><?php echo $fetch1['type'];?> </option>
           <?php } ?>
          </ul>
        </datalist><br>
    </div>
     <div class="col-md-3">
      <input type="number" id="qty" name="qty" class="form-control" placeholder="Qty">
    </div>
	</div>
  <div class="row">
    <div class="col-md-3">
      <input type="number" id="amount" name="amount" class="form-control" placeholder="Amount" required>
    </div>
     <div class="col-md-3">
      <input type="text" name="naration" class="form-control" placeholder="Naration">
    </div>
  </div><br>
  <!-- <div class="row">
    <div class="col-md-3">
      <input type="" name="remarks" class="form-control" placeholder="Received By">
    </div>
  </div><br> -->
  <div class="row">
    <div class="col-md-3">
      <button name="btn1" class="btn btn-primary" onclick="save()">Add</button>
    </div>
  </div>
</form>
</div><!-- main container div end -->
<?php include('../footer.php'); ?>
<script type="text/javascript">
  function save() { 
    cname = $('#customer').val();
    product = $('#product').val();
    qty = $('#qty').val();
    amount = $('#amount').val();
    if(cname==''){
      alert("Please Select Account!");
      $("#formId").submit(function(e){
        e.preventDefault();
      });
    }
    // else if(product==''){
    //   alert("Please Enter Product!");
    //   $("#formId").submit(function(e){
    //     e.preventDefault();
    //   });
    // }
    // else if(qty==''){
    //   alert("Please Enter Qty!");
    //   $("#formId").submit(function(e){
    //     e.preventDefault();
    //   });
    // }
    else if(amount==''){
      alert("Please Enter Amount!");
      $("#formId").submit(function(e){
        e.preventDefault();
      });
    }
    else {

    var formData = new FormData($("#formId")[0]);
    $.ajax({
      url: "operation.php?from=journal",
      type: 'POST',
      data: formData,
      dataType: "text",
      async: false,
      success: function (info) {
        alert(info);
        //window.open('printcashin.php?sale_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
        window.location.reload();
        },
        cache: false,
         contentType: false,
        processData: false
      });
    }
  }
</script>