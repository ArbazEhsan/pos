
<title>Expense</title><?php include('../session.php'); include('../header.php');include('../connect.php');

if (isset($_GET['id'])) {
    mysqli_query($con,"DELETE FROM expense WHERE id='".$_GET['id']."'");
    mysqli_query($con,"DELETE FROM cashout WHERE expense_Id='".$_GET['id']."'");
    header("Location:expense.php?Deleted");
}

?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body>
</nav>
<center><h1>Add Expense</h1></center><hr>
<div class="container">
<form id="formId"> <div class="row">
		<div class="col-md-3">
			<input type="date" class="form-control" name="day" value="<?php echo date('Y-m-d'); ?>" required>
		</div>
	</div><br>
	
  <div class="row">
    <div class="col-md-3">
      <input type="" id="amount" name="amount" class="form-control" placeholder="Amount" required>
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-3">
      <input type="" name="naration" class="form-control" placeholder="Naration">
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

<div class="row"><br><br>
  <div class="col-md-12">
   <table class="table table-bordred">
  <thead>
    <th>Sr#</th>
    <th>Day</th>
    <th>Naration</th>
    <th>Amount</th>
    <th>Operation</th>
  </thead>
  <tfoot>
    <th>Sr#</th>
    <th>Day</th>
    <th>Naration</th>
    <th>Amount</th>
    <th>Operation</th>
  </tfoot>
  <tbody>
    <?php
    $counter=0;
         $result=mysqli_query($con," SELECT * FROM expense");
         while($fetch=mysqli_fetch_array($result))
         {$counter++;
          ?>
          <tr>
          <td><?php echo $counter; ?></td>
          <td><?php echo date("d/m/Y", strtotime($fetch['day'])); ?></td>
          <td><?php echo $fetch['naration']; ?></td>
          <td><?php echo $fetch['amount']; ?></td>
          <td> <a href="expense.php?id=<?php echo $fetch['id'];?>" class="btn btn-danger">Delete</a>
             <a href="editExpense.php?id=<?php echo $fetch['id'];?>" class="btn btn-primary">Edit</a>
            <td>
          </tr>
        <?php }  ?>
    
  </tbody>
</table>
  </div>
</div>
</div><!-- main container div end -->
<?php include('../footer.php'); ?>
<script type="text/javascript">
   function save()
     { 
      //cname = $('#customer').val();
      amount = $('#amount').val();
      if(amount==''){
        //alert("Please Enter Amount!");
        $("#formId").submit(function(e){
          e.preventDefault();
        });
      }
      else {
       var formData = new FormData($("#formId")[0]);
            $.ajax({
                url: "saveExpense.php",
                type: 'POST',
                data: formData,
          dataType: "text",
                async: false,
                success: function (info) {
          //alert(info);
           /* window.open('printcashin.php?sale_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');*/
           //alert("Expense Added");
            window.location.reload();
           $("#editnews").html(info);
                },
                cache: false,
                 contentType: false,
                processData: false
            });
        }
    }
</script>