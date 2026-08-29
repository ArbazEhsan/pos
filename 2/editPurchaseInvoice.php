
<title>Edit Purchase Invoice</title>
<?php 
include('../session.php');
include("../header.php");
include("../connect.php");
include("../converter.php");
$orderno =  $_REQUEST['id'];
$sql7 = "SELECT * FROM pcounter WHERE id='$orderno'";
$result7 = mysqli_query($con,$sql7);
$fetch7 = mysqli_fetch_array($result7);
 ?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="../menu.php"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body>
</nav><center><h1>Purchase Invoice</h1></center><hr>
  <div class="container">
    <div class="row">
      <form method="POST" id="lockForm">
        <input type="hidden" name="orderno" value="<?php echo $orderno ?>" >
        <div class="col-md-3">
            <h4>Entry Date</h4><input type="date"  value="<?php echo $fetch7['sale_day']; ?>" name="sale_day" class="form-control">
          </div>
          <div class="col-md-3">
                <h4>Vendor Bill No</h4><input type="" value="<?php echo $fetch7['bill_No']; ?>" id="bill_No" name="bill_No" class="form-control">
            </div>
          <div class="col-md-3">
                <h4>Bilty No</h4><input type="" id="bilty_id" value="<?php echo $fetch7['bilty_No']; ?>" name="bilty_No" class="form-control">
            </div>
            <div class="col-md-3">
            <h4>Bill Date</h4><input type="date" value="<?php echo $fetch7['bill_date']; ?>"  name="bill_date" class="form-control">
          </div>
            <div class="col-md-3">
                <h4>Transport By</h4>
                <input type="text" name="transport" value="<?php echo $fetch7['transport_By']; ?>" class="form-control">
            </div>
            <div class="col-md-3">
            <h4>Vendor Name</h4><!-- onchange="lock()" -->
            <input list="group" name="customer"  id="vendorId" value="<?php echo getCustomerName($fetch7['customer']); ?>" name="vendor" class="form-control">
                     <datalist id="group">
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu" role="menu">
                                   <?php
                                    $sql="SELECT * FROM accounts WHERE type='vender'";
                                    $result=mysqli_query($con,$sql);
                                     while($fetch=mysqli_fetch_array($result))
                                      {
                                      ?> 
                                   <option value="<?php echo $fetch['name'];?>"><?php echo $fetch['name'];?> </option>
                                   <?php } ?>
                                </ul>
                                </datalist><br>
          </div>
    </div>
    <br>
    <div class="row">
          <div class="col-md-3" id="1">
                <!-- Trigger the modal with a button -->
    <button  type="button" autofocus id="modl" class="form-control" data-toggle="modal" data-target="#myModal">Click To Open Search Form</button>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 70%;">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Search Form</h4>
                </div>
                <div class="modal-body">
                  <?php
                    $counter = 0;
                    mysqli_set_charset($con,'utf8');
                    $sql6 = "SELECT * FROM products ";
                    $result6=mysqli_query($con,$sql6);        
                  ?>                
                     <table id="tablecustom" class="display table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Name</th>                        
                        <th>Pur Price</th>
                        <th>W.S Price</th>
                        <th>Retail</th>
                        <th>List</th>
                      </tr>
                    </thead>                
                    <tbody>
                     <tr>
                         <?php while($fetch6 = mysqli_fetch_array($result6))
                            {
                           ?>
                       
                        <td><?php echo $fetch6['name']; ?></td>
                        <td><?php echo $fetch6['p_price']; ?></td>
                        <td><?php echo $fetch6['w_price']; ?></td>
                        <td><?php echo $fetch6['r_price']; ?></td>
                        <td><div class="btn btn-primary" data-dismiss="modal" id="<?php echo $fetch6['id'] ?>" onclick="load1(this.id)">Add</div></td>         
                      </tr>
              <?php } ?>
                    </tbody>
    </table>
                </div>
                <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
        </div><!-- Modal column end -->
  </div><!-- modal row end -->
  <div class="row">
    <!-- 1st column end -->
      <input type="hidden" tabindex="1" id="barcode" onchange="load1(this.value)" class="form-control">
    
    <div class="col-md-4">
      <h4>Product Name</h4>
      <?php mysqli_set_charset($con,'utf8'); ?>
      <input type="" list="product" onkeyup="focus3()" class="form-control" id="extraId" onchange="loadName(this.value)" >

      <datalist id="product" >
        <?php
          $result7=mysqli_query($con,"SELECT * FROM products");
          while($fetch7=mysqli_fetch_array($result7))
          { ?>
               <option></option>
            <option value="<?php echo $fetch7['name']; ?>"><?php echo $fetch7['name']; ?></option>

          <?php }

        ?>
        
      </datalist>
    </div>
    <div class="col-md-4">
      <h4>Quantity</h4>
      <input type="" class="form-control" id="qtyId" onkeyup="getFinalPrice()">
    </div>
    <div class="col-md-4">
      <h4>Purchase Price</h4>
      <input type="" tabindex="1" name="p_price" readonly  id="p_price" onkeyup="getFinalPrice()"  class="form-control">
    </div><!-- 1st column end -->
    <div class="col-md-4">
      <h4>Whole Sale Price</h4>
      <input type=""  id="w_price" readonly name="w_price" tabindex="1"  class="form-control">
    </div>

    <div class="col-md-4">
      <h4>Retail Price</h4>
      <input type=""  id="r_price" readonly name="r_price" tabindex="1"  class="form-control">
    </div>
     <div class="col-md-4">
      <h4>Final Amount</h4>
      <input type="text" onblur="insert()" readonly id="finalId" class="form-control">
    </div>
  </div>

  
  </div> <!-- info fields div end -->
  <div class="row">

  </div><!-- 1st container div end -->
