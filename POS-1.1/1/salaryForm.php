<title>Emp Salary</title>
<?php 
include('../session.php'); 
include('../header.php');
include('../connect.php');
?>
<div class="container-fluid">
  <h2>Employee Salary</h2>
  <h5>Here you can perform all actions</h5><hr>
  <form method="POST" id="formId">
    <div class="row">
      <div class="col-md-2">
        <label>Date</label>
        <input type="date" class="form-control" name="day" value="<?php echo date('Y-m-d'); ?>" autofocus required>
      </div>
      <div class="col-md-2">
        <?php 
        $result2 = mysqli_query($con,"SELECT * FROM slrcounter ORDER BY id DESC");
        $vno = 100;
        if (mysqli_num_rows($result2)>0) {
          $fetch2 = mysqli_fetch_array($result2);
          $vno = $fetch2['voucher_no']+1;
        }
        ?>
        <label>Voucher#</label>
        <input type="text" name="vno" class="form-control" placeholder="Voucher No" autocomplete="off" value="<?php echo $vno; ?>" required readonly>
        <input type="hidden" name="tamnt" id="tamnt" class="form-control" placeholder="Total Amount" autocomplete="off">
      </div>
      <div class="col-md-2">
      	<label>A/C Title</label>
        <select class="form-control customer" name="customer" required><option value="0" disabled selected>--- Select ---</option>'+
      <?php 
          $sql="SELECT * FROM accounts WHERE active='1' AND type='Liability' ORDER BY name";
          $result=mysqli_query($con,$sql);
          while($fetch=mysqli_fetch_array($result)){
          echo "<option value=".$fetch["id"].">".$fetch["name"]."</option>"; } ?>
      </select>
      </div>
      <div class="col-md-2">
        <label>Designation</label>
        <input type="text" name="designation" class="form-control" placeholder="Designation" autocomplete="off" required readonly>
      </div>
      <div class="col-md-2">
        <label>Amount</label>
        <input type="text" name="amount" class="form-control" placeholder="Amount" autocomplete="off" required>
      </div>
    </div><br>
    <!-- <div class="row">
      <div class="col-md-12">
      	<h4>Benifits & Allowances</h2><hr>
      </div>
    </div> -->
    <div class="row">
      <div class="col-md-4">
      	<label>Benifits:</label>
      	Annual Bonus
      	<input type="checkbox" name="amount" placeholder="Amount" autocomplete="off" required>
      	&nbsp;Eid Bouns
      	<input type="checkbox" name="amount" placeholder="Amount" autocomplete="off" required>
      	&nbsp;Christmas Bouns
      	<input type="checkbox" name="amount" placeholder="Amount" autocomplete="off" required>
      </div>
      <div class="col-md-4">
      	<label>Allowance:</label>
      	Overtime
      	<input type="checkbox" name="amount" placeholder="Amount" autocomplete="off" required>
      	&nbsp;Fuel
      	<input type="checkbox" name="amount" placeholder="Amount" autocomplete="off" required>
      	&nbsp;Mobile
      	<input type="checkbox" name="amount" placeholder="Amount" autocomplete="off" required>
      	&nbsp;Medical
      	<input type="checkbox" name="amount" placeholder="Amount" autocomplete="off" required>
      </div>
      <div class="col-md-4">
      	<label>Deduction:</label>
      	Tax
      	<input type="checkbox" name="amount" placeholder="Amount" autocomplete="off" required>
      	&nbsp;PF
      	<input type="checkbox" name="amount" placeholder="Amount" autocomplete="off" required>
      	&nbsp;Medical
      	<input type="checkbox" name="amount" placeholder="Amount" autocomplete="off" required>
      </div>
  	</div><br>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>A/C Title</th>
              <th>Remarks</th>
              <th>Amount</th>
              <th>Operation</th>
            </tr>
          </thead>
          <tbody id="item-details"></tbody>
          <tfoot>
            <tr>
              <th colspan="3" style="text-align: right;">Total: </th>
              <th><span id="total"></span></th>
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

  $('body').delegate('.remove','click',function()  {
    $(this).parent().parent().remove();
    total();
    n--;
  });

  function save() {
    var formData = new FormData($("#formId")[0]);
    $.ajax({
      url: "operation.php?from=salary&operation=insert",
      type: 'POST',
      data: formData,
      dataType: "text",
      async: false,
      success: function (info) {
        //alert(info);
        window.open('printcashin.php?sale_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
        window.location.reload();
      },
      cache: false,
      contentType: false,
      processData: false
    });
  }
</script>