<title>Purchase Return</title>
<?php include('../session.php'); include('../header.php');include('../connect.php'); ?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
</nav>
<center><h1>Purchase Return Menu</h1></center><hr>

<div class="container">
  <form id="lockForm">
  <h3>Please fill following fields</h3>
  <div class="row">
      <div class="col-md-3">
        <h4>Date*</h4>
        <input type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" id="day" name="day" required>
      </div>
      <div class="col-md-3">
        <h4>Vendor Name*</h4><!-- onchange="lock()" -->
        <input list="group" id="cName" name="cName" class="form-control" placeholder="Choose Customer" onchange="invoice(this.value);" autocomplete="off" required>
          <datalist id="group">
            <?php
              mysqli_set_charset($con,'utf8');
              $sql="SELECT * FROM accounts WHERE type!='Customer' AND active!='0' ORDER BY name";
              $result=mysqli_query($con,$sql);
               while($fetch=mysqli_fetch_array($result))
                {
                ?> 
            <option value="<?php echo $fetch['name'];?>"><?php echo $fetch['name'];?> </option>
             <?php } ?>
          </datalist><br>
      </div>
      <div class="col-md-3">
        <h4>Remarks</h4>
        <input type="text" placeholder="(Optional)" class="form-control" id="remarks" name="remarks">
      </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <h4>Sale No*</h4>
      <select name="saleNo" id="saleNo" class="form-control" required></select>
    </div>
    <div class="col-md-4">
      <h4>.</h4>
      <div class="btn btn-success" onclick="insert()">Add Item</div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <table class="table lower">
        <thead>
          <th>Sr#</th>
          <th>Item Id</th>
          <th>Name</th>
          <th>Sale Price</th>
          <th>Return Qty</th>
          <th>Amount</th>
          <th>Total</th>
        </thead>
        <tfoot>
          <th>Sr#</th>
          <th>Item Id</th>
          <th>Name</th>
          <th>Sale Price</th>
          <th>Return Qty</th>
          <th>Amount</th>
          <th>Total</th>
        </tfoot>
        <tbody id="item-details"></tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <label>Gross V.</label>
      <input type="text" name="gross" id="gross" class="form-control gross" readonly required>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <label>Amount Paid</label>
      <input type="number" id="amntpaid" name="amntpaid" class="form-control amntpaid" autocomplete="off" onkeyup="amntPaid(this.value)" required>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <label>Remaining</label>
      <input type="number" id="remaining" name="remaining" class="form-control" id="remain" readonly required>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3"><br>
      <button class="btn btn-primary" onclick="save()">Save</button>
    </div>
  </div>
  </form>
</div>

<?php include('../footer.php'); include('../subscription.php');?>
<script type="text/javascript">
  function invoice(customerName){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        //alert(this.responseText);
        $('#saleNo').html(this.responseText);
      }
    };
    xhttp.open("GET", "returnAjax.php?from=invoicep"+"&customer="+customerName,true);
    xhttp.send();
  }
  function insert(){
    saleNo = $('#saleNo').val();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        //alert(this.responseText);
        $('#item-details').html(this.responseText);
        $('#amntpaid').focus();
        total();
      }
    };
    xhttp.open("GET", "queue.php?from=RP&saleNo="+saleNo,true);
    xhttp.send();
  }
  $('body').delegate('.qty,.amnt','keyup',function(){  
    var tr=$(this).parent().parent();  
    var qty=tr.find('.qty').val();  
    var price=tr.find('.amnt').val();  
    var amt =(qty * price);  
    tr.find('.totalAmnt').val(amt);
    total();
  });
  function total(){  
    var t=0;
    $('.totalAmnt').each(function(i,e){
      var amt = $(this).val()-0;  
      t+=amt;  
    });
    $('#gross').val(t);
    $('#remaining').val(t);  
  }
  function amntPaid(str){
    gross = $('#gross').val();
    $('#remaining').val(gross-str);
  }
  function save() {
    var day = $('#day').val();
    var cName = $('#cName').val();
    var saleNo = $('#saleNo').val();
    var gross = $('#gross').val();
    var amntpaid = $('#amntpaid').val();

    if (day=='') {
      alert("Please Select Date");
    }
    else if(cName==''){
      alert("Please Choose Customer");
    }
    else if(saleNo==''){
      alert("Please Select Invoice");
    }
    else if(gross==''){
      alert("Please Add Products");
    }
    else if(amntpaid==''){
      alert("Please Enter Amount Paid");
    }
    else {
      $.ajax({
        url: "returnAjax.php?&from=savep",
        type: 'GET',
        data: $('#lockForm').serialize(),
        dataType: "text",
        async: false,
        success: function (info) {
          //alert(info);
          window.open('returnPPrint.php?pur_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
          location.reload();
          },
          cache: false,
           contentType: false,
          processData: false
      });
    }
  }
</script>