<center><h3>Inserted Items Detai</h3></center><hr>
<div class="container-fluid">
    <div class="col-md-12 table-responsive" id="loadDiv">
    <?php
                $sql3 = "SELECT * FROM sale WHERE sale_No = '$sale_No' ";           
                $result3=mysqli_query($con,$sql3);
                ?>
                <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Serial #</th>                  
                    <th>Name</th>
                    <th>Qty</th>                    
                    <th>Purchase Price</th>
                    <th>Whole_Price</th>
                    <th>Retail_Price</th>
                    <th>Final Amount</th>             
                    <th>Operation</th>
                  </tr>
                </thead>
                <tfoot>                  
                  <tr>
                    <th>Serial #</th>                  
                    <th>Name</th>
                    <th>Qty</th>                    
                    <th>Purchase Price</th>
                    <th>Whole_Price</th>
                    <th>Retail_Price</th>
                    <th>Final Amount</th>             
                    <th>Operation</th>
                  </tr>                  
                </tfoot>
                <tbody id="item-details"> 
                <?php 
                    $result3=mysqli_query($con,"SELECT * FROM psale WHERE sale_No ='$orderno'");
                    $counter=0;
                   while ($fetch3=mysqli_fetch_array($result3)) 
                   {
                    $gross = $fetch3['grossId'];
                       $discount = $fetch3['discount'];
                       $received = $fetch3['received'];
                       $remaining= $fetch3['remaining'];
                       $counter++;
                       $sql4 = "SELECT * FROM products WHERE id = '".$fetch3['barcode']."'";
                       $result4 = mysqli_query($con,$sql4);
                       $fetch4=mysqli_fetch_array($result4);
                    ?>
                    <tr>
                      <td class="no"><?= $counter; ?></td>
                      <input style="width:200px;" readonly type="hidden" class="form-control productcode" value="<?= $fetch3['barcode']; ?>">
                      <td><input style="width:320px;" readonly type="text" class="form-control productname"  value="<?= $fetch4['name']; ?>"></td>
                      <td><input style="width:150px;" type="text" class="form-control quantity" id="qty" value='<?= $fetch3['qty']; ?>'></td>  
                      <td><input style="width:150px;" type="text" class="form-control p_price" id="p_price" value='<?= $fetch3['price']; ?>'></td>
                       <td><input style="width:150px;" type="text" class="form-control w_price" id="w_price" value='<?= $fetch3['w_price']; ?>'></td>
                        <td><input style="width:150px;" type="text" class="form-control r_price" id="r_price" value='<?= $fetch3['r_price']; ?>'></td>    
                      <td><input type="text" readonly class="form-control amount" value='<?= $fetch3['finalValue']; ?>'></td>  
                      <td><a href="#" onclick="remove()" class="btn btn-danger remove">Delete</td>  
                    </tr>
                <?php } ?>                
                </tbody>
