<title>Edit Sale Invoice</title>
<?php include('../session.php'); include("../header.php");include("../connect.php");include("../converter.php"); 
$orderno =  $_REQUEST['id'];
$sql7 = "SELECT * FROM scounter WHERE id='$orderno'";
$result7 = mysqli_query($con,$sql7);
$fetch7 = mysqli_fetch_array($result7); 
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="viewinvoices.php"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body onload="focus1();">
</nav><center><h1>Edit Sale Invoice</h1></center><hr>
  <div class="container">


    <div class="row">
      <form method="POST" id="lockForm">
        <input type="hidden" class="form-control" name="orderno" value="<?php echo $orderno ?>"  >
        <div class="col-md-2">
            <h4>Entry Date</h4><input type="date" value="<?php echo date('Y-m-d'); ?>" name="sale_day" class="form-control">
          </div>
          <div class="col-md-3">
                <h4>Bilty No</h4><input type="" value="<?php echo $fetch7['bilty_No']; ?>" id="bilty_id" name="bilty_No" class="form-control">
            </div>
            <div class="col-md-3">
                <h4>Reference</h4><input type="" value="<?php echo $fetch7['referal']; ?>" name="referal" class="form-control" id="r_id">
                <input type="hidden" value="<?php echo $orderno; ?>" name="orderno" class="form-control" id="orderno">
            </div>
            <div class="col-md-3">
            <h4>Customer Name</h4><!-- onchange="lock()" -->
            <input list="group"  id="vendorId" name="customer"  class="form-control" autocomplete="none" value="<?php echo getCustomerName($fetch7['customer']); ?>">
                     <datalist id="group">
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu" role="menu">
                                   <?php
                                    $sql="SELECT * FROM accounts WHERE type='customer'";
                                    $result=mysqli_query($con,$sql);
                                     while($fetch=mysqli_fetch_array($result))
                                      {
                                      ?> 
                                   <option><?php echo $fetch['name'];?> </option>
                                   <?php } ?>                                   
                                </ul>
                                </datalist>
          </div>
    </div><!-- 1ST ROW END -->
    <center><h3>Add More Items</h3></center><hr>
    <div class="row">
          <div class="col-md-3">
                <!-- Trigger the modal with a button -->
    <button  type="button" id="modl" class="form-control" data-toggle="modal" data-target="#myModal">Click To Open Search Form</button>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%;">

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
    
    <div class="col-md-3">
      <h4>Product Name</h4>
      <?php mysqli_set_charset($con,'utf8'); ?>
      <input type="" list="product" class="form-control" id="extraId" onchange="loadName(this.value)" >

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

     <div class="col-md-3">
      <h4>Quantity</h4>
      <input type="" class="form-control" id="qtyId" onkeyup="getFinalPrice()">
    </div>
    <div class="col-md-3">
      <h4>Price</h4>
      <input type="" id="purchaseId" class="form-control" onkeyup="getFinalPrice()">
    </div><!-- 3rd column end -->
    <div class="col-md-3">
      <h4>Final Amount</h4>
      <input type="text" onblur="insert()" readonly id="finalId" class="form-control">
    </div>
  </div> <!-- info fields div end -->
  
   
  </div><!-- 1st container div end -->
  <center><h3>Items Detail</h3></center><hr>
<div class="container-fluid">
    <div class="col-md-12 table-responsive" id="loadDiv">
                <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Serial #</th>                   
                    <th>Name</th>
                    <th>Qty</th>                    
                    <th>Price</th>
                    <th>Final Amount</th>             
                    <th>Operation</th>
                  </tr>
                </thead>
                <tbody id="item-details">                 
                   <?php 
                    $result3=mysqli_query($con,"SELECT * FROM sale WHERE sale_No ='$orderno'");
                    $counter=0;
                   while ($fetch3=mysqli_fetch_array($result3)) 
                   {
                       $gross = $fetch3['grossId'];
                       $discount = $fetch3['discount'];
                       $received = $fetch3['received'];
                       $remaining= $fetch3['remaining'];
                       $counter++;                       
                    ?>
                    <tr>
                      <td class="no"><?= $counter; ?></td>
                      <input style="width:200px;" readonly type="hidden" class="form-control productcode" value="<?= $fetch3['barcode']; ?>">
                      <td><input style="width:320px;" readonly type="text" class="form-control productname"  value="<?= getProductName($fetch3['barcode']); ?>"></td>
                      <td><input style="width:320px;" type="text" class="form-control quantity" id="qty" value='<?= $fetch3['qty']; ?>'></td>  
                      <td><input style="width:150px;" type="text" class="form-control price" id="price" value='<?= $fetch3['price']; ?>'></td>    
                      <td><input type="text" readonly class="form-control amount" value='<?= $fetch3['finalValue']; ?>'></td>  
                      <td><a href="#" onclick="remove()" class="btn btn-danger remove">Delete</td>  
                    </tr>
                <?php } ?>
                </tbody>    
                <tfoot>                  
                  <tr>
                    <th>Serial #</th>                                 
                    <th>Name</th>
                    <th>Qty</th>                    
                    <th>Price</th>
                    <th>Final Amount</th>                          
                    <th>Operation</th>
                  </tr>                  
                </tfoot>
            </table>
  </div>
  <?php 
 // $result5 = mysqli_query($con,"SELECT * FROM sale WHERE sale_No='$orderno'");

   ?>
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
      <input type="text" id="finalValue" name="finalValue" value="<?= $gross-$discount;?>" name="final" value="<?= $gross;?>" readonly class="form-control" >
    </div>
    <div class="col-md-2">
      <label>Amount Received</label>
      <input type="text" id="received" value="<?= $received;?>" name="received" onkeyup="load3()" name="amntpaid" class="form-control" onkeyup="ledger(this.value)">
    </div>
  <div class="col-md-2">
      <label>Remaining</label>
      <input type="text" name="remaining" id="reamaining" value="<?= $remaining;?>" name="remaining" class="form-control" readonly="">
    </div>
     <div class="col-md-2"><br>
         <button onclick="save()" class="btn btn-primary">Save</button>
        
      </div>
  </div>
   
