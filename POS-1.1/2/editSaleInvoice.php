<title>Edit Sale Invoice</title>
<?php
include('../session.php');
include('../connect.php');
include('../header.php');
include("../converter.php");

$orderno = $_REQUEST['id'];
$result = mysqli_query($con,"SELECT * FROM scounter WHERE id='$orderno'");
$fetch = mysqli_fetch_array($result); 
?>
<div class="container-fluid">
  <h2>Edit Sale Invoice</h2>
  <h5>Here you can update invoices</h5><hr>
  <form method="POST" id="lockForms">
  <div class="row">
    <div class="col-md-2">
      <label>Entry Date</label>
      <input type="hidden" name="orderno" value="<?php echo $orderno ?>">
      <input type="date" value="<?php echo date('Y-m-d'); ?>" name="sale_day" class="form-control" required>
    </div>
    <div class="col-md-2">
      <label>Bilty No</label>
      <input type="text" name="bilty_No" id="bilty_No" class="form-control" placeholder="Bilty" value="<?php echo $fetch['bilty_No']; ?>">
    </div>
    <div class="col-md-2">
      <label>Reference</label>
      <input type="text" name="reference" id="reference" class="form-control" placeholder="Reference" value="<?php echo $fetch['referal']; ?>">
    </div>
    <div class="col-md-2">
      <label>A/C Title</label> 
      <select id="customer" name="customer" class="form-control" autofocus required>
        <?php
        $result2=mysqli_query($con,"SELECT * FROM accounts WHERE active !='0' && type!='Vendor' ORDER BY name");
        while($fetch2=mysqli_fetch_array($result2)){
          if ($fetch['customer']==$fetch2['id']) {
             echo '<option value="'.$fetch2['id'].'" selected>'.$fetch2['name'].'</option>';
          } 
          else {
            echo '<option value="'.$fetch2['id'].'">'.$fetch2['name'].'</option>';
          }
          
        } ?>
      </select>
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>                 
            <th>Name</th>
            <th>Qty</th>                    
            <th>Price</th>
            <th>Total</th>             
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="item-details">
          <?php
            $result3 = mysqli_query($con,"SELECT * FROM sale WHERE sale_No ='$orderno'");
            while($fetch3=mysqli_fetch_array($result3)){  
              $gross = $fetch3['grossId'];
              $discount = $fetch3['discount'];
              $received = $fetch3['received'];
              $remaining= $fetch3['remaining'];     
          ?>
          <tr>
            <td><select class="form-control product" name="product[]" id="product" readonly>
            <?php
            $result4=mysqli_query($con,"SELECT * FROM products WHERE active='1' ORDER BY name");
            while($fetch4=mysqli_fetch_array($result4)){
              if ($fetch3['barcode']==$fetch4['id']) {
                echo '<option value="'.$fetch4['id'].'" selected>'.$fetch4['name'].'</option>';
              }
              else {
                echo '<option value="'.$fetch4['id'].'">'.$fetch4['name'].'</option>';
              }
            } ?>
          </select></td> 
            <td><input type="text" class="form-control qty" name="qty[]" id="qty" placeholder="Qty" value='<?= $fetch3['qty']; ?>' autocomplete="off"></td>
            <td><input type="text" class="form-control price" name="price[]" id="price" placeholder="Price" value='<?= $fetch3['price']; ?>' autocomplete="off"><input type="hidden" class="form-control pprice" name="pprice[]" id="pprice" placeholder="PPrice" value='<?= $fetch3['purchase_Price']; ?>' readonly></td>
            <td><input type="text" class="form-control total" name="total[]" id="total" placeholder="Total" value='<?= $fetch3['finalValue']; ?>' autocomplete="off" readonly></td>
            <td><a href="#" onclick="remove()" class="btn btn-danger remove">Delete</a></td>         
          </tr>
          <?php } ?>
        </tbody>
      </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2">
        <label>Gross</label>
        <input type="text" name="gross" id="gross" class="form-control"  value="<?= $gross;?>" readonly required>
      </div>
      <div class="col-md-2">
        <label>Inv. Disc</label>
        <input type="number" id="InvDiscount" name="InvDiscount" class="form-control" value="<?= $discount;?>" onkeyup="discount()" required>
      </div>
      <div class="col-md-2">
        <label>Final Value</label>
        <input type="number" id="grandTotal" name="grandTotal" readonly class="form-control" value="<?= $gross;?>" required>
      </div>
      <div class="col-md-2">
        <label>Amount Received</label>
        <input type="number" id="received" name="received" class="form-control" value="<?= $received;?>" onkeyup="receivedAmnt()" required>
      </div>
      <div class="col-md-2">
        <label>Remaining</label>
        <input type="number" name="remaining" id="remaining" class="form-control" value="<?= $remaining;?>" readonly required>
      </div>
      <div class="col-md-2"><br>
        <input type="button" id="save" class="btn btn-primary" value="Update" style="margin-top:4px"/>
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
    var qty = $("#qty1").val();
    if(!$("#lockForms")[0].checkValidity()){
      $("#lockForms").find("#submit-hidden").click();
    }
    else if(qty==""){
      alert("Please Select Product");
    }
    else {
      var formData = new FormData($("#lockForms")[0]);
      $.ajax({
          url: "operation.php?from=saleInvoice&operation=update",
          type: 'POST',
          data: formData,
          async: false,
          success: function (info) {
            alert(info);
            // window.open('salePrint.php?sale_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
            // location.reload();
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
      '<td><select class="form-control product" name="product[]" required onchange="getProductInfo(this.value,'+n+')"><option value="0" disabled selected>--- Select ---</option>'+
      '<?php 
          $sql="SELECT * FROM products WHERE active='1' ORDER BY name";
          $result=mysqli_query($con,$sql);
          while($fetch=mysqli_fetch_array($result)){
          echo "<option value=".$fetch["id"].">".$fetch["name"]."</option>"; } ?>'+
      '</select></td>'+ 
      '<td><input type="text" class="form-control qty" name="qty[]" id="qty'+n+'" placeholder="Qty" autocomplete="off"></td>'+
      '<td><input type="text" class="form-control price" name="price[]" id="price'+n+'" placeholder="Price" autocomplete="off"><input type="hidden" class="form-control pprice" name="pprice[]" id="pprice'+n+'" placeholder="PPrice" readonly></td>'+  
      '<td><input type="text" class="form-control total" name="total[]" id="total'+n+'" placeholder="Total" autocomplete="off" readonly></td>'+
      '<td><a href="#" onclick="remove('+n+')" class="btn btn-danger remove">Delete</a></td>'+
      '</tr>';
      $("#item-details").append(newRow);
  }
  append();

  function total() {
    var z = 0;
    $("#item-details tr").each(function() {
      var x = $(this).find('.total').val();
      z = Number(z)+Number(x);
    });   
    $("#gross").val(z);
    $("#grandTotal").val(z);
    $("#remaining").val(z);
  }

  $('body').delegate('.remove','click',function()  {
    $(this).parent().parent().remove();
    total();
    $("#gross").focus();
    n--;
  });

  $('body').delegate('.qty,.price','keyup',function() {  
    var tr = $(this).parent().parent();  
    var qty = tr.find('.qty').val();  
    var price = tr.find('.price').val(); 
    var amt = qty*price; 
    tr.find('.total').val(amt); 
    total(); 
  });

  function getProductInfo(id,num) {
    $.ajax({
        url: "operation.php?from=saleInvoice&operation=show&id="+id,
        type: 'GET',
        async: false,
        success: function (info) {
          // alert(info);
          var data = info.split("|");
          $("#price"+num).val(data[0]);
          $("#total"+num).val(data[1]);
          $("#pprice"+num).val(data[2]);
          total();
          append();
        },
        cache: false,
        contentType: false,
        processData: false
    });
  }

  function discount(){
    var invDisc = $("#InvDiscount").val();
    var gross = $("#gross").val();
    var final = Number(gross)-Number(invDisc);
    $("#grandTotal").val(final);
  }

  function receivedAmnt(){
    var received = $("#received").val();
    var grandTotal = $("#grandTotal").val();
    var remain = Number(grandTotal)-Number(received);
    $("#remaining").val(remain);
  }
</script>