</table>
  </div>
  <div class="row">
    <div class="col-md-2">
      <label>Gross.V</label>
      <input type="text" name="grossId" value="<?= $gross;?>" id="grossId" readonly class="form-control">
    </div><!-- column 1st end -->
      
    <div class="col-md-2">
      <label>Inv. Disc</label>
      <input type="text" id="discount1" value="<?= $discount;?>" name="discount1" onkeyup="load2()" name="invDiscount" class="form-control">
    </div><!-- column 2nd end -->
 

    <div class="col-md-2">
      <label>Final Value</label>
      <input type="text" id="finalValue" name="finalValue" value="<?= $gross-$discount;?>" name="final" readonly class="form-control" >
    </div>
    <div class="col-md-2">
      <label>Amount Received</label>
      <input type="text" id="received" name="received" onkeyup="load3()" name="amntpaid" class="form-control" value="<?= $received;?>" onkeyup="ledger(this.value)">
    </div>
  <div class="col-md-2">
      <label>Remaining</label>
      <input type="text" value="<?= $remaining;?>" id="reamaining" name="remaining" class="form-control" readonly="">
    </div>
     <div class="col-md-2"><br>
         <button onclick="save()" class="btn btn-primary">Save</button>
        
      </div>
  </div>
  <div class="row">
    
    <div class="col-md-2">
     
      </div>
      
   <!-- <form id="print1" action="print.php">  -->
      <div class="col-md-2 pull-right">
        <!-- <button class="btn btn-primary" name="btn">Print Simple Invoice</button> -->
      </div>
  </div><!-- button row end -->  
</form>
</div><!-- container-fluid div end -->
<?php include("../footer.php");?>

<script type="text/javascript">
$(document).ready(function() {
    $('table.display').DataTable( {

        dom: 'Blfrtip' ,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] ,
        buttons: [
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ],
        columnDefs: [ {
            targets: -1,
            visible: true
        } ]
    } );
} );
</script>
<script type="text/javascript">
function load1(str) {

  document.getElementById('extraId').value=str;
  document.getElementById('barcode').value=str;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

      // alert(this.responseText);
      var display=this.responseText;
      display=display.split("/");
      document.getElementById("extraId").value       =display[0];
       document.getElementById("p_price").value       =display[1];
        document.getElementById("w_price").value       =display[2];
      document.getElementById("r_price").value    =display[3];
      document.getElementById("qtyId").focus();

      document.getElementById("modl").focus();
 
      
    
    }
  };
  xhttp.open("GET", "ajax.php?barcode="+str+"&from=1", true);
  xhttp.send();
  
}

function loadName(str) {
  // document.getElementById('extraId').value=str;
  // alert(str);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

      //alert(this.responseText);
     load1(this.responseText);
    }
  };
  xhttp.open("GET", "ajax.php?product="+str+"&from=2", true);
  xhttp.send();
  
}

function load2()
{ var g =document.getElementById("grossId").value;
   var i =document.getElementById("discount1").value;
   var result = Number(g)-Number(i);
   document.getElementById("finalValue").value=result;


}

function load3()
{ var f =document.getElementById("finalValue").value;
   var r =document.getElementById("received").value;
   var result = Number(f)-Number(r);
   document.getElementById("reamaining").value=result;


}

function focus3()
{

  document.getElementById("qtyId").focus();
}
</script>

<script type="text/javascript">
  function finalV()
    {
      purchase = document.getElementById('purchaseId').value;
      discount = document.getElementById('discId').value;
      qty = document.getElementById('qtyId').value;
      amnt = Number(purchase) * Number(qty);
      document.getElementById('finalId').value = Number(amnt) - Number(discount);
    }
</script>
<script type="text/javascript">
    function getFinalPrice()
    {
      qty = document.getElementById('qtyId').value;
      purchase = document.getElementById('p_price').value;
      amnt = Number(purchase) * Number(qty);
      document.getElementById('finalId').value = amnt;
    }
</script>


<script type="text/javascript">
  $("#myDialog").dialog({
    open: function() {
      $(this).parents('.ui-dialog-buttonpane button:eq(0)').focus(); 
    }
  });
</script>


