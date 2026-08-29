
<title>Sale Invoice</title>
<?php include('../session.php'); include("../header.php");include("../connect.php"); ?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body>
</nav><center><h1>Sale Invoice</h1></center><hr>
  <div class="container">
    <div class="row">
      <form method="POST" id="lockForm">
        <div class="col-md-2">
            <h4>Entry Date</h4><input type="date" value="<?php echo date('Y-m-d'); ?>" name="sale_day" class="form-control">
          </div>
          <div class="col-md-3">
                <h4>Bilty No</h4><input type="" id="bilty_id" name="bilty_No" class="form-control" placeholder="Bilty">
            </div>
            <div class="col-md-3">
                <h4>Reference</h4><input type="" name="referal" class="form-control" id="r_id" placeholder="Ref.">
            </div>
            <div class="col-md-3">
            <h4>Customer Name</h4><!-- onchange="lock()" -->
            <?php
              $sql="SELECT * FROM accounts WHERE active='11'";
              $result=mysqli_query($con,$sql);
              $fetch=mysqli_fetch_array($result);
              ?> 
            <input list="group" autofocus id="customer" name="customer" class="form-control" autocomplete="off" value="<?php echo $fetch['name']; ?>" placeholder="Choose Customer" required>
                     <datalist id="group">
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu" role="menu">
                                   <?php
                                    $sql="SELECT * FROM accounts WHERE active !='0'";
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
    <button  type="button" id="modl" class="form-control" data-toggle="modal" data-target="#myModal" onclick="alertt()">Click To Open Search Form</button>
    <script type="text/javascript">
      function alertt(){
        var cus = $('#vendorId').val();
        if (cus=='') {
          alert("Please Select Customer First");
        }
      }
    </script>
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
                    $sql6 = "SELECT * FROM products WHERE active='1'";
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

<div class="col-md-3" id="2" style="display: none;">
               <select class="form-control" id="comboB" onchange="load3(this)" >
                 <option> Select Services</option>
                 <option value="S1">Designing</option>
                 <option value="S2">Fitting</option>
                 <option value="S3">Healing</option>
               </select>
        </div><!-- Modal column end -->
  </div><!-- modal row end -->
  <div class="row">
    <!-- 1st column end -->
      <input type="hidden" tabindex="1" id="barcode" onchange="load1(this.value)" class="form-control">
    
    <div class="col-md-3">
      <h4>Product Name</h4>
      <?php mysqli_set_charset($con,'utf8'); ?>
      <input type="" autocomplete="off" list="product" class="form-control" id="extraId" onchange="loadName(this.value)" >

      <datalist id="product" >
        <?php
          $result7=mysqli_query($con,"SELECT * FROM products WHERE active='1'");
          while($fetch7=mysqli_fetch_array($result7))
          { ?>
               <option></option>
            <option value="<?php echo $fetch7['name']; ?>"><?php echo $fetch7['name']; ?></option>

          <?php }

        ?>
        
      </datalist>
    </div>
   <!-- <div class="col-md-2">
      <h4>Last Sale Price</h4>
      <input type="" tabindex="1"  id="lspId" readonly class="form-control">
    </div> --> <!-- 1st column end -->
     <div class="col-md-2">
      <h4>Purchase Price</h4>
      <input type="text"  id="lppId" tabindex="1" readonly class="form-control">
    </div><!-- 1st column end -->
    <!--  <div class="col-md-2">
      <h4>Whole sale Price</h4>
      <input type="hidden"  id="wsp" tabindex="1" readonly class="form-control">
    </div> --><!-- 1st column end -->

    <div class="col-md-2">
      <h4>Stock</h4>
      <input readonly type="text" class="form-control" id="shQty" name="shQty" >
    </div>
     <div class="col-md-2">
      <h4>Quantity</h4>
      <input type="" class="form-control" onblur="cal();" id="qtyId" onkeyup="getFinalPrice()">
    </div>
    <div class="col-md-3">
      <h4>Price</h4>
      <input type="" id="purchaseId" class="form-control" onkeyup="getFinalPrice()">
    </div><!-- 3rd column end -->
    <div class="col-md-3">
      <h4>Final Amount</h4>
      <input type="text" onblur="insert()" readonly id="finalId" class="form-control">
      <input type="hidden" id="profit" class="form-control" readonly>
    </div>
    <script type="text/javascript">
      
       function cal(str)
        { 
           var pp44    = $('#lppId').val();
           var price44 = $('#purchaseId').val();
           var qty44   = $('#qtyId').val();
           var f144 = pp44*qty44;
           var f244 = price44*qty44;
           var profit44 = Number(f244)-Number(f144);
           $('#profit').val(profit44);
        }

    </script>
  </div>
  </div> <!-- info fields div end -->
  <div class="row">
   
   <!--  <div class="col-md-2">
      <h4>Whole Sale Price</h4>
      <input type="" readonly id="wholeId" class="form-control" tabindex="1">
    </div> --><!-- 4th column end -->
    <!-- <div class="col-md-2">
      <h4>Retail Price</h4>
      <input type="" readonly id="retailId" class="form-control" tabindex="1">
    </div> --><!-- 5th column end -->
   
    <!-- 2nd column end -->
    <!-- 2nd row of input fields end -->
   <div class="row">
    
  </div><!-- final amount row end -->
  </div><!-- 1st container div end -->
  <br>
