<?php 
include ('../connect.php');
$from = $_REQUEST['from'];
$operation = $_REQUEST['operation'];

/* category start */
if($from=='category' && $operation=='insert'){

	$name = $_POST['pname'];

	$target="../assets/img/" .basename($_FILES['myFile']['name'] );
	$fname=$_FILES['myFile']['name'];
	if($fname!=''){
		if (move_uploaded_file($_FILES['myFile']['tmp_name'] , $target)) {
			$msg="file is uploaded";
		} else{
			$msg="file is not uploaded";
		}
	}
	
	mysqli_set_charset($con,'utf8');
	mysqli_query($con,"INSERT INTO category(name,image_url,status) VALUES('$name','$fname','1')");

	if (mysqli_insert_id($con)>0) {
		echo "1";
	}
	else {
		echo "0";
	}
}

if($from=='category' && $operation=='show'){
	$num = $_REQUEST['num'];
	$data = ''; $counter = $totalRow = 0;
	mysqli_set_charset($con,'utf8');
	$result=mysqli_query($con,"SELECT * FROM category");
	$totalRow = mysqli_num_rows($result);
	while($fetch=mysqli_fetch_array($result)){
	$counter++;
	if ($fetch['status']=='1') {
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
				<td><div onclick="status('.$fetch['id'].','.$fetch['status'].')" class="btn '.$btn.'">'.$text.'</div>
	                <div onclick="edit('.$fetch['id'].')" class="btn btn-primary">Edit</div>
	            </td>
	        </tr>';
	if ($num==$counter) {
		break;
	}

	}
	echo $data."|".$totalRow;
}

if($from=='category' && $operation=='status'){

	$id = $_REQUEST['id'];
	$status = $_REQUEST['status'];
	$st = 1;
	if ($status=='1') {
		$st = 0;
	}
 	mysqli_query($con,"UPDATE category SET status='$st' WHERE id='$id'");
 	echo "1";
}

if($from=='category' && $operation=='edit'){
	$id = $_REQUEST['id'];
	mysqli_set_charset($con,'utf8');
	$result=mysqli_query($con,"SELECT * FROM category WHERE id='$id'");
	$fetch=mysqli_fetch_array($result);

	echo $fetch['id']."|".$fetch['name'];
}

if($from=='category' && $operation=='update'){

	$id = $_POST['pid'];
	$name = $_POST['upname'];

	$target="../assets/img/" .basename($_FILES['myFile']['name'] );
	$fname=$_FILES['myFile']['name'];

	if($fname!=''){
		if (move_uploaded_file($_FILES['myFile']['tmp_name'] , $target)) {
			$msg="file is uploaded";
		} else{
			$msg="file is not uploaded";
		}
	}
	

 	mysqli_query($con,"UPDATE `products` SET `name`='$name', `image_url`='$fname' WHERE id='$id'");

 	echo "1";
}

/* category end */

/* deal start */

if($from=='deal' && $operation=='insert'){
	
	$dname = $_POST['dname'];
	$dprice = $_POST['dprice'];
	$itemId = $_POST['itemId'];
	$qty = $_POST['qty'];

	mysqli_query($con,"INSERT INTO `dcounter`(`dealName`, `dealPrice`, `status`) VALUES ('$dname','$dprice','1')");
 	$master=mysqli_insert_id($con);

 	foreach ($itemId  as $key => $value) {

 		mysqli_query($con,"INSERT INTO `deal`(`deal_id`, `items`, `qty`, `status`) VALUES ('$master','$itemId[$key]','$qty[$key]','1')");
 	}
	echo 1;
}

if($from=='deal' && $operation=='show'){
	$num = $_REQUEST['num'];
	$data = ''; $counter = $totalRow = 0;
	mysqli_set_charset($con,'utf8');
	$result=mysqli_query($con,"SELECT * FROM dcounter");
	$totalRow = mysqli_num_rows($result);
	while($fetch=mysqli_fetch_array($result)){
	$counter++;
	if ($fetch['status']=='1') {
	  $text = 'Inactive';
	  $btn = 'btn-danger';
	}
	else{
	  $text = 'Active';
	  $btn = 'btn-success';
	}
	$items ='';
	$result2=mysqli_query($con,"SELECT category.name FROM category INNER JOIN deal ON category.id=deal.items WHERE deal.deal_id='".$fetch['id']."'");
	while($fetch2=mysqli_fetch_array($result2)){
		$items .= $fetch2['name'].", ";
	}
	$data.='<tr>
				<td>'.$fetch['id'].'</td>
				<td>'.$fetch['dealName'].'</td>
				<td>'.$fetch['dealPrice'].'</td>
				<td>'.$items.'</td>
				<td><div onclick="status('.$fetch['id'].','.$fetch['status'].')" class="btn '.$btn.'">'.$text.'</div>
	                <div onclick="del('.$fetch['id'].')" class="btn btn-primary">Delete</div>
	            </td>
	        </tr>';
	if ($num==$counter) {
		break;
	}

	}
	echo $data."|".$totalRow;
}

if($from=='deal' && $operation=='status'){

	$id = $_REQUEST['id'];
	$status = $_REQUEST['status'];
	$st = 1;
	if ($status=='1') {
		$st = 0;
	}
 	mysqli_query($con,"UPDATE dcounter SET status='$st' WHERE id='$id'");
 	echo "1";
}

if($from=='deal' && $operation=='del'){

	$id = $_REQUEST['id'];
 	mysqli_query($con,"DELETE FROM dcounter WHERE id='$id'");
 	echo "1";
}

if($from=='deal' && $operation=='edit'){
	$id = $_REQUEST['id'];
	mysqli_set_charset($con,'utf8');
	$result=mysqli_query($con,"SELECT * FROM category WHERE id='$id'");
	$fetch=mysqli_fetch_array($result);

	echo $fetch['id']."|".$fetch['name'];
}

if($from=='deal' && $operation=='update'){

	$id = $_POST['pid'];
	$name = $_POST['upname'];

	$target="../assets/img/" .basename($_FILES['myFile']['name'] );
	$fname=$_FILES['myFile']['name'];

	if($fname!=''){
		if (move_uploaded_file($_FILES['myFile']['tmp_name'] , $target)) {
			$msg="file is uploaded";
		} else{
			$msg="file is not uploaded";
		}
	}
	

 	mysqli_query($con,"UPDATE `products` SET `name`='$name', `image_url`='$fname' WHERE id='$id'");

 	echo "1";
}


if($from=='deal' && $operation=='get'){
	$id = $_GET['id'];
	$data = '';
	$result = mysqli_query($con,"SELECT * FROM products WHERE cat_id='$id' AND active!=0 ORDER BY name");
	while($fetch = mysqli_fetch_array($result)){
	$data.='<option value='.$fetch['id'].'>'.$fetch['name'].'</option>';
	} 
	echo $data;
}

if($from=='deal' && $operation=='getInfo'){
	$id = $_REQUEST['id1'];
	$result = mysqli_query($con,"Select name FROM category WHERE id='$id'");
	$fetch = mysqli_fetch_array($result);
	echo $fetch['name'];
}


/* deal end */


/* product start */
if($from=='product' && $operation=='insert'){

	$catId = $_POST['catName'];
	$name = $_POST['pname'];
	$size = $_POST['size'];
	$pprice = $_POST['pprice'];
	$wprice = $_POST['wprice'];
	$rprice = $_POST['rprice'];
	$qty = $_POST['qty'];

	$target="../assets/img/" .basename($_FILES['myFile']['name'] );
	$fname=$_FILES['myFile']['name'];
	if($fname!=''){
		if (move_uploaded_file($_FILES['myFile']['tmp_name'] , $target)) {
			$msg="file is uploaded";
		} else{
			$msg="file is not uploaded";
		}
	}
	
	
	// $location = $_POST['location'];
	mysqli_set_charset($con,'utf8');
	mysqli_query($con,"INSERT INTO products(cat_id,name,size,p_price,w_price,r_price,shQty,sh_status,active,reorder,image_url) VALUES('$catId','$name','$size','$pprice','$wprice','$rprice','$qty','0','1','0','$fname')");

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
	$result=mysqli_query($con,"SELECT * FROM products WHERE cat_id!='14'");
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

if($from=='stock' && $operation=='show'){
	$num = $_REQUEST['num'];
	$data = ''; $counter = $totalRow = 0;
	mysqli_set_charset($con,'utf8');
	$result=mysqli_query($con,"SELECT * FROM products WHERE cat_id='14'");
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
	$catId = $_POST['ucatName'];
	$name = $_POST['upname'];
	$size = $_POST['usize'];
	$pprice = $_POST['upprice'];
	$wprice = $_POST['uwprice'];
	$rprice = $_POST['urprice'];
	$qty = $_POST['uqty'];

	$target="../assets/img/" .basename($_FILES['myFile']['name'] );
	$fname=$_FILES['myFile']['name'];

	if($fname!=''){
		if (move_uploaded_file($_FILES['myFile']['tmp_name'] , $target)) {
			$msg="file is uploaded";
		} else{
			$msg="file is not uploaded";
		}
	}
	

 	mysqli_query($con,"UPDATE `products` SET `cat_id`='$catId', `name`='$name',`size`='$size',`p_price`='$pprice',`w_price`='$wprice',`r_price`='$rprice',`shQty`='$qty', `image_url`='$fname' WHERE id='$id'");

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
	$designation = $_POST['designation'];
	$salary = $_POST['salary'];
    $contact = $_POST['contact'];
    $phone1 = $_POST['phone1'];
    $phone2 = $_POST['phone2'];
    $city = $_POST['city'];
    $address = $_POST['address'];

	mysqli_query($con,"INSERT INTO accounts (name,designation,salary,contact,phone1,phone2,city,type,address,active) VALUES('$name','$designation','$salary','$contact','$phone1','$phone2','$city','$type','$address','1')");

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
				<td>'.$fetch['designation'].'</td>
				<td>'.number_format($fetch['salary'],0).'</td>
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

	echo $fetch['id']."|".$fetch['type']."|".$fetch['name']."|".$fetch['contact']."|".$fetch['phone1']."|".$fetch['phone2']."|".$fetch['city']."|".$fetch['address']."|".$fetch['designation']."|".$fetch['salary'];
}

if($from=='accounts' && $operation=='update'){

	$id = $_POST['pid'];
    $name = $_POST['uname'];
    $udesignation = $_POST['udesignation'];
    $usalary = $_POST['usalary'];
    $contact = $_POST['ucontact'];
    $phone1 = $_POST['uphone1'];
    $phone2 = $_POST['uphone2'];
    $city = $_POST['ucity'];
    $address = $_POST['uaddress'];

 	mysqli_query($con,"UPDATE accounts SET name='$name',designation='$udesignation',salary='$usalary',contact='$contact',phone1='$phone1',phone2='$phone2',city='$city',address='$address' WHERE id='$id'");

 	echo "1";
}
/* accounts end */

/* salary start */

if($from=='salary' && $operation=='insert'){

	$day = $_POST['day'];
	$billNo = $_POST['vno'];
	$tamnt = $_POST['tamnt'];
	$customer = $_POST['customer'];
	$remarks = $_POST['remarks'];
	$amount = $_POST['amount'];

	mysqli_query($con,"INSERT INTO `slrcounter`(`day`, `voucher_no`, `total_amnt`, `type`) VALUES ('$day','$billNo','$tamnt','CR')");
	$id = mysqli_insert_id($con);

	foreach ($customer as $key => $value) {

		mysqli_query($con,"INSERT INTO salary (day, account_id, amount, remarks)VALUES('$day','$customer[$key]','$amount[$key]','$remarks[$key]')");

		mysqli_query($con,"INSERT INTO trans (day, account_id, amount, type, remarks, bill_no, status)VALUES('$day','$customer[$key]','$amount[$key]','CO','$remarks[$key]','$id','1')");
		$idd = mysqli_insert_id($con);
		mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$amount[$key]','$day','CO','$customer[$key]','$idd','1')");
	}
	echo $id;
}

if($from=='viewCashin' && $operation=='show'){
	$num = $_REQUEST['num'];
	$data = ''; $counter = $totalRow = 0;
	$result = mysqli_query($con,"SELECT * FROM tcounter WHERE type='CR' ORDER BY day DESC");
	$totalRow = mysqli_num_rows($result);
	while($fetch = mysqli_fetch_array($result)){
		$counter++;
		$data.='<tr>
				<td>'.date('d-M-Y', strtotime($fetch['day'])).'</td>
				<td>'.$fetch['voucher_no'].'</td>
				<td>'.$fetch['total_amnt'].'</td>
				<td><button onclick="view('.$fetch['id'].')" class="btn btn-primary">View Invoices</button> <a href="editCash.php?id='.$fetch['id'].'&vno='.$fetch['voucher_no'].'&date='.$fetch['day'].'&total='.$fetch['total_amnt'].'&type=CR" class="btn btn-warning">Edit</a> <button onclick="del('.$fetch['id'].')" class="btn btn-danger">Delete</button>
	            </td>
		        </tr>';
		if ($num==$counter) {
			break;
		}
	}
	echo $data."|".$totalRow;
}

if($from=='viewCashin' && $operation=='del'){
	$id = $_REQUEST['id'];
	$result = mysqli_query($con,"SELECT id FROM trans WHERE bill_no='$id'");
	$fetch = mysqli_fetch_array($result);
	mysqli_query($con,"DELETE FROM ledgers WHERE trans_id='".$fetch['id']."'");
	mysqli_query($con,"DELETE FROM trans WHERE bill_no='$id'");
	mysqli_query($con,"DELETE FROM tcounter WHERE id='$id'");

	echo "1";
}
/* salary end */
?>