<script type="text/javascript">
  $('body').delegate('.remove','click',function()  
{  
$(this).parent().parent().remove();
n--;
total();
});
$('body').delegate('.quantity,.p_price,.discount','keyup',function()  
{  
var tr=$(this).parent().parent();  
var qty=tr.find('.quantity').val();  
var price=tr.find('.p_price').val();  
var amt =(qty * price);  
tr.find('.amount').val(amt);  
total();  
});
function total()  
{  
var t=0;  
$('.amount').each(function(i,e)   
{
var amt =$(this).val()-0;  
t+=amt;  
});
$('#grossId').val(t);  
}
var code = new Array();
var qtyArray = new Array();
var priceArray = new Array();
var n = 0;
function insert(){
  barcode = $("#barcode").val();
  qty     = $("#qtyId").val();
  price   = $("#purchaseId").val();
  var a   = code.includes(barcode);
  if(a == true)
  {
     alert('Product Already Exist in invoice ');
  }
  else
  {
    code.push(barcode);
    qtyArray.push(qty);
    priceArray.push(price);
    var n=($('#item-details tr').length-0)+1;        
         var formData = new FormData($("#insertForm")[0]);
         var newRow="";
                         newRow= '<tr>'+  
      '<td class="no">'+ n +'</td>'+   
      '<input style="width:200px;" type="hidden" readonly type="text" class="form-control productcode" id="barcode'+n+'"  name="barcode['+n+']" value="'+$("#barcode").val()+'">'+  
      '<td><input style="width:320px;" readonly type="text" class="form-control productname" name="productname[]" value="'+$("#extraId").val()+'"></td>'+
      '<td><input style="width:150px;" type="text" class="form-control quantity" id="qty" value='+$("#qtyId").val()+'></td>'+  
      '<td><input style="width:150px;" type="text" class="form-control p_price" id="price" value='+$("#p_price").val()+'></td>'+
      '<td><input style="width:150px;" type="text" class="form-control w_price" id="price" value='+$("#w_price").val()+'></td>'+
      '<td><input style="width:150px;" type="text" class="form-control r_price" id="price" value='+$("#r_price").val()+'></td>'+     
      '<td><input type="text" class="form-control amount" value='+$("#finalId").val()+' name="final[]"></td>'+  
      '<td><a href="#" onclick="remove('+n+')" class="btn btn-danger remove">Delete</td>'+  
      '</tr>';
      $("#item-details").append(newRow);
      total();
  }
      
                    
          
          document.getElementById('extraId').value=''; 
          document.getElementById('qtyId').value=''; 
          document.getElementById('purchaseId').value='';
          document.getElementById('finalId').value='';
          document.getElementById('modal').focus();
    }
    function remove(str)
    {
      barcode = $("#barcode"+str).val();
      index = code.indexOf(barcode);
      code.splice(index,1);
      qtyArray.splice(index,1);
      priceArray.splice(index,1);
    }
    function gross()
    {
      var xhttp = new XMLHttpRequest();
       xhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
             // alert(this.responseText);
           document.getElementById('grossId').value = this.responseText;
         }
       };
       xhttp.open("GET", "grossAjax.php?type=gross", true);
       xhttp.send();
    }
    var code2 = new Array();
    var qtyArray2 = new Array();
    var priceArray2 = new Array();
    var wholeprice2 = new Array();
    var retailprice2 = new Array();
    function update()
    {
          $("#item-details tr").each(function() {
          var c = $(this).find('.productcode').val();
          var q = $(this).find('.quantity').val();
          var p = $(this).find('.p_price').val();
          var w = $(this).find('.w_price').val();
          var r = $(this).find('.r_price').val();
          code2.push(c);
          qtyArray2.push(q);
          priceArray2.push(p);
          wholeprice2.push(w);
          retailprice2.push(r);
        });
    }
    function save()
     {
      update();
      var barcode   = JSON.stringify(code2);
      var qty       = JSON.stringify(qtyArray2);
      var price3     = JSON.stringify(priceArray2);
      var w_price3   = JSON.stringify(wholeprice2);
      var r_price3   = JSON.stringify(retailprice2);
       var formData = new FormData($("#lockForm")[0]);
            $.ajax({
                url: "updatePurchase.php?barcode="+barcode+"&qty="+qty+"&p_price3="+price3+"&w_price3="+w_price3+"&r_price3="+r_price3,
                type: 'POST',
                data: formData,
          dataType: "text",
                async: false,
                success: function (info) {
          //alert(info);
          
            window.open('purchaseInvPrint.php?sale_No='+info+"&previous="+prevB+"&totalNow="+trecev,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
           $("#editnews").html(info);
                },
                cache: false,
                 contentType: false,
                processData: false
            });

    }
     

</script>