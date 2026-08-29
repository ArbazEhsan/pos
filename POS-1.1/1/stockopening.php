<title>Stock Opening</title>
<?php
include('../session.php');
include('../connect.php');
include('../header.php');
if(isset($_POST['update']))
{

	
   $id=$_POST['id'];
   $shqty=$_POST['shqty'];


 foreach($id as $key => $value)
    {  if($shqty[$key] =='' || $shqty[$key] =='0')
             {

              }
 else{
        
  mysqli_query($con,"UPDATE products SET shQty='$shqty[$key]',sh_status='1' WHERE id='$id[$key]'");
         }
  }

  header('location:stockopening.php');
}

if(isset($_POST['search']))
             { 
               
             $name=$_POST['name'];
             }

?>

<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="check.php"><span aria-hidden="true">&larr;</span> Back</a></li>
    <!--<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>-->
  </ul>
</nav>
<div class="container"> 
<center><h2>Stock Opening</h2></center><hr>
<form action="stockopening.php" method="POST">  
   <div class="row">
            <div class="col-md-4">
              <h5>Enter Product</h5>
              <input type="text" autocomplete="off" placeholder="Urdu+English" style="font-size: 20px;" autofocus name="name" list="head" class="form-control" value="<?= $name;  ?>">
              <datalist id="head" >
                <?php

                 $result1=mysqli_query($con,"SELECT * FROM products WHERE active='1'");
                  mysqli_set_charset($con,'utf8');
                 while($fetch1=mysqli_fetch_array($result1))
                 {?>
                  <option></option>
                  <option value="<?php echo $fetch1['name']; ?>"><?php echo $fetch1['name']; ?></option>


                <?php }
                ?>
                
              </datalist>
            </div>
          </div>    <br>         
            <div class="row">
		<div class="col-md-4">
			<button class="btn btn-primary" name="search" >Search or All</button>
		</div>
	</div>
		  	</form><hr>

  <form acction="stockopening.php" method="POST">
        <table class="table table-striped" >

          <thead>
            <th>Sr#</th>
            <th>PID</th>
            <th>Product Name</th>
            <th>Liter</th>
            <th>Purchase Price</th>
            <th>Whole Price</th>
            <th>Retail Price</th>
            <th>Mini Qty</th>
            <th>Shop Qty</th>
        
          </thead>
          <tfoot>
            <th>Sr#</th>
            <th>PID</th>
            <th>Product Name</th>
            <th>Liter</th>
            <th>Purchase Price</th>
            <th>Whole Price</th>
            <th>Retail Price</th>
            <th>Mini Qty</th>
            <th>Shop Qty</th>
          
          </tfoot>
          <tbody>
          	<?php
            if(isset($_POST['search'])){ 
             	 $name=$_POST['name'];
               
            if($name!=''){

              $name=$_POST['name'];
              mysqli_set_charset($con,'utf8');
              $result=mysqli_query($con,"SELECT * FROM products  WHERE name='$name' AND sh_status='0' AND active='1'");
            }  
            else if($name=='') {
              $result=mysqli_query($con,"SELECT * FROM products  WHERE sh_status='0' AND active='1'");
            }
            $counter=0;
           while($fetch=mysqli_fetch_array($result)){ 
            $counter++;?>

            <tr>
              <td><?php echo $counter; ?> </td>
              <td><?php echo $fetch['id']; ?> </td>
              <td><?php echo $fetch['name']; ?> </td>
              <td><?php echo $fetch['size']; ?> </td>
              <td><?php echo $fetch['p_price']; ?> </td>
              <td><?php echo $fetch['w_price']; ?> </td>
              <td><?php echo $fetch['r_price']; ?> </td>
              <td><?php echo $fetch['minQ']; ?> </td> 
              <td> <input type="" class="form-control" name="shqty[]" value="<?php echo $fetch['shQty']; ?>" > </td>
              <td><input type="hidden" class="form-control" name="id[]"   value="<?php echo $fetch['id']; ?>"></td></td>
            </tr>
           <?php}
            }
            else{    
        	    $counter=0;
              $name=$_POST['name'];
              mysqli_set_charset($con,'utf8');
              $result=mysqli_query($con,"SELECT * FROM products  WHERE sh_status='0' AND active='1'");
            while($fetch=mysqli_fetch_array($result)){
              $counter++;?>
           <?php }}?>

          </tbody>
          
        </table>
        <button class="btn btn-primary" name="update" onclick="return check()"> Update</button>
        </form>
</div><!--upper row -->


<?php 
include('../footer.php');
include('../subscription.php');
?>
<script type="text/javascript">
	function check()
	{
		a = confirm("Warning: This Action is Not Reversible");
		if(a==true)
		{
			//go on
			return true;
		}
		else
		{
			return false;
		}
	}

</script>

