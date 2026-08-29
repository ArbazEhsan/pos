<title>Edit Location</title>
<?php
include('../session.php');
include("../header.php");
include("../connect.php");
?>
<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="../menu.php"><span aria-hidden="true">&larr;</span> Menu</a></li>
    <!--<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>-->
  </ul>
</nav>

<div class="container">
<font color="red" size="4">
<?php
 //if(isset($_GET['msg']))
 //{
  //echo $_GET['msg'];
 //}
?>

</font>  

  <div class="tab-content">
    <div id="product" class="tab-pane fade in active">
        <div class="row">
    <div class="col-md-12">
      <h1 align="center">Location Edit Menu</h1>
    </div>
  </div>
  <br>

<form name="shopSearchForm" action="shopOpeningInsert.php" id="shopSearchForm">
<div class="container">
  <div class="row">
    <div class="col-md-5">
      <input list="head"  id="" name="head" placeholder="Product Name" class="form-control">
      <datalist id="head">
        <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">               
                            <option value="All">All</option>         
                             <?php
                              $sql1="SELECT * FROM products ORDER BY name";
                              $result1=mysqli_query($con,$sql1);
                               while($fetch1=mysqli_fetch_array($result1))
                                {
                                ?>
                             <option value="<?php echo $fetch1['name'];?>"><?php echo $fetch1['name'];?> </option>
                             <?php } ?>
                          </ul>
      </datalist> 
    </div>

   
  </div><!-- 1st Row Close -->

 


    <div class="row">
      <div class="col-md-5">
        <input type="hidden" name="location" id="" class="form-control" placeholder="Location">
      </div>
     </div>
  
    
    <div class="row">
      <div class="col-md-10"><br>
        <div onclick="search()" class="btn btn-primary">Search</div>
      </div>
    </div><br>
    </form>
<hr>
<form action="shopOpeningInsert.php" method="POST">

  <div class="row">
               <?php
    
                $sql6 = "SELECT * FROM products";
                
                $result6=mysqli_query($con,$sql6);
                
                ?>
                <table id="tablecustom" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>New Location</th>
                  </tr>
                </thead>
                <tfoot>                  
                  <tr>
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>New Location</th>
                  </tr>
                  
                </tfoot>
                <tbody>

                 <tr>
                     <?php while($fetch6 = mysqli_fetch_array($result6))
                        {
                       ?>
                                        
                  </tr>
          <?php } ?>
           
                </tbody>
</table><br>
      <button class="btn btn-primary btn-block">Update</button>
            </div>
          </div>

</form>
    </div><!--1st Tab End -->
    


</div><!-- 1st container -->




<?php include("../footer.php"); include('../subscription.php');?>




<script type="text/javascript">
function search()
{
 //alert("clicked");
 var formData = new FormData($("#shopSearchForm")[0]);
    $.ajax({
        url: "shopsearch.php",
        type: 'POST',
        data: formData,
  dataType: "text",
        async: false,
        success: function (info) {
        document.getElementById('tablecustom').innerHTML = info;
        //alert(info);
   $("#editnews").html(info);
        },
        cache: false,
        contentType: false,
        processData: false
    });
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
	function add()
	{
		var text=confirm("Warning : This Action Is Not Reversible");
		if(text==true)
		{
			document.getElementByID('openingform').submit();
			return true;
		}
		else
		{
			return false;
		}
		
	}
</script>