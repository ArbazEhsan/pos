<title>Opening Balance</title>
<?php
include('../session.php');
include("../header.php");
include("../connect.php");
?>
<style type="text/css">
    div.dataTables_wrapper {
        margin-bottom: 3em;
    }
  </style> <!-- data-table libraries end -->
  <nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
    <!--<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>-->
  </ul>
</nav>
<form id="itemForm">
  <div class="container">
  	<div class="row">
  		<center><h1>Opening Balance</h1></center>
  	</div><hr>
  </div>
   <div class="container-fluid">
  	<div class="row">
  		<div class="col-md-3">
  			<label>Opening Date</label>
  			<input type="date" name="day" class="form-control" value="<?php echo date('Y-m-d'); ?>">
  		</div>
  	</div><br>
  </div>
<div class="container-fluid">
  <div class="row">
            <div class="col-md-12">
              <?php
                $result=mysqli_query($con,"SELECT * FROM customer ORDER BY type");
                ?>
                <table id="head" class="display table" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Account #</th>
                    <th>Name</th>
                    <th>Day</th>
                    <th>Account Type</th>
                    <th>City</th>
                    <th>Receivable</th>
                    <th>Payable</th>
                  </tr>
                </thead>
                <tfoot></tfoot>
                <tbody>
                    <?php
                    $count = 0;
             	while($fetch=mysqli_fetch_array($result))
                {
                  $count++;
                  $result1 = mysqli_query($con,"SELECT * FROM customerledger WHERE customer='".$fetch['id']."' AND naration='Opening Balance'");
                  $fetch1 = mysqli_fetch_array($result1);
                  ?>
                  <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $fetch['id'];?></td>
                    <td><?php echo $fetch['name'];?></td>
                    <td><?php echo $fetch1['day'];?></td>
                    <td><?php echo $fetch['type'];?></td>
                    <td><?php echo $fetch['city'];?></td>
                    <td>
                      <input type="text" style="width: 70%;" name="dr[]" value="<?php echo $fetch1['db']; ?>" class="form-control"><input type="hidden" name="customerid[]"  value="<?php echo $fetch1['id']; ?>">
                    </td>
                    <td><input type="text" style="width: 70%;" name="cr[]" value="<?php echo $fetch1['cr']; ?>" class="form-control"></td>
                  </tr>
              <?php } ?>
         		</tbody>
</table>

       </div>
   </div>
   </form>
   <div class="row">
   	<div class="col-md-12">
   		<input  class="btn btn-primary" onclick="update()" style="width:100%;" value="Update" readonly>
   	</div>
   </div>
</div>
<?php include("../footer.php"); ?>
<script type="text/javascript">
$(document).ready(function() {
    $('table.display').DataTable( {
        dom: 'Blfrtip',
        
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
            visible: true,
        } ]
    } );
} );
</script>

<script type="text/javascript">
  var active;
$(document).keydown(function(e){
    active = $('td.active').removeClass('active');
    var x = active.index();
    var y = active.closest('tr').index();
    if (e.keyCode == 37) { 
       x--;
    }
    if (e.keyCode == 38) {
        y--;
    }
    if (e.keyCode == 39) { 
        x++
    }
    if (e.keyCode == 40) {
        y++
    }
    acti
</script>
<script type="text/javascript">
  function func()
  {
    text = confirm("Warning: Are you sure to delete this product?");
    if(text == true)
    {
      return ture;
    }
    else
    {
      return false;
    }
  }
   function update(){
    var counter = 0;
    
      // alert("Receipt Inserted");
         var formData = new FormData($("#itemForm")[0]);
            $.ajax({
                url: "save.php",
                type: 'POST',
                data: formData,
                dataType: "text",
                async: false,
                success: function (info) {
                  //alert(info);
                 window.location.reload();

           // $("#result").html(info);
                },
                cache: false,
                 contentType: false,
                processData: false
            });
    
        
}
</script>