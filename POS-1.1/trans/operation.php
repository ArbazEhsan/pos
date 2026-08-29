<?php 
include('../connect.php');
include('../converter.php');

$from = $_REQUEST['from'];
$operation = $_REQUEST['operation'];

/* cashin start */

if($from=='cashin' && $operation=='insert'){

	$day = $_POST['day'];
	$billNo = $_POST['vno'];
	$tamnt = $_POST['tamnt'];
	$customer = $_POST['customer'];
	$remarks = $_POST['remarks'];
	$amount = $_POST['amount'];

	mysqli_query($con,"INSERT INTO `tcounter`(`day`, `voucher_no`, `total_amnt`, `type`) VALUES ('$day','$billNo','$tamnt','CR')");
	$id = mysqli_insert_id($con);

	foreach ($customer as $key => $value) {
		mysqli_query($con,"INSERT INTO trans (day, account_id, amount, type, remarks, bill_no, status)VALUES('$day','$customer[$key]','$amount[$key]','CR','$remarks[$key]','$id','1')");
		$idd = mysqli_insert_id($con);
		mysqli_query($con,"INSERT INTO `ledgers`(`cr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$amount[$key]','$day','CR','$customer[$key]','$idd','1')");
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

/* cashin end */

/* cashout start */

if($from=='cashout' && $operation=='insert'){
	
	$day = $_POST['day'];
	$billNo = $_POST['vno'];
	$tamnt = $_POST['tamnt'];
	$customer = $_POST['customer'];
	$remarks = $_POST['remarks'];
	$amount = $_POST['amount'];

	mysqli_query($con,"INSERT INTO `tcounter`(`day`, `voucher_no`, `total_amnt`, `type`) VALUES ('$day','$billNo','$tamnt','CO')");
	$id = mysqli_insert_id($con);

	foreach ($customer as $key => $value) {
	  mysqli_query($con,"INSERT INTO trans (day, account_id, amount, type, remarks, bill_no, status)VALUES('$day','$customer[$key]','$amount[$key]','CO','$remarks[$key]','$id','1')");
	  $idd = mysqli_insert_id($con);
	  mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$amount[$key]','$day','CO','$customer[$key]','$idd','1')");
	}
	echo $id;
}

if($from=='viewCashout' && $operation=='show'){
	$num = $_REQUEST['num'];
	$data = ''; $counter = $totalRow = 0;
	$result = mysqli_query($con,"SELECT * FROM tcounter WHERE type='CO' ORDER BY day DESC");
	$totalRow = mysqli_num_rows($result);
	while($fetch = mysqli_fetch_array($result)){
		$counter++;
		$data.='<tr>
				<td>'.date('d-M-Y', strtotime($fetch['day'])).'</td>
				<td>'.$fetch['voucher_no'].'</td>
				<td>'.$fetch['total_amnt'].'</td>
				<td><button onclick="view('.$fetch['id'].')" class="btn btn-primary">View Invoices</button> <a href="editCash.php?id='.$fetch['id'].'&vno='.$fetch['voucher_no'].'&date='.$fetch['day'].'&total='.$fetch['total_amnt'].'&type=CO" class="btn btn-warning">Edit</a> <button onclick="del('.$fetch['id'].')" class="btn btn-danger">Delete</button>
	            </td>
		        </tr>';
		if ($num==$counter) {
			break;
		}
	}
	echo $data."|".$totalRow;
}

if($from=='viewCashout' && $operation=='del'){
	$id = $_REQUEST['id'];

	$result = mysqli_query($con,"SELECT * FROM trans WHERE bill_no='$id'");
	$fetch = mysqli_fetch_array($result);
	mysqli_query($con,"DELETE FROM ledgers WHERE trans_id='".$fetch['id']."'");
	mysqli_query($con,"DELETE FROM trans WHERE bill_no='$id'");
	mysqli_query($con,"DELETE FROM tcounter WHERE id='$id'");

	echo "1";
}

/* cashout end */

if($from='cashManage' && $operation=='update'){
	
	$orderno = $_POST['orderno'];
	$type = $_POST['type'];
	$day = $_POST['day'];
	$billNo = $_POST['vno'];
	$tamnt = $_POST['tamnt'];
	$customer = $_POST['customer'];
	$remarks = $_POST['remarks'];
	$amount = $_POST['amount'];

	mysqli_query($con,"UPDATE `tcounter` SET `day`='$day',`voucher_no`='$billNo',`total_amnt`='$tamnt',`type`='$type' WHERE id='$orderno'");

	$result = mysqli_query($con,"SELECT id FROM trans WHERE bill_no='$orderno'");
	$fetch = mysqli_fetch_array($result);
	mysqli_query($con,"DELETE FROM ledgers WHERE trans_id='".$fetch['id']."'");
	mysqli_query($con,"DELETE FROM trans WHERE bill_no='$orderno'");

	foreach ($customer as $key => $value) {
	  mysqli_query($con,"INSERT INTO trans (day, account_id, amount, type, remarks, bill_no, status)VALUES('$day','$customer[$key]','$amount[$key]','$type','$remarks[$key]','$orderno','1')");
	  $idd = mysqli_insert_id($con);
	  mysqli_query($con,"INSERT INTO `ledgers`(`dr`, `day`, `type`, `account_id`, `trans_id`, `status`) VALUES ('$amount[$key]','$day','$type','$customer[$key]','$idd','1')");
	}
	echo $id;
}

?>