</form>
</div><!-- container-fluid div end -->
<?php include("../footer.php");?>
<script type="text/javascript">
  function fresh() {
    // $('#loadDiv').load(document.URL +  ' #loadDiv ');
    window.location.reload();
  }
  function load(str)
  {
    var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //alert(this.responseText);
     document.getElementById('lppId').value = this.responseText;

    }
  };
  xhttp.open("GET", "lppAjax.php?id="+str, true);
  xhttp.send();
  }
  function loadW(str)
  {
    var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //alert(this.responseText);
     document.getElementById('wholeId').value = this.responseText;

    }
  };
  xhttp.open("GET", "wholeAjax.php?id="+str, true);
  xhttp.send();
  }
  function loadR(str)
  {
    var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //alert(this.responseText);
     document.getElementById('retailId').value = this.responseText;
    }
  };
  xhttp.open("GET", "retailAjax.php?id="+str, true);
  xhttp.send();
  }
  function loadS(str)
  {
    var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //alert(this.responseText);
     document.getElementById('lspId').value = this.responseText;

    }
  };
  xhttp.open("GET", "saleAjax.php?id="+str, true);
  xhttp.send();
  }

</script>

<script type="text/javascript">
  function load2(str)
  {
    var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // alert(this.responseText);
     document.getElementById('stock').value = this.responseText;
    }
  };
  xhttp.open("GET", "stockAjax.php?id="+str, true);
  xhttp.send();
  }
</script>
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
  function test(str)
  {
    retail = document.getElementById('retailId').value;
    whole  = document.getElementById('wholeId').value;    
   var result = $('#chId').is(':checked');

   if(result == true)
   {
    //alert(result);
    //alert(whole);
    document.getElementById('purchaseId').value = whole;
   }
   else
   {
    
    //alert(retail);
    document.getElementById('purchaseId').value = retail;
   }
  }
   function cal(str)
  {
    discount = document.getElementById('discount1').value;
    /*profit= document.getElementById('invprofit').value;*/
     gross = document.getElementById('grossId').value;
    if (discount==0) {
       document.getElementById('invprofit').value= gross;
    }    
    else{
       document.getElementById('invprofit').value= Number(gross)-Number(discount);
    }
   
   
  }
</script>
<script type="text/javascript">
function load1(str) {
  document.getElementById('barcode').value=str;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //alert(this.responseText);
     document.getElementById('extraId').value = this.responseText;
     document.getElementById('qtyId').focus();
     load(this.responseText);
     load2();
     loadW();
     loadR();
     loadS();
     setTimeout(test, 600);
    }
  };
  xhttp.open("GET", "queue.php?barcode="+str, true);
  xhttp.send();
}
</script>

<script type="text/javascript">
 function invoice(str)
 {
  var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 200) {
       //alert(this.responseText);
       document.getElementById('pur_id').value = this.responseText;
       //window.location.reload();
     }
   };
   xhttp.open("GET", "invoiceAjax.php?person="+str , true);
   xhttp.send();
   focus1();
 }
</script>
<script type="text/javascript">
  function end(str)
  {
    paid = document.getElementById('paidId').value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 200) {
       // alert(this.responseText);
       document.getElementById('pur_id').value = this.responseText;
       document.getElementById('packingId').value = '';
       document.getElementById('discount1').value = '';
       document.getElementById('netId1').value = '';
       document.getElementById('finalId1').value = '';
       document.getElementById('bilty_id').value = '';
       document.getElementById('vendorId').value = '';
       document.getElementById('grossId').value = '';
       document.getElementById('r_id').value = '';
       window.location.href = "saleInvoice.php?sale_No=0";
     }
   };
   xhttp.open("GET", "endInvoiceAjax.php?person="+str+"&paid="+paid, true);
   xhttp.send();
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
    function without()
    {
      qty = document.getElementById('qtyId').value;
      purchase = document.getElementById('purchaseId').value;
      amnt = Number(purchase) * Number(qty);
      document.getElementById('finalId').value = amnt;
    }
