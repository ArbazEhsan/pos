<?php
include("../connect.php");include("../converter.php");
$from = $_REQUEST['from'];
if($from == 'loadS')
{ 
	// $barcode = $_REQUEST['barcode'];
	//$cust    = $_REQUEST['customer'];
	$id = $_REQUEST['id'];
	//$customer= getCustomerId($cust);
	$sql = "SELECT sale.*, products.name FROM sale INNER JOIN products ON sale.barcode=products.id WHERE sale_No='$id'";
	$result = mysqli_query($con,$sql);
	$fetch  = mysqli_fetch_array($result);
	if ($fetch['price']>0) {
		echo $fetch['price'];
	}
	else {
		echo "0/";
	}
}
elseif($from == 'loadp')
{ 	
	// $barcode = $_REQUEST['barcode'];
	//$cust    = $_REQUEST['customer'];
	$id    = $_REQUEST['id'];
	//$customer= getCustomerId($cust);
	$sql = "SELECT * FROM psale WHERE sale_No='$id'";
	$result = mysqli_query($con,$sql);
	$fetch  = mysqli_fetch_array($result);
	$previous = $fetch['price'];
	if ($previous>0) {
		echo $previous;
	}
	else {
		echo "0";
	}
}
elseif($from == 'search')
{
	$sale_No=0;$table = ''; $counter = 0;
	$cName   = $_REQUEST['customer'];
	$result3 = mysqli_query($con,"SELECT * FROM customer WHERE name = '$cName'");
	$fetch3  = mysqli_fetch_array($result3);
	$cId     = $fetch3['id'];

	$result4 = mysqli_query($con,"SELECT * FROM scounter WHERE customer = '$cId'");
	if(mysqli_num_rows($result4)>0)
	{
		 $table .= '<thead>
                 <th>Sr #</th>
                    <th>Item ID</th>
                    <th>Date</th>
                    <th>Sale_No</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Final</th>
                    <th>List</th>
                  </tr>
                </thead>
                <tfoot>
                   <th>Sr #</th>
                    <th>Item ID</th>
                    <th>Date</th>
                    <th>Sale_No</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Final</th>
                    <th>List</th>
                    
                  </tr>
                </tfoot>
                <tbody>';
	    while($fetch4 = mysqli_fetch_array($result4))
			{
				$sale_No=$fetch4['id'];
			
		
		
		$result1 = mysqli_query($con,"SELECT * FROM sale WHERE sale_No='$sale_No'");
		while($fetch1=mysqli_fetch_array($result1))
		{ 	$counter++;
			$cd = $fetch1["barcode"];
			$result2 = mysqli_query($con,"SELECT * FROM products WHERE id='$cd'");
			$fetch2 = mysqli_fetch_array($result2);
			$name = $fetch2['name'];
			 $table .='<tr id="'.$fetch1["id"].'">
                    <td>'.$counter.'</td>
                    <td><input style="width:200px;" readonly value='.$fetch1["barcode"].' class="form-control productcode"></td>
                    <td>'.$fetch1["sale_day"].'</td>
                    <td>'.$fetch1["sale_No"].'</td>
                    <td>'.$fetch2["name"].'</td>
                    <td class="adBtn">'.$fetch1["qty"].'</td>
                    <td>'.$fetch1["price"].'</td>
                    <td class="adBtn">'.$fetch1["finalValue"].'</td>                   
                    <td class="adBtn"><div class="btn btn-primary" id="'.$fetch1["id"].'" onclick="
                   addToList(this.id)">Add to List</div></td>
                   </tr>';
                  
          } 
          $table .= '</tbody>';
        }
		echo $table;
		}
	else
	{
		echo "No detail found against invoice number"." (".$sale_No.")";
	}

}
elseif($from == 'save')
{
	$day		  = $_REQUEST['day'];
	$cust 	      = $_REQUEST['cName'];
	$referal      = $_REQUEST['remarks'];
	$code 		  = $_REQUEST['saleNo'];
	$barcode      = $_REQUEST['barcode'];
	$qty          = $_REQUEST['qty'];
	$amount       = $_REQUEST['amnt'];
	$gross		  = $_REQUEST['gross'];
	$amntpaid     = $_REQUEST['amntpaid'];
	$remaining 	  = $_REQUEST['remaining'];
	$result6      = mysqli_query($con,"SELECT * FROM accounts WHERE name='$cust'");
	$fetch6       = mysqli_fetch_array($result6);
	$customer	  = $fetch6['id'];
	
	mysqli_query($con,"UPDATE scounter SET type='RS' WHERE id='$code'");
	
	mysqli_query($con,"INSERT INTO rscounter(day,scounter_id,customer,ref) VALUES('$day','$code','$customer','$referal')");
	$id = mysqli_insert_id($con);

	foreach($barcode as $key => $value) {
		mysqli_query($con,"INSERT INTO returnsale(barcode,qty,price,sale_No,total_Amnt,amnt_Paid,remaining)VALUES('$barcode[$key]','$qty[$key]','$amount[$key]','$id','$gross','$amntpaid','$remaining')");		
		mysqli_query($con,"UPDATE products SET p_qty = p_qty + '$qty[$key]' WHERE id='$barcode[$key]'");
	}
	mysqli_query($con,"INSERT INTO `trans`(`day`, `account_id`, `invoice_id`, `amount`, `type`, `remarks`, `status`) VALUES('$day','$customer','$id','$amntpaid','RS','$referal','1')");
	$id1=mysqli_insert_id($con);

	mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`)VALUES('$gross','$day','RS','$customer','$id1','1')");

	if ($amntpaid>0) {
		mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`)VALUES('$amntpaid','$day','RS','$customer','$id1','1')");
	}
	echo $id;

}
elseif($from == 'savep')
{
	
	$day		  = $_REQUEST['day'];
	$cust 	      = $_REQUEST['cName'];
	$referal      = $_REQUEST['remarks'];
	$code 		  = $_REQUEST['saleNo'];
	$barcode      = $_REQUEST['barcode'];
	$qty          = $_REQUEST['qty'];
	$amount       = $_REQUEST['amnt'];
	$gross		  = $_REQUEST['gross'];
	$amntpaid     = $_REQUEST['amntpaid'];
	$remaining 	  = $_REQUEST['remaining'];
	$result6      = mysqli_query($con,"SELECT * FROM accounts WHERE name='$cust'");
	$fetch6       = mysqli_fetch_array($result6);
	$customer	  = $fetch6['id'];
	
	mysqli_query($con,"UPDATE pcounter SET type='RP' WHERE id='$code'");

 	mysqli_query($con,"INSERT INTO rpcounter(day,pcounter_id,customer,ref) VALUES('$day','$code','$customer','$referal')");
	$id = mysqli_insert_id($con);
	foreach($barcode as $key => $value) {
		mysqli_query($con,"INSERT INTO returnsale(barcode,qty,price,pur_No,total_Amnt,amnt_Paid,remaining)VALUES('$barcode[$key]','$qty[$key]','$amount[$key]','$id','$gross','$amntpaid','$remaining')");		
		mysqli_query($con,"UPDATE products SET p_qty = p_qty - '$qty[$key]' WHERE id='$barcode[$key]'");
	}

	mysqli_query($con,"INSERT INTO `trans`(`day`, `account_id`, `invoice_id`, `amount`, `type`, `remarks`, `status`) VALUES('$day','$customer','$id','$amntpaid','RP','$referal','1')");
	$id1=mysqli_insert_id($con);

	mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES('$gross','$day','RP','$customer','$id1','1')");

	if ($amntpaid>0) {
		mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES('$amntpaid','$day','RP','$customer','$id1','1')");
	}
	echo $id;

}
else if($from == 'invoice')
{
	$cName   = $_REQUEST['customer'];
	$result3 = mysqli_query($con,"SELECT * FROM accounts WHERE name='$cName'");
	$fetch3  = mysqli_fetch_array($result3);
	$customerId = $fetch3['id'];
	$result4 = mysqli_query($con,"SELECT * FROM scounter WHERE customer='$customerId' AND type!='RS'");
	if(mysqli_num_rows($result4)>0){
		while($fetch4=mysqli_fetch_array($result4)){
			echo '<option>'.$fetch4['id'].'</option>';
		}	
	}
	else{
		echo "<option>Sorry No Invoice Found</option>";
	} 			
}
else if($from == 'invoicep')
{
	$cName   = $_REQUEST['customer'];
	$result3 = mysqli_query($con,"SELECT * FROM accounts WHERE name='$cName'");
	$fetch3  = mysqli_fetch_array($result3);
	$customerId = $fetch3['id'];
	$result4 = mysqli_query($con,"SELECT * FROM pcounter WHERE customer='$customerId' AND type!='RP'");
	if(mysqli_num_rows($result4)>0){
		while($fetch4=mysqli_fetch_array($result4)){
			echo '<option>'.$fetch4['id'].'</option>';
		}	
	}
	else{
		echo "<option>Sorry No Invoice Found</option>";
	} 		
			
}
elseif($from == 'searchp')
{
	$sale_No=0;$table = ''; $counter = 0;
	$cName   = $_REQUEST['customer'];
	$result3 = mysqli_query($con,"SELECT * FROM customer WHERE name = '$cName'");
	$fetch3  = mysqli_fetch_array($result3);
	$cId     = $fetch3['id'];

	$result4 = mysqli_query($con,"SELECT * FROM pcounter WHERE customer = '$cId'");
	if(mysqli_num_rows($result4)>0)
	{
		 $table .= '<thead>
                 <th>Sr #</th>
                    <th>Item ID</th>
                    <th>Date</th>
                    <th>Sale_No</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Final</th>
                    <th>List</th>
                  </tr>
                </thead>
                <tfoot>
                   <th>Sr #</th>
                    <th>Item ID</th>
                    <th>Date</th>
                    <th>Sale_No</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Final</th>
                    <th>List</th>
                    
                  </tr>
                </tfoot>
                <tbody>';
	    while($fetch4 = mysqli_fetch_array($result4))
			{
				$sale_No=$fetch4['id'];
			
		
		
		$result1 = mysqli_query($con,"SELECT * FROM psale WHERE sale_No='$sale_No'");
		while($fetch1=mysqli_fetch_array($result1))
		{ 	$counter++;
			$cd = $fetch1["barcode"];
			$result2 = mysqli_query($con,"SELECT * FROM products WHERE id='$cd'");
			$fetch2 = mysqli_fetch_array($result2);
			$name = $fetch2['name'];
			 $table .='<tr id="'.$fetch1["id"].'">
                    <td>'.$counter.'</td>
                    <td><input style="width:200px;" readonly value='.$fetch1["barcode"].' class="form-control productcode"></td>
                    <td>'.$fetch1["sale_day"].'</td>
                    <td>'.$fetch1["sale_No"].'</td>
                    <td>'.$fetch2["name"].'</td>
                    <td class="adBtn">'.$fetch1["qty"].'</td>
                    <td>'.$fetch1["price"].'</td>
                    <td class="adBtn">'.$fetch1["finalValue"].'</td>                   
                    <td class="adBtn"><div class="btn btn-primary" id="'.$fetch1["id"].'" onclick="
                   addToList(this.id)">Add to List</div></td>
                   </tr>';
                  
          } 
          $table .= '</tbody>';
        }
		echo $table;
		}
	else
	{
		echo "No detail found against invoice number"." (".$sale_No.")";
	}
}
?>