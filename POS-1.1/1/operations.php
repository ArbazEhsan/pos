<?php
include('../connect.php');
include('../header.php');

$from = $_REQUEST['from'];
if(isset($_REQUEST['updateProduct']))
{

	
   $p_price= $_REQUEST["p_price"];
   $w_price= $_REQUEST["w_price"];
   $r_price= $_REQUEST["r_price"];
   $name   =$_REQUEST["name"];
   $size   =$_REQUEST["size"];
   $id     =$_REQUEST["id"];
   $minQ   =$_REQUEST['minQ'];
	if(mysqli_query($con,"UPDATE products SET p_price = '$p_price',w_price='$w_price',r_price = '$r_price',name='$name',minQ='$minQ',size='$size' WHERE id='$id'"))
	{

		header('location:accounts.php?msg=1');
	}
}

else if(isset($_REQUEST['updatevendor']))
{   
    $id         =$_REQUEST['id'];
    $name       =$_REQUEST['name'];
    $contact    =$_REQUEST['contact'];
    $phone1     =$_REQUEST['phone1'];
    $phone2     =$_REQUEST['phone2'];
    $phone3     =$_REQUEST['phone3'];
    $city       =$_REQUEST['city'];
    $address    =$_REQUEST['address'];

    if(mysqli_query($con,"UPDATE accounts SET name='$name',contact='$contact',phone1='$phone1',phone2='$phone2',phone3='$phone3',city='$city',address='$address' WHERE id='$id'"))

    {

      header('location:vendor.php?msg=4');
    }
}

else if(isset($_REQUEST['updateaccounts']))
{   
    $id         =$_REQUEST['id'];
    $name       =$_REQUEST['name'];
    $contact    =$_REQUEST['contact'];
    $phone1     =$_REQUEST['phone1'];
    $phone2     =$_REQUEST['phone2'];
    // $phone3     =$_REQUEST['phone3'];
    $city       =$_REQUEST['city'];
    $address    =$_REQUEST['address'];

    if(mysqli_query($con,"UPDATE accounts SET name='$name',contact='$contact',phone1='$phone1',phone2='$phone2',city='$city',address='$address' WHERE id='$id'"))

    {

      header('location:customer.php?msg=6');
    }

   

}
if($from=='1')
{  
	$id=$_REQUEST['id'];

	$result1=mysqli_query($con,"SELECT * FROM products WHERE id='$id'");
	$fetch1=mysqli_fetch_array($result1);


	?>
	<div class="container"> 
<h2>PRODUCT FORM</h2><hr>
<form  method="POST">  
<div class="row">
  <div class="col-md-6">
    <div class="row">
            <div class="col-md-8">
              <h5>Enter Product</h5>
              <input type="text" placeholder="Urdu+English" style="font-size: 20px;" name="name" value="<?php echo $fetch1['name'] ?>" class="form-control" required>
            </div>
            <div class="col-md-4">
              <h5>Liter/Gram</h5>
              <input type="number" name="size" value="<?php echo $fetch1['size'] ?>" class="form-control" required>
            </div>
          </div>    <br>
        <div class="row">
           <div class="col-md-6">
            <h4>Enter Purchase Price</h4>
            <div class="form-group">
              <input type="text"  class="form-control" value="<?php echo $fetch1['p_price'] ?>" name="p_price"> 
           </div>
          </div>
               <div class="col-md-6">
            <h4>Enter Whole Sale Price</h4>
            <div class="form-group">
              <input type="text" value="<?php echo $fetch1['w_price'] ?>" class="form-control" name="w_price">
           </div>
          </div>
          
        </div>
        <div class="row">
          <div class="col-md-6">
              <h4>Enter Retail Price</h4>
            <div class="form-group">
              <input type="text" class="form-control" value="<?php echo $fetch1['r_price'] ?>" id="whole" name="r_price">
           </div>
          </div>
          <div class="col-md-6">
            <h4>Minimum Qty</h4>
            <input type="text" class="form-control" value="<?php echo $fetch1['minQ'] ?>" id="whole" name="minQ" required>
          </div>
          
        </div>  
        <div class="row">
          <div class="col-md-12">
            <button name="updateProduct" class="btn btn-info btn-block">Update</button>
          </div>
        </div>
        </form>
  </div>
<?php }

else if($from=='2')
{ $id=$_REQUEST['id'];

 /*if(mysqli_query($con,"DELETE FROM products WHERE id='$id'"))
 {

 	header('location:accounts.php?msg=2');
 }*/
 $result = mysqli_query($con,"SELECT active FROM products WHERE id='$id'");
 $fetch  = mysqli_fetch_array($result);
 if ($fetch['active']=='1') {
    mysqli_query($con,"UPDATE products SET active='0' WHERE id='$id'");
    header('location:accounts.php?msg=2');
 }
 else{
    mysqli_query($con,"UPDATE products SET active='1' WHERE id='$id'");
    header('location:accounts.php?msg=2');
 }


}