</script>
<script type="text/javascript">
    $('#grossId, #packingId, #discount1').on('input', function() {
    var gross = parseInt($('#grossId').val());
    var packing = parseFloat($('#packingId').val());
    var previous = parseFloat($('#prevB').val());
    $('#netId1').val((gross + packing).toFixed(2));
    $('#trecev').val((gross+packing+previous).toFixed(2));
    var netId1  = parseFloat($('#netId1').val());
    var dis1  = parseFloat($('#discount1').val());
    $('#finalId1').val((netId1-dis1).toFixed(2));
  });
</script>

<script type="text/javascript">
  $("#myDialog").dialog({
    open: function() {
      $(this).parents('.ui-dialog-buttonpane button:eq(0)').focus(); 
    }
  });
</script>
<script type="text/javascript"> 
  function qtyC(str)
  {
    for(i=1;i<=<?php echo $counter; ?>; i++)
    {
      purchase = document.getElementById('purchase'+i).value;  
      qty = document.getElementById('qty'+i).value;  
      document.getElementById('awod'+i).value = purchase * qty;
    }
    gorss();
    
  }
  function qtyFunc(str)
  {
     //alert(<?php echo $counter ?>);
    for(i=1;i<=<?php echo $counter; ?>; i++)
    {
      purchase = document.getElementById('purchase'+i).value;  
      qty = document.getElementById('qty'+i).value;  
      document.getElementById('awod'+i).value = purchase * qty;
    }
    gross();
  }
</script>
<script type="text/javascript">
  function focus1()
  {
    document.getElementById('modl').focus();
  }
</script>
<script type="text/javascript">
  function go()
  {
    document.getElementById('discount1').focus();
  }
</script>
<script type="text/javascript">
  $('body').delegate('.remove','click',function()  
{
$(this).parent().parent().remove();
n--;
total();
}); 
$('body').delegate('.quantity,.price,.discount','keyup',function()  
{  
var tr=$(this).parent().parent();  
var qty=tr.find('.quantity').val();  
var price=tr.find('.price').val();  
var amt =(qty * price);  
tr.find('.amount').val(amt);  
total();  
});
function total()  
{  
  var t=0;  
  $('.amount').each(function(i,e)   
  {
  var amt = $(this).val()-0;  
  t+=amt;  
  });
  $('#grossId').val(t);  
}
var code = new Array();
var qtyArray = new Array();
var priceArray = new Array();
var n = 0;
var lpp = 0;
function insert(){

  barcode = $("#barcode").val();
  qty = $("#qtyId").val();
  price = $("#purchaseId").val();
  var a = code.includes(barcode);
  if(a == true)
  {
    alert('Product Already Exist in Invoice');
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
      '<td><input style="width:320px;" type="text" class="form-control quantity" id="qty" value='+$("#qtyId").val()+'></td>'+  
      '<td><input style="width:150px;" type="text" class="form-control price" id="price" value='+$("#purchaseId").val()+'></td>'+    
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
    function update()
    {
          $("#item-details tr").each(function() {
          var c = $(this).find('.productcode').val();
          var q = $(this).find('.quantity').val();
          var p = $(this).find('.price').val();
          code2.push(c);
          qtyArray2.push(q);
          priceArray2.push(p);
        });
         
    }
     function save()
     {
      update();
      var barcode = JSON.stringify(code2);
      var qty     = JSON.stringify(qtyArray2);
      var price   = JSON.stringify(priceArray2);
       var formData = new FormData($("#lockForm")[0]);
            $.ajax({
                url: "updateInvoice.php?barcode="+barcode+"&qty="+qty+"&price="+price,
                type: 'POST',
                data: formData,
          dataType: "text",
                async: false,
                success: function (info) {
          //alert(info);
          
            //window.open('print.php?sale_No='+info+"&previous="+prevB+"&totalNow="+trecev,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
           // $("#editnews").html(info);
                },
                cache: false,
                 contentType: false,
                processData: false
            });

    }
     
</script>
<script>
window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = 'Sure?';
    }

    // For Safari
    return 'Sure?';
};
function ledger(paid)
{
  final = $('#finalId1').val();
  $('#remainId').val(final-paid);
}


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
      document.getElementById("purchaseId").value    =display[3];
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
</script>
<script type="text/javascript">
    function getFinalPrice()
    {
      qty = document.getElementById('qtyId').value;
      purchase = document.getElementById('purchaseId').value;
      amnt = Number(purchase) * Number(qty);
      document.getElementById('finalId').value = amnt;
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
      document.getElementById("purchaseId").value    =display[3];
 
      
    
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
</script>