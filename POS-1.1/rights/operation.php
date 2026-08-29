<?php 
session_start();
include ('../connect.php');
$from = $_REQUEST['from'];
$operation = $_REQUEST['operation'];


/* create user start */
if($from=='accounts' && $operation=='insert'){

	$uname = $_POST['uname'];
	$pass = $_POST['pass'];
	$type = $_POST['type'];
	mysqli_query($con,"INSERT INTO `user`(`username`, `password`, `type`, `status`) VALUES ('$uname','$pass','$type','1')");

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
	$result=mysqli_query($con,"SELECT * FROM user");
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
				<td>'.$fetch['username'].'</td>
				<td>'.$fetch['type'].'</td>
				<td>'.$fetch['password'].'</td>
				<td style="width:20%"><div onclick="del('.$fetch['id'].')" class="btn btn-danger">Delete</div> <a href="permission.php?id='.$fetch['id'].'" class="btn btn-default">Permissions</a>
	            </td>
	        </tr>';
	if ($num==$counter) {
		break;
	}

	}
	echo $data."|".$totalRow;
}

if($from=='accounts' && $operation=='delete'){
	$id = $_REQUEST['id'];
	mysqli_query($con,"DELETE FROM `user` WHERE id='$id'");
}

if($from=='accounts' && $operation=='permission'){
	$id = $_REQUEST['userID'];
	$none = $_REQUEST['pagenone'];
	$vedit = $_REQUEST['pageve'];
	
	print_r($_REQUEST);
	/*public function splitandPass($pages,$uid)
    {
        for ($i=0;$i<count($pages);$i++) { 
            $page = explode("/", $pages[$i]);
            $this->InsertorUpdate($page[0],$page[1],$uid);
        }
    }
    public function InsertorUpdate($page,$value,$uid)
    {   
        $count = Permission::where(['pages'=>$page,'user_id'=>$uid])->count();
        if ($count > 0) {
            Permission::where(['pages'=>$page,'user_id'=>$uid])->update(['user_id'=>$uid,'permission'=>$value]);
        }
        elseif ($count == 0) {
            Permission::insert(['user_id'=>$uid,'permission'=>$value,'pages'=>$page]);
        }
    }
	mysqli_query($con,"DELETE FROM `user` WHERE id='$id'");*/
}

/* create user end */
?>