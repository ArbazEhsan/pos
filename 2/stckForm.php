<title>Stock Form</title>
<?php 
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
    <li class="previous"><a href="../menu.php"><span aria-hidden="true">&larr;</span> Back</a></li>
    <!--<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>-->
  </ul>
</nav>
  <div class="container">
  	<div class="row">
  		<center><h1>Stock Form</h1></center>
  	</div>
  </div>
  
<div class="container-fluid">
  <div class="row">
            <div class="col-md-12">
            	<form action="editProducts.php" method="post" name="viewProducts">
              <?php

                $result=mysqli_query($con,"SELECT * FROM products");
                ?>
                <table id="head" class="display table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr><th>#</th><th>Item No</th><th>Name</th><th>P.Price</th><th>W.SalePrice</th><th>R.Price</th><th>Location</th><th>Mini Qty</th><!-- <th>Operations</th> --></tr>
                </thead>
                <tfoot>
                <tr><th>#</th><th>Item No</th><th>Name</th><th>P.Price</th><th>W.SalePrice</th><th>R.Price</th><th>Location</th><th>Mini Qty</th><!-- <th>Operations</th> --></tr>
                </tfoot>
                <tbody>
                    <?php
                    $count = 0;
              while($fetch=mysqli_fetch_array($result))
                {
                  $count++;
                  if ($fetch['active']=='0') {
                     $text = 'active';
                      $btn  = 'success';
                  }
                  else
                  {
                      $text = 'inactive';
                      $btn  = 'danger';
                  }
                  ?>
                  <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $fetch['id'];?></td><td><?php echo $fetch['name'];?></td><td><?php echo $fetch['p_price'];?></td><td><?php echo $fetch['w_price'];?></td><td><?php echo $fetch['r_price'];?></td><td><?php echo $fetch['location'];?></td><td><?php echo $fetch['minQ'];?></td>
                   <!--  <td><a class="btn btn-<?php echo $btn; ?>" onclick="return func()" href="operations.php?id=<?php echo $fetch['id'];?>&from=2"><?php echo $text; ?></a> <a class="btn btn-primary" href="editProduct.php?id=<?php echo $fetch['id'];?>">Edit</a> -->
                  </tr><!-- delProduct -->
              <?php } ?>
         
                </tbody>
</table>
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
</script>