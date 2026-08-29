<title>Cash Out</title>
<?php include('../session.php'); include('../header.php');include('../connect.php');
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body>
</nav>
<center><h1>Cash Out</h1></center><hr>
<div class="container">
  <form method="POST" id="formId">
    <div class="row">
      <div class="col-md-3">
        <input type="date" class="form-control" name="day" value="<?php echo date('Y-m-d'); ?>" required>
      </div>
      <div class="col-md-3">
        <?php 
        $result2 = mysqli_query($con,"SELECT * FROM tcounter ORDER BY id DESC");
        $vno = 100;
        if (mysqli_num_rows($result2)>0) {
          $fetch2 = mysqli_fetch_array($result2);
          $vno = $fetch2['voucher_no']+1;
        }
        ?>
        <input type="text" name="vno" class="form-control" placeholder="Voucher No" autocomplete="off" value="<?php echo $vno; ?>" required readonly>
        <input type="hidden" name="tamnt" id="tamnt" class="form-control" placeholder="Total Amount" autocomplete="off">
      </div>
    </div><br>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Party</th>
              <th>Remarks</th>
              <th>Amount</th>
              <th>Operation</th>
            </tr>
          </thead>
          <tbody id="item-details"></tbody>
          <tfoot>
            <tr>
              <th colspan="3" style="text-align: right;">Total: <span id="total"></span></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </form>
  <div class="row">
      <div class="col-md-3">
        <button class="btn btn-primary" onclick="save()">Submit</button>
      </div>
  </div>
</div>
<?php include('../footer.php'); include('../subscription.php'); ?>
<script type="text/javascript">

  var object = '<?php 
          $sql="SELECT * FROM accounts WHERE active='1' ORDER BY type";
          $result=mysqli_query($con,$sql);
          $fetch=mysqli_fetch_array($result);
          echo "<option>".$fetch["name"]."</option>";  ?>';

  function append(argument) {
    var n=($('#item-details tr').length-0)+1;
    var newRow="";
        newRow= '<tr>'+  
      '<td><select class="form-control customer" id="customer'+n+'" name="customer[]" required><option value="0" disabled selected>--- Select ---</option>'+
      '<?php 
          $sql="SELECT * FROM accounts WHERE active='1' ORDER BY name";
          $result=mysqli_query($con,$sql);
          while($fetch=mysqli_fetch_array($result)){
          echo "<option value=".$fetch["id"].">".$fetch["name"]."</option>"; } ?>'+
      '</select></td>'+ 
      '<td><input type="text" class="form-control remarks" id="remarks'+n+'" name="remarks[]" placeholder="Remarks" autocomplete="off"></td>'+  
      '<td><input type="text" class="form-control amount" id="amount'+n+'" name="amount[]" placeholder="Amount" autocomplete="off"></td>'+
      '<td><a href="#" onclick="remove('+n+')" class="btn btn-danger remove">Delete</a> '+
      '<a href="#" onclick="append()" class="btn btn-success">Add</a></td>'  
      '</tr>';
      $("#item-details").append(newRow);
  }

  append();

  function total() {
    var z = 0;
    $("#item-details tr").each(function() {
      var x = $(this).find('.amount').val();
      z = Number(z)+Number(x);
    });
    $("#total").html(z);   
    $("#tamnt").val(z);
  }

  $('body').delegate('.remove','click',function()  {
    $(this).parent().parent().remove();
    total();
    n--;
  });

  $('body').delegate('.amount','keyup',function()  {  
    total();  
  });

  function save() {
    var formData = new FormData($("#formId")[0]);
    $.ajax({
      url: "saveCashout.php",
      type: 'POST',
      data: formData,
      dataType: "text",
      async: false,
      success: function (info) {
        //alert(info);
        window.open('printcashout.php?sale_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
        window.location.reload();
      },
      cache: false,
      contentType: false,
      processData: false
    });
  }
</script>