<?php       
      $query1   =  "SELECT * FROM sale";
      $run1     =  mysqli_query($con,$query1);
      $fetch1   = mysqli_fetch_array($run1);
      $purchaseAmnt  =  $fetch1['purchaseAmnt'];        
      $discount3 =  $fetch1['discountValue'];      
?>
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
                    <th>Price</th>
                    <th>Final Amount</th>             
                    <th>Operation</th>
                  </tr>
                </thead>
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
                <tbody id="item-details">                 
                </tbody>
</table>
  </div>
  <div class="row">
    <div class="col-md-2">
      <label>Gross.V</label>
      <input type="text" name="grossId" id="grossId" readonly class="form-control">
    </div><!-- column 1st end -->
      
    <div class="col-md-2">
      <label>Inv. Disc</label>
      <input type="text" id="discount1" name="discount1" onkeyup="load2()" name="invDiscount" class="form-control">
    </div><!-- column 2nd end -->
 
    <!-- <div class="col-md-2">
      <label>Inv Profit</label>
      <input type="text" id="invProfit" readonly class="form-control" >
    </div> -->
    <div class="col-md-2">
      <label>Final Value</label>
      <input type="text" id="finalValue" name="finalValue" value="<?php echo $fetch0['finalValue'] ?>" name="final" readonly class="form-control" >
    </div>
    <div class="col-md-2">
      <label>Amount Received</label>
      <input type="text" id="received" name="received" onkeyup="load3()" name="amntpaid" class="form-control" required>
    </div>
  <div class="col-md-2">
      <label>Remaining</label>
      <input type="text" name="remaining" id="reamaining" name="remaining" class="form-control" readonly="">
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
<?php include("../footer.php"); include('../subscription.php');?>

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
      document.getElementById('extraId').focus();
      var display=this.responseText;
      display=display.split("/");
      document.getElementById("extraId").value    = display[0];
      document.getElementById("purchaseId").value = display[3];
      document.getElementById("shQty").value      = display[4];
      document.getElementById("lppId").value      = display[1];
      document.getElementById("wsp").value        = display[2];

     
 
      
    
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
      purchase = document.getElementById('purchaseId').value;
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
$('body').delegate('.quantity,.price,.discount','keyup',function()  
{  
var tr=$(this).parent().parent();  
var qty=tr.find('.quantity').val();  
var price=tr.find('.price').val();
var profit=tr.find('.profit').val();  
var amt  =(qty * price); 
var amt1 =(qty * profit);  
var final_profit = Number(amt)-Number(amt1);
     
     
    

tr.find('.amount').val(amt);  
tr.find('.final_profit').val(final_profit);
total();  
});
function total()  
{  
var t=l=0;  
$('.amount').each(function(i,e)   
{
var amt =$(this).val()-0;  
t+=amt;  
});
$('#grossId').val(t);
$('.pprice').each(function(i,e)   
{
var amt2 =$(this).val()-0;  
l+=amt2;  
});
$('#invProfit').val(l);

}
var code = new Array();
var qtyArray = new Array();
var priceArray = new Array();
var ppriceArray = new Array();
var profitArray = new Array();
var n = 0;
function insert(){
  barcode = $("#barcode").val();
  qty     = $("#qtyId").val();
  price   = $("#purchaseId").val();
  shQty   = $("#shQty").val();
  extra   = $("#extraId").val();
  pp      = $("#lppId").val();
  profit  = $("#profit").val();
  var a   = code.includes(barcode);
  if(a == true)
  {
     alert('Product Already Exist in invoice ');
  }
  else if(shQty=='0' || shQty <'0')
  {  
      
 alert("Warning: " +extra +" is out of stock. Please purchase this product");
 location.reload();
  }
  else
  {
    code.push(barcode);
    qtyArray.push(qty);
    priceArray.push(price);
    ppriceArray.push(pp);
    profitArray.push(profit);
    var n=($('#item-details tr').length-0)+1;        
         var formData = new FormData($("#insertForm")[0]);
         var newRow="";
                         newRow= '<tr>'+  
      '<td class="no">'+ n +'</td>'+   
      '<input style="width:200px;" type="hidden" readonly type="text" class="form-control productcode" id="barcode'+n+'"  name="barcode['+n+']" value="'+$("#barcode").val()+'">'+  
      '<td><input style="width:320px;" readonly type="text" class="form-control productname" name="productname[]" value="'+$("#extraId").val()+'"></td>'+
      '<td><input style="width:80px;" type="text" class="form-control quantity" id="qty" value='+$("#qtyId").val()+'></td>'+  
      '<td><input style="width:150px;" type="text" class="form-control price" id="price" value='+$("#purchaseId").val()+'><input type="hidden"   class="form-control profit" value='+$("#profit").val()+' readonly><input type="hidden" name="pprice[]"  class="form-control pprice" value='+$("#purchaseId").val()+' readonly></td>'+    
      '<td><input type="text" class="form-control amount" value='+$("#finalId").val()+' name="final[]"><input type="hidden" name="profit1[]" class="form-control final_profit" value='+$("#profit").val()+'  readonly></td>'+  
      '<td><a href="#" onclick="remove('+n+')" class="btn btn-danger remove">Delete</td>'+  
      '</tr>';
      $("#item-details").append(newRow);
      document.getElementById('modl').focus();
      total();
      load2();
      load3();
  }
      
                    
          
          document.getElementById('extraId').value=''; 
          document.getElementById('qtyId').value=''; 
          document.getElementById('purchaseId').value='';
          document.getElementById('finalId').value='';
          document.getElementById('modal').focus();
          document.getElementById('lppId').value='';
          document.getElementById('profit').value='';

    }
    function remove(str)
    {
      barcode = $("#barcode"+str).val();
      index = code.indexOf(barcode);
      code.splice(index,1);
      qtyArray.splice(index,1);
      priceArray.splice(index,1);
      ppriceArray.splice(index,1);
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
          var ppriceArray2 = new Array();
          var profitArray2 = new Array();
    function update()
    {
          $("#item-details tr").each(function() {
          var c = $(this).find('.productcode').val();
          var q = $(this).find('.quantity').val();
          var p = $(this).find('.price').val();
          var pp = $(this).find('.pprice').val();
          var profit1 = $(this).find('.final_profit').val();
          code2.push(c);
          qtyArray2.push(q);
          priceArray2.push(p);
          ppriceArray2.push(pp);
          profitArray2.push(profit1)
        });
    }
    function save()
     {
       update();
      cname = $('#customer').val();
      received = $('#received').val();
      //gross = $('#gross').val();
      if(cname==''){
        alert("Please Select Customer First!");
      } 
      else if(code2==''){
        alert("Please Add Items!");
        $("#lockForm").submit(function(e){
          e.preventDefault();
        });
      }
      else if(received==''){
        alert("Please Enter Amount Received!");
        $("#lockForm").submit(function(e){
          e.preventDefault();
        });
      }
      else {
     
      var barcode = JSON.stringify(code2);
      var qty     = JSON.stringify(qtyArray2);
      var price   = JSON.stringify(priceArray2);
      var pprice  = JSON.stringify(ppriceArray2);
      var profit2 = JSON.stringify(profitArray2);
      var formData = new FormData($("#lockForm")[0]);
            $.ajax({
                url: "SaveNewInvoice.php?barcode="+barcode+"&qty="+qty+"&price="+price+"&pprice="+pprice+"&profit="+profit2,
                type: 'POST',
                data: formData,
                dataType: "text",
                async: false,
                success: function (info) {
                // alert(info);
                window.open('print.php?sale_No='+info,'popUpWindow','height=400,width=500,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
                location.reload();
                // $("#editnews").html(info);
                },
                cache: false,
                 contentType: false,
                processData: false
            });
      }
    }
     

</script>