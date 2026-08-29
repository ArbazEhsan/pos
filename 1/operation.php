<?php 
include ('../connect.php');
$from = $_REQUEST['from'];
$operation = $_REQUEST['operation'];

/* product start */
if($from=='product' && $operation=='insert'){

	$name = $_POST['pname'];
	$size = $_POST['size'];
	$pprice = $_POST['pprice'];
	$wprice = $_POST['wprice'];
	$rprice = $_POST['rprice'];
	$qty = $_POST['qty'];
	// $location = $_POST['location'];
	mysqli_set_charset($con,'utf8');
	mysqli_query($con,"INSERT INTO products(name,size,p_price,w_price,r_price,shQty,sh_status,active,reorder) VALUES('$name','$size','$pprice','$wprice','$rprice','$qty','0','1','0')");

	if (mysqli_insert_id($con)>0) {
		echo "1";
	}
	else {
		echo "0";
	}
}

if($from=='product' && $operation=='show'){
	$num = $_REQUEST['num'];
	$data = ''; $counter = $totalRow = 0;
	mysqli_set_charset($con,'utf8');
	$result=mysqli_query($con,"SELECT * FROM products");
	$totalRow = mysqli_num_rows($result);
	while($fetch=mysqli_fetch_array($result)){
	$counter++;
	if ($fetch['active']=='1') {
	  $text = 'Inactive';
	  $btn = 'btn-danger';
	}
	else{
	  $text = 'Active';
	  $btn = 'btn-success';
	}
	$data.='<tr>
				<td>'.$fetch['id'].'</td>
				<td>'.$fetch['name'].'</td>
				<td>'.$fetch['size'].'</td>
				<td>'.$fetch['p_price'].'</td>
				<td>'.$fetch['w_price'].'</td>
				<td>'.$fetch['r_price'].'</td>
				<td>'.$fetch['shQty'].'</td>
				<td><div onclick="status('.$fetch['id'].','.$fetch['active'].')" class="btn '.$btn.'">'.$text.'</div>
	                <div onclick="edit('.$fetch['id'].')" class="btn btn-primary">Edit</div>
	            </td>
	        </tr>';
	if ($num==$counter) {
		break;
	}

	}
	echo $data."|".$totalRow;
}

if($from=='product' && $operation=='status'){

	$id = $_REQUEST['id'];
	$status = $_REQUEST['status'];
	$st = 1;
	if ($status=='1') {
		$st = 0;
	}
 	mysqli_query($con,"UPDATE products SET active='$st' WHERE id='$id'");
 	echo "1";
}

if($from=='product' && $operation=='edit'){
	$id = $_REQUEST['id'];
	mysqli_set_charset($con,'utf8');
	$result=mysqli_query($con,"SELECT * FROM products WHERE id='$id'");
	$fetch=mysqli_fetch_array($result);

	echo $fetch['id']."|".$fetch['name']."|".$fetch['size']."|".$fetch['p_price']."|".$fetch['w_price']."|".$fetch['r_price']."|".$fetch['shQty'];
}

if($from=='product' && $operation=='update'){

	$id = $_POST['pid'];
	$name = $_POST['upname'];
	$size = $_POST['usize'];
	$pprice = $_POST['upprice'];
	$wprice = $_POST['uwprice'];
	$rprice = $_POST['urprice'];
	$qty = $_POST['uqty'];

 	mysqli_query($con,"UPDATE `products` SET `name`='$name',`size`='$size',`p_price`='$pprice',`w_price`='$wprice',`r_price`='$rprice',`shQty`='$qty' WHERE id='$id'");

 	echo "1";
}

if($from=='countsheet' && $operation=='show'){
	$num = $_REQUEST['num'];
	$data = ''; $counter = $totalRow = 0;
	mysqli_set_charset($con,'utf8');
	$result=mysqli_query($con,"SELECT * FROM `products` WHERE id LIMIT $num");
	$totalRow = mysqli_num_rows($result);
	while($fetch=mysqli_fetch_array($result)){
	$data.='<tr>
				<td>'.$fetch['id'].'</td>
				<td>'.$fetch['name'].'</td>
				<td>'.$fetch['size'].'</td>
				<td>'.$fetch['p_price'].'</td>
				<td>'.$fetch['w_price'].'</td>
				<td>'.$fetch['r_price'].'</td>
				<td><input type="number" name="qty[]" class="form-control" value="'.$fetch['shQty'].'"/><input type="hidden" name="pid[]" value="'.$fetch['id'].'"/></td>
	        </tr>';
	}
	echo $data."|".$totalRow;
}

if($from=='countsheet' && $operation=='update'){

	$id = $_POST['pid'];
	$qty = $_POST['qty'];

	foreach ($id as $key => $value) {
		mysqli_query($con,"UPDATE `products` SET `shQty`='$qty[$key]' WHERE id='$id[$key]'");
	}
 	echo "1";
}