else if($from=='3')
{ 
 
 
   $id=$_REQUEST['id'];
   $result3=mysqli_query($con,"SELECT * FROM accounts WHERE id='$id'");
   $fetch3=mysqli_fetch_array($result3);
   if ($fetch3['active']=='1') {
            mysqli_query($con,"UPDATE accounts SET active='0' WHERE id='$id'");
             header('location:vendor.php?msg=5');
           
    }
    else{
            mysqli_query($con,"UPDATE accounts SET active='1' WHERE id='$id'"); 
             header('location:vendor.php?msg=5');     
    }
   

 }

 else if($from=='4')
 {
   $id=$_REQUEST['id'];

  $result2=mysqli_query($con,"SELECT * FROM accounts WHERE id='$id'");
  $fetch2=mysqli_fetch_array($result2);


  ?>
 <div class="container">
  <center><h1>Add Vendor</h1></center><hr>
 <form method="POST" >
  <div class="row">
    <div class="col-md-4">
      <input type="text" name="name" value="<?php echo $fetch2['name']; ?>" placeholder="Enter Name" class="form-control" required>
    </div>
    <div class="col-md-4">
      <input type="text" name="contact" value="<?php echo $fetch2['contact']; ?>" placeholder="Enter Contact Person" class="form-control" required>
    </div>
  </div><br>

  <div class="row">
    <div class="col-md-4">
      <input type="text" name="phone1" value="<?php echo $fetch2['phone1']; ?>" placeholder="Enter phone#1" class="form-control">
    </div>
    <div class="col-md-4">
      <input type="text" name="phone2" value="<?php echo $fetch2['phone2']; ?>" placeholder="Enter phone#2" class="form-control">
    </div>
  </div><br>


  <div class="row">
    <div class="col-md-4">
      <input type="text" name="phone3" value="<?php echo $fetch2['phone3']; ?>" placeholder="Enter phone#3" class="form-control">
    </div>
    <div class="col-md-4">
      <input type="text" name="city" value="<?php echo $fetch2['city']; ?>" placeholder="City" class="form-control">
    </div>
    
  </div><br>



  <div class="row">
    <div class="col-md-4">
      <input type="text" name="address" value="<?php echo $fetch2['address']; ?>" placeholder="Address" class="form-control">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
    </div>
    
  </div><br>
  <div class="row"> 
    <div class="col-md-4">
  <button class="btn btn-primary" class="form-control" name="updatevendor"> Update</button></div>
  </div><hr>
  </form>
  

</div>

<?php }

else if($from=='5')
{ 
 
 
   $id=$_REQUEST['id'];
   $i=0;
   $result3=mysqli_query($con,"SELECT * FROM accounts WHERE id='$id'");
   $fetch3=mysqli_fetch_array($result3);
   if ($fetch3['active']=='1') {
            mysqli_query($con,"UPDATE accounts SET active='0' WHERE id='$id'");
             header('location:customer.php?msg=5');
           
    }
    else{
            mysqli_query($con,"UPDATE accounts SET active='1' WHERE id='$id'"); 
             header('location:customer.php?msg=5');     
    }
   
     


 }

  else if($from=='6')
 {
   $id=$_REQUEST['id'];

  $result3=mysqli_query($con,"SELECT * FROM accounts WHERE id='$id'");
  $fetch3=mysqli_fetch_array($result3);


  ?>
 <div class="container">
  <center><h1>Update Accounts</h1></center><hr>
 <form method="POST" >
  <div class="row">
    <div class="col-md-4">
      <select class="form-control" name="type" required>
        <option disabled>-- Select Type --</option>
        <?php 
          $type_info = array('Asset','Capital','Customer','Liability','Vendor');
          for ($i=0;$i<count($type_info);$i++) { 
            if ($type_info[$i]==$fetch3['type']) {
              echo "<option selected>".$type_info[$i]."</option>";
            }
            else {
              echo "<option>".$type_info[$i]."</option>";
            }
          }
        ?>
      </select>
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-4">
      <input type="text" name="name" value="<?php echo $fetch3['name']; ?>" placeholder="Enter Name" class="form-control" required>
    </div>
    <div class="col-md-4">
      <input type="number" name="contact" value="<?php echo $fetch3['contact']; ?>" placeholder="Enter Contact Person" class="form-control">
    </div>
  </div><br>

  <div class="row">
    <div class="col-md-4">
      <input type="number" name="phone1" value="<?php echo $fetch3['phone1']; ?>" placeholder="Enter phone#1" class="form-control">
    </div>
    <div class="col-md-4">
      <input type="number" name="phone2" value="<?php echo $fetch3['phone2']; ?>" placeholder="Enter phone#2" class="form-control">
    </div>
  </div><br>


  <div class="row">
    <!-- <div class="col-md-4">
      <input type="text" name="phone3" value="<?php echo $fetch3['phone3']; ?>" placeholder="Enter phone#3" class="form-control">
    </div> -->
    <div class="col-md-4">
      <input type="text" name="city" value="<?php echo $fetch3['city']; ?>" placeholder="City" class="form-control">
    </div>
    <div class="col-md-4">
      <input type="text" name="address" value="<?php echo $fetch3['address']; ?>" placeholder="Address" class="form-control">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
    </div>
  </div><br>



  <!-- <div class="row">
    
    
  </div><br> -->
  <div class="row"> 
    <div class="col-md-4">
  <button class="btn btn-primary" class="form-control" name="updateaccounts"> Update </button></div>
  </div><hr>
  </form>
  

</div>

<?php }

else if($from=='7')
{ 
   $id=$_REQUEST['id'];
   $result3=mysqli_query($con,"SELECT * FROM accounts WHERE id='$id'");
   $fetch3=mysqli_fetch_array($result3);   
   mysqli_query($con,"UPDATE accounts SET active='1' WHERE active = '11'");
   mysqli_query($con,"UPDATE accounts SET active='11' WHERE id='$id'");
   header('location:customer.php');

   
 }
 else if($from=='8')
{ 
 
 
   $id=$_REQUEST['id'];
   $result3=mysqli_query($con,"SELECT * FROM accounts WHERE id='$id'");
   $fetch3=mysqli_fetch_array($result3);
   if ($fetch3['active']=='1') {
            mysqli_query($con,"UPDATE accounts SET active='11' WHERE id='$id'");
            header('location:vendor.php?msg=5');
           
    }
    elseif($fetch3['active']=='11'){
            mysqli_query($con,"UPDATE accounts SET active='1' WHERE id='$id'"); 
            header('location:vendor.php?msg=5');     
    }
 }
?>