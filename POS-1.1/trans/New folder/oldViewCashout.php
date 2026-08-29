<?php include("../connect.php");  include('../session.php');
//  if( ($_SESSION['username']=='') && ($_SESSION['password']==''))
// {
//     header("Location:../index.php?msg=Please Login to Continue");
// }
if(isset($_REQUEST['delId']))
{
  $delId = $_REQUEST['delId'];
  $result2 = mysqli_query($con,"SELECT * FROM trans WHERE bill_no='$delId'");
  $fetch2 = mysqli_fetch_array($result2);
  mysqli_query($con,"DELETE FROM ledgers WHERE trans_id='".$fetch2['id']."'");
  mysqli_query($con,"DELETE FROM trans WHERE bill_no='$delId'");
  mysqli_query($con,"DELETE FROM tcounter WHERE id='$delId'");
  
  header("location:viewCashout.php");
}
 ?>
<title>View Cash Out</title>
<?php
include ("../header.php");
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php 
		$result = mysqli_query($con,"SELECT * FROM tcounter WHERE type='CO' ORDER BY day");
 ?>
 <nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
    <!--<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>-->
  </ul>
</nav>
<center><h1>View Cashout</h1></center><hr>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 table-responsive">
      <div class="col-md-4 pull-right">
        <input type="text" id="myInput" autocomplete="off" class="form-control" autofocus="on" onkeyup="myFunction()" placeholder="Search Here"><br>
      </div>
      <div class="col-md-2 pull-right">
        <select name="sort" id="sort" class="form-control" onchange="sort(this.value)">
          <option value="0">Date</option>
          <option value="1">Voucher#</option>
          <option value="2">Amount</option>
        </select><br>
      </div>
 	<table class="display1 table table-striped table-hover table-bordered" id="myTable">
    <thead>
      <tr>
      <th>Date</th>
      <th>Voucher#</th>
      <th>Amount</th> 
      <th>Operation</th>
    </tr>  
    </thead>
    <tfoot>
      <tr>
      <th>Date</th>
      <th>Voucher#</th>
      <th>Amount</th> 
      <th>Operation</th>
    </tr>
    </tfoot>
 		<tbody>
 		<tr>
      <?php 
      while($fetch = mysqli_fetch_array($result))
      {
        $c = $fetch['account_id'];
        $result1 = mysqli_query($con,"SELECT * FROM accounts WHERE id='$c'");
        $fetch1 = mysqli_fetch_array($result1);
      ?>
      <td><?php echo date('d-M-Y', strtotime($fetch['day'])); ?></td>
 			<td><?php echo $fetch['voucher_no']; ?></td>
      <td><?php echo $fetch['total_amnt']; ?></td>
      <td><button class="btn btn-primary" onclick="view(this.id)" id="<?php echo $fetch['id'] ?>">View Invoice</button>
        <a href="editCash.php?from=CO&id=<?php echo $fetch['id']?>&vno=<?php echo $fetch['voucher_no'] ?>" class="btn btn-warning">Edit</a>
        <a href="viewCashout.php?delId=<?php echo $fetch['id']?>" class="btn btn-danger" onclick="return func()">Delete</a>
        </td>
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
    window.open('printcashout.php?sale_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
  }
</script>
<script type="text/javascript">
  function func()
  {
    text = confirm("Warning: Are You Sure You Want to Delete this Transaction?");
    if(text == true)
    {
      return ture;
    }
    else
    {
      return false;
    }
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