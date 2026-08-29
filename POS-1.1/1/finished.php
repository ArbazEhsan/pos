<title>Finshed Goods</title>
<?php include('../session.php'); include('../header.php');include('../connect.php');

if(isset($_REQUEST['delId'])){

  $delId = $_REQUEST['delId'];
  $fgoods = $_REQUEST['fg'];
  $fQty = $_REQUEST['fQty'];
  $product = $_REQUEST['consume'];
  $pQty = $_REQUEST['qty'];

  $pro = explode(',', $product);
  $qty = explode(',', $pQty);
  
  mysqli_query($con,"UPDATE products SET shQty=shQty-'$fQty' WHERE id='$fgoods'");
  
  foreach ($pro as $key => $value) {
    mysqli_query($con,"UPDATE products SET shQty=shQty+'$qty[$key]' WHERE id='$pro[$key]'");
  }
  mysqli_query($con,"DELETE FROM finished WHERE id='$delId'");
}

?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body>
</nav>
<center><h1>Finished Goods</h1></center><hr>
<div class="container">
  <form method="POST" id="formId">
    <div class="row">
      <div class="col-md-3">
        <input type="date" class="form-control" name="day" value="<?php echo date('Y-m-d'); ?>" required>
      </div>
      <div class="col-md-3">
        <select class="form-control" name="fgoods" onchange="getUnit(this.value)" required>
        <option value="0" disabled selected>--- Select ---</option>
        <?php 
          $sql="SELECT * FROM products WHERE active='1' ORDER BY name";
          $result2=mysqli_query($con,$sql);
          while($fetch2=mysqli_fetch_array($result2)){
          echo "<option value=".$fetch2["id"].">".$fetch2["name"]."</option>";}  ?>
        </select>
      </div>
      <div class="col-md-2">
        <input type="number" class="form-control" id="unit" placeholder="Weight" disabled>
      </div>
      <!-- <div class="col-md-3">
        <input type="number" class="form-control" name="fQty" placeholder="Finished Qty" required>
      </div> -->
    </div><br>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Item</th>
              <th>Qty</th>
              <th>Operation</th>
            </tr>
          </thead>
          <tbody id="item-details"></tbody>
          </tfoot>
        </table>
      </div>
    </div>
  </form>
  <div class="row">
      <div class="col-md-3">
        <button class="btn btn-primary" onclick="save()">Submit</button>
      </div>
  </div><br><br><br><br>
  <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Day</th>
              <th>Finished Goods</th>
              <th>F.Qty</th>
              <th>Consume</th>
              <th>Qty</th>
              <th>Operation</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $result3 = mysqli_query($con,"SELECT * FROM finished ORDER BY day");
              while($fetch3=mysqli_fetch_array($result3)) {
              $consume = '';
              $pro = explode(',', $fetch3['consume']);
            foreach ($pro as $key => $value) {
              $result4 = mysqli_query($con,"SELECT * FROM products WHERE id='$pro[$key]'");
              $fetch4 = mysqli_fetch_array($result4);
              $consume .= $fetch4['name'].',';
            }
            $result5 = mysqli_query($con,"SELECT * FROM products WHERE id='".$fetch3['finish_good']."'");
            $fetch5 = mysqli_fetch_array($result5);
            ?>
            <tr>
              <td><?php echo date('d-M-Y', strtotime($fetch3['day'])); ?></td>
              <td><?php echo $fetch5['name']; ?></td>
              <td><?php echo $fetch3['fQty']; ?></td>
              <td><?php echo $consume; ?></td>
              <td><?php echo $fetch3['qty']; ?></td>
              <td><a href="finished.php?delId=<?php echo $fetch3['id']?>&consume=<?php echo $fetch3['consume'] ?>&qty=<?php echo $fetch3['qty'] ?>&fg=<?php echo $fetch3['finish_good'] ?>&fQty=<?php echo $fetch3['fQty'] ?>" class="btn btn-danger">Delete</a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
  </div>
</div>
<?php include('../footer.php'); include('../subscription.php'); ?>
<script type="text/javascript">

  function append(argument) {
    var n=($('#item-details tr').length-0)+1;
    var newRow="";
        newRow= '<tr>'+  
      '<td><select class="form-control product" id="product'+n+'" name="product[]" required><option value="0" disabled selected>--- Select ---</option>'+
      '<?php 
          $sql="SELECT * FROM products WHERE active='1' ORDER BY name";
          $result=mysqli_query($con,$sql);
          while($fetch=mysqli_fetch_array($result)){
          echo "<option value=".$fetch["id"].">".$fetch["name"]."</option>"; } ?>'+
      '</select></td>'+ 
      '<td><input type="number" class="form-control qty" id="qty'+n+'" name="qty[]" placeholder="Qty" autocomplete="off"></td>'+
      '<td><a href="#" onclick="remove('+n+')" class="btn btn-danger remove">Delete</a> '+
      '<a href="#" onclick="append()" class="btn btn-success">Add</a></td>'  
      '</tr>';
      $("#item-details").append(newRow);
  }

  append();

  $('body').delegate('.remove','click',function()  {
    $(this).parent().parent().remove();
    n--;
  });

  $('body').delegate('.amount','keyup',function()  {  
    var z = 0;
    $("#item-details tr").each(function() {
      var x = $(this).find('.amount').val();
      z = Number(z)+Number(x);
    });
    $("#total").html(z);   
  });

  function save() {
    var formData = new FormData($("#formId")[0]);
    $.ajax({
      url: "saveFinished.php?from=finishedSave",
      type: 'POST',
      data: formData,
      dataType: "text",
      async: false,
      success: function (info) {
        if (info==0) {
          alert("Please enter Liter/Gram of the product");
        }
        else {
          alert(info);
          window.location.reload();
        }
      },
      cache: false,
      contentType: false,
      processData: false
    });
  }

function getUnit(product) {
  $.ajax({
      url: "saveFinished.php?from=finished&id="+product,
      type: 'GET',
      data: product,
      dataType:"text", 
      async: false,
      success: function (info) {
        //alert(info);
        $('#unit').val(info);
        //window.location.reload();
      },
      cache: false,
      contentType: false,
      processData: false
    });
}
</script>