if($from=='bulkpriceEditing' && $operation=='show'){
	$num = $_REQUEST['num'];
	$data = ''; $counter = $totalRow = 0;
	mysqli_set_charset($con,'utf8');
	$result=mysqli_query($con,"SELECT * FROM `products` WHERE id LIMIT $num");
	$totalRow = mysqli_num_rows($result);
	while($fetch=mysqli_fetch_array($result)){
	$data.='<tr>
				<td>'.$fetch['id'].'</td>
				<td>'.$fetch['name'].'</td>
				<td>'.$fetch['size'].'</td>
				<td>'.$fetch['shQty'].'</td>
				<td><input type="number" name="pprice[]" class="form-control" value="'.$fetch['p_price'].'"/></td>
				<td><input type="number" name="wprice[]" class="form-control" value="'.$fetch['w_price'].'"/></td>
				<td><input type="number" name="rprice[]" class="form-control" value="'.$fetch['r_price'].'"/><input type="hidden" name="pid[]" value="'.$fetch['id'].'"/></td>
	        </tr>';
	}
	echo $data."|".$totalRow;
}

if($from=='bulkpriceEditing' && $operation=='update'){
	
	$id = $_POST['pid'];
	$pprice = $_POST['pprice'];
	$wprice = $_POST['wprice'];
	$rprice = $_POST['rprice'];

	foreach ($id as $key => $value) {
		mysqli_query($con,"UPDATE `products` SET `p_price`='$pprice[$key]',`w_price`='$wprice[$key]',`r_price`='$rprice[$key]' WHERE id='$id[$key]'");
	}
 	echo "1";
}
/* product end */

/* accounts start */

if($from=='accounts' && $operation=='insert'){

    $type = $_POST['type'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $phone1 = $_POST['phone1'];
    $phone2 = $_POST['phone2'];
    $city = $_POST['city'];
    $address = $_POST['address'];

	mysqli_query($con,"INSERT INTO accounts (name,contact,phone1,phone2,city,type,address,active) VALUES('$name','$contact','$phone1','$phone2','$city','$type','$address','1')");

	if (mysqli_insert_id($con)>0) {
		echo "1";
	}
	else {
		echo "0";
	}
}

if($from=='accounts' && $operation=='show'){
	$num = $_REQUEST['num'];
	$data = ''; $counter = $totalRow = 0;
	mysqli_set_charset($con,'utf8');
	$result=mysqli_query($con,"SELECT * FROM accounts ORDER BY id");
	$totalRow = mysqli_num_rows($result);
	while($fetch=mysqli_fetch_array($result)){
	$counter++;
	if ($fetch['active']=='1') {
	  $text = 'Inactive';
	  $btn  = 'btn-danger';
	  $btn1 = 'btn-default';
	  $default = 'Set as Default';
	}

	elseif($fetch['active']=='0'){
	  $text = 'Active';
	  $btn  = 'btn-success';
	  $btn1 = 'btn-default';
	  $default = 'Set as Default';
	}
    elseif ($fetch['active']=='11') {
    	$btn1  = 'btn-success';
    	$text = 'Inactive';
        $btn  = 'btn-danger';
        $default = 'Default';
    }
	$data.='<tr>
				<td>'.$fetch['type'].'</td>
				<td>'.$fetch['id'].'</td>
				<td>'.$fetch['name'].'</td>
				<td>'.$fetch['contact'].'</td>
				<td>'.$fetch['phone1'].'</td>
				<td>'.$fetch['phone2'].'</td>
				<td>'.$fetch['city'].'</td>
				<td>'.$fetch['address'].'</td>
				<td><div class="dropdown">
         		 	<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Action
         		 		<span class="caret"></span>
         		 	</button>
         		 	<ul class="dropdown-menu">
         		 		<li><a onclick="edit('.$fetch['id'].')">Edit</a></li>
     		 			<li><a onclick="setDefault('.$fetch['id'].')">'.$default.'</a></li>
     		 		</ul>
         		 </div>
				</td>
				<td><div onclick="status('.$fetch['id'].','.$fetch['active'].')" class="btn '.$btn.'">'.$text.'</div>
	            </td>
	        </tr>';
	if ($num==$counter) {
		break;
	}

	}
	echo $data."|".$totalRow;
}

if($from=='accounts' && $operation=='status'){

	$id = $_REQUEST['id'];
	$status = $_REQUEST['status'];
	$st = 1;
	if ($status=='1') {
		$st = 0;
	}
 	mysqli_query($con,"UPDATE accounts SET active='$st' WHERE id='$id'");
 	echo "1";
}

if($from=='accounts' && $operation=='default'){

   $id = $_REQUEST['id']; 
   mysqli_query($con,"UPDATE accounts SET active='1' WHERE active = '11'");
   mysqli_query($con,"UPDATE accounts SET active='11' WHERE id='$id'");
   echo "1";
}

if($from=='accounts' && $operation=='edit'){
	$id = $_REQUEST['id'];
	mysqli_set_charset($con,'utf8');
	$result=mysqli_query($con,"SELECT * FROM accounts WHERE id='$id'");
	$fetch=mysqli_fetch_array($result);

	echo $fetch['id']."|".$fetch['type']."|".$fetch['name']."|".$fetch['contact']."|".$fetch['phone1']."|".$fetch['phone2']."|".$fetch['city']."|".$fetch['address'];
}

if($from=='accounts' && $operation=='update'){

	$id = $_POST['pid'];
    $name = $_POST['uname'];
    $contact = $_POST['ucontact'];
    $phone1 = $_POST['uphone1'];
    $phone2 = $_POST['uphone2'];
    $city = $_POST['ucity'];
    $address = $_POST['uaddress'];

 	mysqli_query($con,"UPDATE accounts SET name='$name',contact='$contact',phone1='$phone1',phone2='$phone2',city='$city',address='$address' WHERE id='$id'");

 	echo "1";
}
/* accounts end */
?>