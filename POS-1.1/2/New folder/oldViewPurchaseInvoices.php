<title>Purchase Invoices List</title>
<?php
include('../session.php');
include ("../header.php");
include("../connect.php");
include("../converter.php");
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php 
    if (isset($_REQUEST['delid'])) 
    {
      $result101 = mysqli_query($con, "SELECT id FROM trans WHERE invoice_id='".$_REQUEST['delid']."' AND type='PV'");
      $fetch101 = mysqli_fetch_array($result101);
      
      mysqli_query($con,"DELETE FROM psale WHERE sale_No='".$_REQUEST['delid']."'");
      mysqli_query($con,"DELETE FROM ledgers WHERE trans_id='".$fetch101['id']."'");
      mysqli_query($con,"DELETE FROM trans WHERE invoice_id='".$_REQUEST['delid']."' AND type='PV'");
      mysqli_query($con,"DELETE FROM pcounter WHERE id='".$_REQUEST['delid']."'");

      header("Location:viewPurchase.php?deleted");
    }
 ?>
 <nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
    <!--<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>-->
  </ul>
</nav>
<center><h1>View Purchase Invoices</h1></center><hr>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 table-responsive">
      <div class="col-md-4 pull-right">
        <input type="text" id="myInput" autocomplete="off" class="form-control" onkeyup="myFunction()" placeholder="Search Here" autofocus="on"><br>
      </div>
      <div class="col-md-2 pull-right">
        <select name="sort" id="sort" class="form-control" onchange="sort(this.value)">
          <option value="0">Date</option>
          <option value="1">Invoice_No</option>
          <option value="2">Vendor</option>
          <option value="3">Bilty_No</option>
        </select><br>
      </div>
 	<table class="display1 table table-striped table-hover table-bordered" id="myTable">
    <thead>
      <tr>
    <th>Day</th>
      <th>Invoice_No</th>
      <th>Vendor</th>            
      <th>Bilty_No</th>
      <th>Operation</th>
    </tr>  
    </thead>
    <tfoot>
      <tr>
      <th>Day</th>
      <th>Invoice_No</th>
      <th>Vendor</th>            
      <th>Bilty_No</th>
      <th>Operation</th>
    </tr>
    </tfoot>
 		<tbody>
 		<tr>
      <?php 
      $sql = "SELECT * FROM pcounter ORDER BY sale_day";
      $result = mysqli_query($con,$sql);
      while($fetch = mysqli_fetch_array($result))
      {
      ?>
      <td><?php echo date('d-M-Y', strtotime($fetch['sale_day'])); ?></td>
 			<td><?php echo $fetch['id']; ?></td>
      <td><?php echo getCustomerName($fetch['customer']); ?></td>
      <td><?php echo $fetch['bilty_No']; ?></td>
      <td><a class=" btn btn-primary" onclick="view(this.id)" id="<?php echo $fetch['id'] ?>">View Invoice</a><!--  <a href="quotation.php?order_No=<?php echo $fetch['order_No']; ?>" class="btn btn-success">Add Quotations</a> <a onclick="return validate()" href="delFullOrder.php?order_No=<?php echo $fetch['order_No']; ?>&counter=0&check=pur" class="btn btn-danger">Delete Order</a> --> <a href="editPurchaseInvoice.php?id=<?php echo $fetch['id']; ?>" class="btn btn-warning">Edit  Invoice</a> <a href="viewPurchase.php?delid=<?php echo $fetch['id']; ?>" class="btn btn-danger">Delete Invoice</a></td>
 		</tr>
    <?php }?>
    </tbody>
 	</table>
    </div><!-- 1st tab end -->
  </div>
</div>
</body>
</html>
 <?php 
include ("../footer.php");
 ?>
 <script type="text/javascript">
  $(function() { 
    // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        // save the latest tab; use cookies if you like 'em better:
        localStorage.setItem('lastTab', $(this).attr('href'));
    });

    // go to the latest tab, if it exists:
    var lastTab = localStorage.getItem('lastTab');
    if (lastTab) {
        $('[href="' + lastTab + '"]').tab('show');
    }
});
</script>
 <script type="text/javascript">
// $(document).ready(function() {
//     $('table.display1').DataTable( {
//         dom: 'Blfrtip',
        
//         "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] , 
//         buttons: [
//             {
//                 extend: 'print',
//                 exportOptions: {
//                     columns: ':visible'

//                 }
//             },
//             'colvis'
//         ],
//         columnDefs: [ {
//             targets: -1,
//             visible: true,
//         } ]
//     } );
// } );
</script>
<script type="text/javascript">
  function validate()
  {
    text = confirm("Are you sure you want to delete?");
    if(text == true)
    {
      return true;
    }
    else
       return false;
  }
  function view(info)
  {
 
    window.open('print1.php?sale_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
  }
var z = 0;
function sort(val) {
  z = val;
}
   function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[z];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>